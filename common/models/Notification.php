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
use backend\models\User;
use yii\base\BaseObject;
use Yii;
class Notification extends BaseObject implements JobInterface
{
    // Array of ids
    public $title;
    public $body;
    public $recipients;
    public function execute($queue)
    {
        if(is_array($this->recipients) && !empty($this->recipients)){
            $recipientsObjects = User::find()->where(["in", "id", $this->recipients])->asArray()->all();
            if(!empty($recipientsObjects)){
                // Get emails for the notification
                $emails = array_map(function($items) {
                    return $items["email"];
                }, $recipientsObjects );
                // Send email notification
                $this->sendEmailNotification($this->title, $this->body, $emails);
            }
        }
    }
    public function sendEmailNotification($title, $body, $email){
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailNotify-html', 'text' => 'emailNotify-text'],
                ['body' => $body,]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->setTo($email)
            ->setSubject($title)
            ->setReplyTo([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->send();
    }
}