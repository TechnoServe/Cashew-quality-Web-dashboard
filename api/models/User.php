<?php

namespace api\models;

class User extends \backend\models\User
{
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
}