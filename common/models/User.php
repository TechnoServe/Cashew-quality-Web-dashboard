<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $language
 * @property int $status
 * @property string $created_at
 * @property int $role
 * @property string $updated_at
 * @property string|null $verification_token
 *
 * @property UserEquipment[] $userEquipments
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 1;

    const STATUS_INACTIVE = 2;

    const ROLE_ADMIN = 1;

    const ROLE_ADMIN_VIEW = 2;

    const ROLE_FIELD_TECH = 3;

    const ROLE_FIELD_BUYER = 4;

    const ROLE_FIELD_FARMER = 5;

    public $pass;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'username',
                    'first_name',
                    'last_name',
                    'auth_key',
                    'pass',
                    'email',
                    'role',
                ],
                'required',
            ],
            [['status', 'role'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [
                [
                    'username',
                    'first_name',
                    'middle_name',
                    'last_name',
                    'password_hash',
                    'password_reset_token',
                    'email',
                    'address',
                    'verification_token',
                ],
                'string',
                'max' => 255,
            ],
            [['auth_key'], 'string', 'max' => 32],
            [['phone', 'language'], 'string', 'max' => 64],
            [['username'], 'unique'],
            [['email'], 'trim'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            ['pass', 'string', 'min' => 6]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'pass' => Yii::t('app', 'Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'language' => Yii::t('app', 'Language'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'role' => Yii::t('app', 'Role'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }

    /**
     * Gets query for [[UserEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEquipments()
    {
        return $this->hasMany(UserEquipment::className(), ['id_user' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Get User Role
     */
    public function getRole()
    {
        if ($this->role == $this::ROLE_ADMIN) {
            return Yii::t('app', 'Admin');
        } else if ($this->role == $this::ROLE_ADMIN_VIEW) {
            return Yii::t('app', 'Admin View');
        } else if ($this->role == $this::ROLE_FIELD_TECH) {
            return Yii::t('app', 'Field Tech');
        } else if ($this->role == $this::ROLE_FIELD_BUYER) {
            return Yii::t('app', 'Buyer');
        } else if ($this->role == $this::ROLE_FIELD_FARMER) {
            return Yii::t('app', 'Farmer');
        } else {
            return 'Super Admin';
        }
    }

    /**
     * Get User Status
     */
    public function getStatus()
    {
        $s = Yii::t('app', 'Active');
        if ($this->status == 1)
            $s = Yii::t('app', 'Active');
        else if ($this->status == 2)
            $s = Yii::t('app', 'Inactive');
        return $s;
    }

    /**
     * Get Full Name
     */
    public function getFullName()
    {
        if (empty($this->middle_name)) {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
        }
    }
}
