<?php

namespace common\models;

use Yii;
use common\helpers\SecurityHelper;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $id_faculty
 * @property integer $id_student
 * @property integer $role
 *
 * @property Faculty $idFaculty
 * @property Student $idStudent
 */
class User extends \yii\db\ActiveRecord  implements IdentityInterface
{
    const ROLE_STUDENT = 0;
    const ROLE_INSPECTOR = 1;
    const ROLE_LOCAL_ADMIN = 2;
    const ROLE_ADMIN = 3;

    /**
     * @var string|null Password
     */
    public $password;

    /**
     * @var string|null Repeat password
     */
    public $repassword;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //Required
            [['username', 'auth_key', 'password_hash','email', 'role'], 'required'],
            [['password', 'repassword'], 'required'],
            // Trim
            [['username', 'email', 'password', 'repassword'], 'trim'],
            // String
            [['password', 'repassword'], 'string', 'min' => 1, 'max' => 30],
            //Match
            [['username'],'match','pattern' => '/^[a-z][\w\d@]*$/i'],
            [['password', 'repassword'],'match','pattern' => '/^[\S]+$/'],
            //Type
            [['id_faculty', 'role'], 'integer'],
            [['username'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 250],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 255],
            //Other
            [['username'], 'unique'],
            [['email'], 'email'],
            [['id_faculty'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['id_faculty' => 'id']],
            ['repassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'id_faculty' => 'Факультет',
            'role' => 'Роль',
            'facultyName' => 'Факультет',
            'password' => 'Пароль',
            'repassword' => 'Пароль еще раз',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdFaculty()
    {
        return $this->hasOne(Faculty::className(), ['id' => 'id_faculty']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'id_student']);
    }


    public function getFacultyName()
    {
        return $this->idFaculty->name;
    }


    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates secure key.
     */
    public function generateToken()
    {
        $this->password_reset_token = SecurityHelper::generateExpiringRandomString();
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->username = strtolower($this->username);
            $this->setPassword($this->password);
            // Generate auth and secure keys
            $this->generateAuthKey();
            $this->generateToken();
            // send message
            Yii::$app->mailer->compose([
                'html' => 'signup-html',
                'text' => 'signup-text',
            ],[
                'login' => $this->username,
                'password' => $this->password
              ])->
                setFrom(Yii::$app->params['adminEmail'])->
                setTo($this->email)->
                setSubject('Регистрация пользователя')->
                send();
            return true;
        }
        return false;
    }


    /**
     * Password validation.
     *
     * @param string $password
     *
     * @return boolean
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    /**
     * Find model by username.
     *
     * @param string $username Username
     * @return array|\yii\db\ActiveRecord[] User
     */
    public static function findByUsername($username)
    {
        $query = static::find()->where(['username' => $username]);

        return $query->one();
    }
}
