<?php

namespace frontend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "members".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property string $last_login_ip
 * @property integer $status
 * @property integer $create_at
 * @property integer $update_at
 * @property integer $openid
 */
class Members extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $code;
    public $password;
    public $sms;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'members';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
//    {
//        return [
//            [['username','tel','email','code','password','password_hash','sms'],'required'],
//            ['password', 'compare', 'compareAttribute' => 'password_hash','message'=>'两次输入的密码必须一致'],
//            [['username'],'unique'],
//            [['tel'],'unique'],
//            [['email','email'],'unique'],
//
//        ];
//    }

    public function rules()
    {
        return [
            [['username','tel','email','password_hash'],'required'],
            ['password', 'compare', 'compareAttribute' => 'password_hash','message'=>'两次输入的密码必须一致'],
            [['username'],'unique'],
            [['tel'],'unique'],
            [['openid'],'safe'],
            [['email','email'],'unique'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password' => '确认密码',
            'email' => '邮箱',
            'tel' => '电话',
            'code'=>'验证码',
            'sms'=>'短信验证码',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }


    //保存之前
    public function beforeSave($insert)
    {
        if($insert){
            $this->create_at = time();
            $this->auth_key = Yii::$app->security->generateRandomString();
            if($this->password_hash){
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        // 根据账号获取ID
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
    }
}
