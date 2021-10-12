<?php


namespace api\controllers;


use api\components\ApiError;
use api\components\ApiResponse;
use backend\models\Company;
use api\models\User;
use backend\models\UserEquipment;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\validators\EmailValidator;
use yii\web\UnauthorizedHttpException;

class PublicController extends Controller
{
    const SEND_EMAIL_ACTION_KEY = "SYfLk8tf9GqvEz3R4DjRP9SG9SNz4hssk99F7mVv";
    public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            // 'actions' => ['login'],
                            'allow' => true,
                            'roles' => ['?'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'login' => ['POST'],
                        'send-email' => ['POST'],
                    ],
                ],
            ];
    }


    public function actionLogin(){

        $data = Yii::$app->request->post();

        // Check for username
        if(!$this->keyIsNotEmptyInArray($data, "username")){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, [new ApiError(ApiError::EMPTY_DATA, "Username has to be provided")], false);
        }

        // Check for password
        if(!$this->keyIsNotEmptyInArray($data, "password")){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse(null, [new ApiError(ApiError::EMPTY_DATA, "Username has to be provided")], false);
        }

        $user = User::findByUsername($data["username"]);

        if(empty($user) || !$user->validatePassword($data["password"])){
            throw new UnauthorizedHttpException("Invalid credentials");
        }

        $userArray = $user->toArray();
        $userArray["company_details"] = Company::findOne($user->company_id);
        $user->role == User::ROLE_FIELD_TECH ?  $userArray["equipments"] = UserEquipment::find()->where(['id_user' => $user->id])->asArray()->all() : null;

        return new ApiResponse($userArray, null, true);
    }

    /**
     * Check whether a key is valid and existent in an array
     * @param $array
     * @param $key
     * @return bool
     */
    private function keyIsNotEmptyInArray($array, $key){
        return isset($array[$key]) && !empty($array[$key]);
    }

    public function actionSendEmail(){

        $key = Yii::$app->request->getHeaders();

        if(!isset($key["x-key"]) || $key["x-key"] != self::SEND_EMAIL_ACTION_KEY){
            Yii::$app->response->statusCode = 403;
            return new ApiResponse("Unauthorized", null, false);
        }

        $subject = Yii::$app->request->post("subject");
        $body = Yii::$app->request->post("body");
        $recipients = Yii::$app->request->post("recipients");

        if(!$subject){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse("Subject can not be empty", null, false);
        }

        if(!$body){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse("Body can not be empty", null, false);
        }

        if(!$recipients | !is_array($recipients)){
            Yii::$app->response->statusCode = 400;
            return new ApiResponse("Recipients can not be empty and has to be an array", null, false);
        }

        $validator = new EmailValidator;
        foreach ($recipients as $recipient) {
            if (!$validator->validate($recipient)) {
                Yii::$app->response->statusCode = 400;
                return new ApiResponse("Recipient " . $recipient . " Is not a valid email", null, false);
            }
        }

        try {
            Yii::$app->mailer->compose()
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setTo($recipients)
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();
            return new ApiResponse("Email sent successfully", null, true);
        }catch (\Exception $e){
            Yii::$app->response->statusCode = 500;
            return new ApiResponse("Email could not be sent. Error: ". $e->getMessage(), null, false);
        }
    }

    public function actionSendOtp()
    {
        $key = Yii::$app->request->getHeaders();

        if(!isset($key["x-key"]) || $key["x-key"] != self::SEND_EMAIL_ACTION_KEY){
            Yii::$app->response->statusCode = 403;
            return new ApiResponse("Unauthorized", null, false);
        }
        
        $phone = Yii::$app->request->post("phone");
 
        if(!$phone) {
            Yii::$app->response->statusCode = 400;
            return new ApiResponse("Invalid Phone Number", null, false);
        } else {
 
            try {
                $otp = rand(100000, 999999);
                Yii::$app->cache->set($phone, $otp, 300);
                Yii::$app->response->statusCode = 200;
                return new ApiResponse("OTP Request received successfully", null, true);
            } catch (\Exception $e) {
                Yii::$app->response->statusCode = 500;
                return new ApiResponse("Unable to send OTP", $e->getMessage(), null, false);
            }
        }
    }

}