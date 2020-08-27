<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24/08/2020
 * Time: 14:39
 */
namespace common\models;
use backend\models\Qar;
use yii\queue\JobInterface;
use Yii;



class Notification extends Qar implements JobInterface
{
    // Array of ids
    public $recipients;
    public $title;
    public $body;

    public function execute($queue)
    {

        if(is_array($this->recipients) && !empty($this->recipients)){
            $recipientsObjects = \backend\models\User::find()->where(["in", "id", $this->recipients])->asArray()->all();

            if(!empty($recipientsObjects)){
                // Get emails for the notification
                $emails = array_map(function($items) {
                    return $items["email"];
                }, $recipientsObjects );

                // Send email notification
                $this->sendEmailNotification($emails, $this->title, $this->body);
            }
        }
    }

    public function sendEmailNotification($email, $title, $body){
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailToBuyer-html', 'text' => 'emailToBuyer-text'],
                ['body' => $body,]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->setTo($email)
            ->setSubject($title)
            ->setReplyTo([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->send();
    }
}