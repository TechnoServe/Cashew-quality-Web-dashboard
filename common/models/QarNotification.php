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



class QarNotification extends Qar implements JobInterface
{
    public $email;
    public $buyer;

    public function execute($queue)
    {
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailToBuyer-html', 'text' => 'emailToBuyer-text'],
                ['buyer' => $this->buyer,
                ]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->setTo($this->email)
            ->setSubject('Qar creation for ' . $this->buyer)
            ->setReplyTo([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->send();
    }
}