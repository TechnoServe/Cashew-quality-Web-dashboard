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

    public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            //'actions' => ['login'],
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
}