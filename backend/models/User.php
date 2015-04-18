<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $display_name
 * @property string $avatar
 * @property string $password
 * @property string $sex
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property integer $status
 * @property string $role
 * @property string $realname
 * @property string $id_number
 * @property string $id_verify_status
 * @property string $workplace
 * @property string $profile
 * @property string $publish_books
 * @property integer $gallery_num
 * @property integer $show_room_num
 * @property string $created_at
 * @property string $updated_at
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $type
 *
 * @property Auction[] $auctions
 * @property Comment[] $comments
 */

class User extends \yii\db\ActiveRecord
{
    const USER_ON = 10;
    const USER_OFF = 0;
    const SEX_MAN = 1;
    const SEX_WOMAN = 0;

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
            [['username'],'required','when'=>function(){
                return \common\models\User::isAdmin();
            }],
            [['display_name','sex','email'],'required'],

            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('app-gallery','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['username'],'unique','message'=>\Yii::t('app-gallery','This username has already been taken.')],

            [['avatar'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],

            [['profile'], 'string'],
            ['status', 'default', 'value' => \common\models\User::STATUS_ACTIVE],


            [['sex','id_verify_status'],'in',
                'range'=>[\common\models\User::SEX_MAN,\common\models\User::SEX_WOMAN]],
            ['sex', 'default', 'value' => \common\models\User::SEX_MAN],
            ['id_verify_status', 'default', 'value' => \common\models\User::USER_VERIFY_FAIL],

            [['role'],'in',
                'range'=>[\common\models\User::ROLE_ADMIN,\common\models\User::ROLE_GALLERY_ADMIN,\common\models\User::ROLE_ARTIST]
            ],

            [['created_at', 'updated_at', 'type'], 'integer'],
            [['username', 'password', 'email', 'id_number', 'password_hash', 'password_reset_token'], 'string', 'max' => 100],
            [['display_name'], 'string', 'max' => 50],
            [['address', 'realname', 'workplace'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['publish_books'], 'string', 'max' => 600],
            [['auth_key'], 'string', 'max' => 32],

            ['gallery_num', 'required'],
            ['show_room_num', 'required'],
            [['gallery_num'],'integer'],
            [['show_room_num'],'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'username' => Yii::t('app-gallery', 'Username'),
            'display_name' => Yii::t('app-gallery', 'Display Name'),
            'avatar' => Yii::t('app-gallery', 'Avatar'),
            'password' => Yii::t('app-gallery', 'Password'),
            'sex' => Yii::t('app-gallery', 'Sex'),
            'address' => Yii::t('app-gallery', 'Address'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'email' => Yii::t('app-gallery', 'Email'),
            'status' => Yii::t('app-gallery', 'Login Status'),
            'role' => Yii::t('app-gallery', 'Role'),
            'realname' => Yii::t('app-gallery', 'Realname'),
            'id_number' => Yii::t('app-gallery', 'Id Number'),
            'id_verify_status' => Yii::t('app-gallery', 'Id Verify Status'),
            'workplace' => Yii::t('app-gallery', 'Workplace'),
            'profile' => Yii::t('app-gallery', 'Profile'),
            'publish_books' => Yii::t('app-gallery', 'Publish Books'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'password_hash' => Yii::t('app-gallery', 'Password Hash'),
            'password_reset_token' => Yii::t('app-gallery', 'Password Reset Token'),
            'auth_key' => Yii::t('app-gallery', 'Auth Key'),
            'type' => Yii::t('app-gallery', 'Type'),
            'show_room_num'=>Yii::t('app-gallery', 'The Number of Show Rooms'),
            'gallery_num'=>Yii::t('app-gallery', 'The Number of Galleries'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['user_id' => 'id']);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctions()
    {
        return $this->hasMany(Auction::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    public function resetPassword($id,$password){
        $user = static::findOne(['id'=>$id]);

        $user->password_hash = \Yii::$app->security->generatePasswordHash($password);
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->save();
    }
}

