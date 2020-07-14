<?php
/**
 * Created by PhpStorm.
 * User: hidetana
 * Date: 2018/04/04
 * Time: 15:00
 */

namespace backend\components;


use backend\models\User;
use yii\base\Component;
use yii\base\InvalidParamException;

class RoleManager extends Component
{

    public function checkAccess($userId, $permissionName, $params = []){

        if(empty($userId)){
            return false;
        }

        $user = User::findOne($userId);
        switch ($permissionName){

            case User::ROLE_ADMIN:
                return $user->role == User::ROLE_ADMIN ? true : false;
                break;

            case User::ROLE_ADMIN_VIEW:
                return $user->role == User::ROLE_ADMIN_VIEW ? true : false;
                break;

            case User::ROLE_INSTITUTION_ADMIN:
                return $user->role == User::ROLE_INSTITUTION_ADMIN ? true : false;
                break;

            case User::ROLE_INSTITUTION_ADMIN_VIEW:
                return $user->role == User::ROLE_INSTITUTION_ADMIN_VIEW ? true : false;
                break;


            case User::ROLE_FIELD_FARMER:
                return $user->role == User::ROLE_FIELD_FARMER ? true : false;
                break;

            case User::ROLE_FIELD_TECH:
                return $user->role == User::ROLE_FIELD_TECH ? true : false;
                break;

            case User::ROLE_FIELD_BUYER:
                return $user->role == User::ROLE_FIELD_BUYER ? true : false;
                break;

            default:
                throw new InvalidParamException("Unknown Role '{$permissionName}'.");

        }

    }

}