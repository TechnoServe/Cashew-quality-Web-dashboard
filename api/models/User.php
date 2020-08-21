<?php

namespace api\models;

class User extends \backend\models\User

{
    public $old_password;
    public $new_password;
    public $repeat_password;

public function fields()

{
        $fields = parent::fields();
        unset(
            $fields['password_hash'],
            $fields['password_reset_token'],
            $fields['auth_key'],
            $fields['verification_token'],
            $fields['updated_at'],
            $fields['company_id'],
            $fields['role']);

        return $fields;
    }

    
    //Define the rules for old_password, new_password and repeat_password with changePwd Scenario.
    
    public function rules()
    {
      return array(
        array('old_password, new_password, repeat_password', 'required', 'on' => 'changePwd'),
        array('old_password', 'findPasswords', 'on' => 'changePwd'),
        array('repeat_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changePwd'),
      );
    }
    
    
    //matching the old password with your existing password.
    public function findPasswords($attribute, $params)
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->password_hash != md5($this->old_password))
            $this->addError($attribute, 'Old password is incorrect.');
    }
}