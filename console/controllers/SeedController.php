<?php
namespace console\controllers;

use backend\models\User;
use yii\base\Exception;

class SeedController extends \yii\console\Controller
{

    public function actionIndex($username,$email, $pwd) {
        try {

            if (!$email || !$pwd || !$username) {
                echo "Missing required parameters: email, and/or password, and/or name";
            }
            echo $email."\n";
            echo $pwd."\n";
            echo $username."\n";

            $user = new User();
            $user->email = $email;
            $user->username = $username;
            $user->first_name = "Initial";
            $user->last_name = "Name";
            $user->status = User::STATUS_ACTIVE;
            $user->role = User::ROLE_ADMIN;
            $user->setPassword($pwd);
            $user->generateAuthKey();

            if ($user->save())
                echo 'New User Account: ' . $email . ' created!' . "\n";
            else {
                echo 'Failed to create User account: ' . $email. "\n";
                print_r($user->getErrors());
            }

        } catch (Exception $e) {
            echo $e . "\n";
        }

    }

}