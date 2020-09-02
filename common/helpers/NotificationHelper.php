<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/10/17
 * Time: 3:43 PM
 */

namespace common\helpers;
use backend\models\User;
use Yii;
use yii\base\BaseObject;
use yii\helpers\Json;
use yii\queue\JobInterface;


class NotificationHelper extends BaseObject implements JobInterface
{

    public $title;
    public $body;
    public $recipients;
    public $destinations;
    public $type;

    const DESTINATION_APP = 1;
    const DESTINATION_EMAIL = 2;
    const DESTINATION_SMS = 3;


    public function execute($queue)
    {
        print "Starting to send queued notification \n";

        if(is_array($this->recipients) && !empty($this->recipients)){

            print "Recipients array is not empty \n";

            $recipientsObjects = [];
            try {
                $recipientsObjects = User::findUsersByIdArray($this->recipients);
            }catch (\Exception $e){
                print $e->getMessage();
            }

            print "found number of users " . count($recipientsObjects) ."\n";

            if(!empty($recipientsObjects)){
                // Get emails for the notification
                $emails = array_map(function($item) {
                    return $item["email"];
                }, $recipientsObjects );

                // Get tokens for the notification
                $tokens = array_map(function($item) {
                    return $item["expo_token"];
                }, $recipientsObjects );

                // Send email and push notification

                try {
                    if($this->destinations.contains(self::DESTINATION_EMAIL))
                        $this->sendEmailNotification($this->title, $this->body, $emails);

                    if($this->destinations.contains(self::DESTINATION_APP))
                        $this->SendPushNotification($tokens, $this->title, $this->body, $this->type);

                } catch (\Exception $e){
                    print $e->getMessage();
                }

            }
        }
    }

    /**
     * Used to send email notification
     * @param $title
     * @param $body
     * @param $email
     */
    public function sendEmailNotification($title, $body, $emails){
        Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailNotify-html', 'text' => 'emailNotify-text'],
                ['body' => $body,]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->setTo($emails)
            ->setSubject($title)
            ->setReplyTo([Yii::$app->params['supportEmail'] => "CashewNutsApp - TNS"])
            ->send();
    }

    /**
     * Send push notification
     * @param $to
     * @param $title
     * @param $body
     * @param $type
     * @return bool
     */
    public static function SendPushNotification($to, $title, $body,$type)
    {

        $ch = curl_init();
        $data[] = [
            "to" => $to,
            "data"=> [
                "type"=>$type,
            ],
            "title" => $title,
            "body" => $body,

        ];

        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Json::encode($data));
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $res = 'Error:' . curl_error($ch);
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return true;
    }

}