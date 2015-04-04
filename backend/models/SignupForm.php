<?php
namespace backend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' =>\Yii::t('app-gallery', 'This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('app-gallery','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['role','in','range'=>[User::ROLE_ARTIST,User::ROLE_GALLERY_ADMIN]],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->role = $this->role;
//            $user->password = $this->password;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->password = md5($this->password);

            if ($user->save()) {
                return $user;
            }else{



               // echo '<br/>';
                //echo '<br/>';
                //echo '<br/>';
                //var_dump($user->errors);
               // return $user->errors;
            }


        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app-gallery', 'Username'),
            'password' => Yii::t('app-gallery', 'Password'),
            'email' => Yii::t('app-gallery', 'Email'),
            'role' =>  Yii::t('app-gallery', 'Role'),
        ];
    }
}
