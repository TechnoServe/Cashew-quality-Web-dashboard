<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/10/17
 * Time: 3:43 PM
 */

namespace common\helpers;

use backend\models\User;
use linslin\yii2\curl\Curl;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;


class NotificationHelper extends BaseObject implements JobInterface
{

    public $title_en;
    public $title_fr;
    public $title_pt;
    public $body_en;
    public $body_fr;
    public $body_pt;
    public $recipients;
    public $destinations;

    const DESTINATION_APP = 1;
    const DESTINATION_EMAIL = 2;
    const DESTINATION_SMS = 3;


    public function execute($queue)
    {
        print "Starting to send queued notification \n";

        if (is_array($this->recipients) && !empty($this->recipients)) {

            print "Recipients array is not empty \n";

            $recipientsObjects = [];
            try {
                $recipientsObjects = User::findUsersByIdArray($this->recipients);
            } catch (\Exception $e) {
                print $e->getMessage();
            }

            print "found number of users " . count($recipientsObjects) . "\n";

            if (!empty($recipientsObjects)) {

                try {

                    if(in_array( self::DESTINATION_EMAIL, $this->destinations)) {
                        $this->sendEmailNotification($recipientsObjects);
                    }

                    if (in_array(self::DESTINATION_APP, $this->destinations)) {
                        $this->SendPushNotification($recipientsObjects);
                    }

                } catch (\Exception $e) {
                    print $e->getMessage();
                }

            }
        }
    }

    /**
     * Used to send email notification
     * @param $recipientsObjects
     */
    public function sendEmailNotification($recipientsObjects)
    {
        print "Attempting to send email notification to " . count($recipientsObjects) . "\n";

        foreach ($recipientsObjects as $recipientsObject){

            $locale = $this->getRecipientLocale($recipientsObject["language"]);
            $title = "title_".$locale;
            $body = "body_".$locale;
            Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailNotify-html', 'text' => 'emailNotify-text'],
                    [
                        "recipient" => $recipientsObject,
                        "body" => $this->$body,
                        "locale" => $locale
                    ]
                )
                ->setFrom([Yii::$app->params['supportEmail'] => "CashewNutsQualityApp - TNS"])
                ->setTo($recipientsObject["email"])
                ->setSubject($this->$title)
                ->setReplyTo([Yii::$app->params['supportEmail'] => "CashewNutsQualityApp - TNS"])
                ->send();
        }
    }

    /**
     * Send push notification
     * @param $recipientsObjects
     * @return bool
     */
    public function SendPushNotification($recipientsObjects)
    {
        print "Attempting to send push notification to " . count($recipientsObjects) . " tokens\n";

        foreach ($recipientsObjects as $recipientsObject) {

            if(trim($recipientsObject["expo_token"])) {

                $locale = $this->getRecipientLocale($recipientsObject["language"]);
                $title = "title_" . $locale;
                $body = "body_" . $locale;

                try {

                    $data = [
                        "to" => $recipientsObject["expo_token"],
                        "title" => $this->$title,
                        "body" => $this->$body,
                    ];

                    $curl = new Curl();

                    $response = $curl
                        ->setRequestBody(json_encode($data))
                        ->setHeaders([
                            'Content-Type' => 'application/json',
                        ])
                        ->setOption(CURLOPT_RETURNTRANSFER, 1)
                        ->setOption(CURLOPT_POST, 1)
                        ->post("https://exp.host/--/api/v2/push/send");

                    var_dump($response);

                } catch (\Exception $exception) {
                    print $exception->getMessage() . "\n";
                }
            }
        }
        return true;
    }

    private function getRecipientLocale($language)
    {
        return ($language != "en" && $language != "fr" && $language != "pt") ? "en" : $language;
    }
}