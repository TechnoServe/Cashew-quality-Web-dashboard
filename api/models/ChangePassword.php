<?php

namespace api\models;
use yii\base\Model;


class ChangePassword extends Model

{
    public $current_password;
    public $new_password;
    public $password_repeat;
    
    private $_user;
        
    public function rules()
    {
      return [
            ['current_password', 'required'],
            ['current_password', 'validatePassword'],
            ['new_password', 'required'],
            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute'=>'new_password', 'message'=>"Passwords don't match" ],
        ];
    }
    
    
    public function validatePassword()
    {  
        
        $user = $this->_user;

        if (!$user || !$user->validatePassword($this->current_password)) {
            $this->addError('current_password', 'Your old password was incorrectly typed.');
        }
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);

        return $user->save(false);
    }
}