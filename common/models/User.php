<?php
namespace common\models;

use backend\models\Gallery;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const IN_SUBSCRIBLE  = 1;//在用户订阅中默认显示
    const NOT_IN_SUBSCRIBLE = 0;//在用户订阅中默认不显示
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_ADMIN = 1;
    const ROLE_GALLERY_ADMIN = 2;
    const ROLE_ARTIST = 3;
    const ROLE_USER = 4;
    const USER_VERIFY_SUCCESS = 1;
    const USER_VERIFY_FAIL = 0 ;
    const SEX_MAN = 1;
    const SEX_WOMAN = 0;
    const DISPLAY_PASSWORD = '************';
    const DEFAULT_INPUT_PASSWORD = '!@#********!@#';

    /*private $password_hash ='123456';
    private $status;
    private $created_at;
    private $updated_at;
    private $auth_key;
    private $password;*/

    public static function isAdmin()
    {
        return \Yii::$app->session->get('user')['role']==self::ROLE_ADMIN;
    }

    public static function isGalleryAdmin()
    {
        return \Yii::$app->session->get('user')['role']==self::ROLE_GALLERY_ADMIN;
    }

    public static function isArtist()
    {
        return \Yii::$app->session->get('user')['role']==self::ROLE_ARTIST;
    }

    public static function isLogin(){
        //$user = \Yii::$app->session->get('user');
        $user = self::loginUser();
        return isset($user);
    }

    public static function loginUser(){
        $session_user = \Yii::$app->session->get('user');
        if($session_user){
            return \Yii::$app->session->get('user');
        }else{
            if(isset($_POST['login_id'])){
                return User::findOne($_POST['login_id']);
            }
        }
        
    }

    public static function loginUserVerified()
    {
        return self::loginUser()['id_verify_status']==self::USER_VERIFY_SUCCESS;
    }

    public static function galleryVerified()
    {
        if(self::isGalleryAdmin()){
            $gallery = Gallery::findOne(['user_id'=>self::loginUser()['id']]);
            return $gallery['gallery_status']==Gallery::GALLERY_VERIFY_PASS;
        }else{
            return true;//普通用户或管理员就返回真
        }

    }

    public static function setFlashErrorIfHave()
    {
        if(!self::isAdmin()&&!self::loginUserVerified()){
            \Yii::$app->session->setFlash('user_not_verified',\Yii::t('app-gallery','User not through real-name authentication'));
        }

        if(self::isGalleryAdmin()&&self::loginUserVerified()&&!self::galleryVerified()){
            \Yii::$app->session->setFlash('gallery_not_verified',\Yii::t('app-gallery','Gallery not through authentication'));
        }

    }

    public static function showFlashErrorIfHave()
    {
        if(!User::isAdmin()){
            self::setFlashErrorIfHave();
            self::showWarnFlash('gallery_not_verified');
            self::showWarnFlash('user_not_verified');
        }


    }

    public static function showErrorFlash($flash_name)
    {
        if(\Yii::$app->session->hasFlash($flash_name)){
            echo '<div class="alert alert-danger" role="alert">';
            echo \Yii::$app->session->getFlash($flash_name);
            echo '</div>';
        }

    }

    public static function showWarnFlash($flash_name)
    {
        if(\Yii::$app->session->hasFlash($flash_name)){
            echo '<div class="alert alert-warning" role="alert">';
            echo \Yii::$app->session->getFlash($flash_name);
            echo '</div>';
        }

    }

    public static function showSuccessFlash($flash_name)
    {
        if(\Yii::$app->session->hasFlash($flash_name)){
            echo '<div class="alert alert-success" role="alert">';
            echo \Yii::$app->session->getFlash($flash_name);
            echo '</div>';
        }

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required','message'=>"请输入{attribute}"],
            ['username','unique','message'=>'名称已被占用'],
            ['email', 'email','message'=>'邮箱格式不正确'],
            ['email', 'unique','message'=>'邮箱已被占用'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token=null, $type = null)
    {
        return static::findOne(['username' => $token]);
        //return true;
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
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
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
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
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
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
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app-gallery', 'Username'),
            'password' => Yii::t('app-gallery', 'Password'),

        ];
    }

}
