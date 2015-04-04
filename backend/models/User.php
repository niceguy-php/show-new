<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $role
 * @property string $display_name
 * @property integer $type
 * @property string $realname
 * @property string $address
 * @property string $phone
 * @property string $id_number
 * @property integer $id_verify_status
 * @property string $workplace
 * @property string $profile
 * @property integer $sex
 * @property string $publish_books
 *
 * @property Article[] $articles
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
            [['username','display_name','sex','email'],'required','message'=>'请输入{attribute}'],
            [['username'],'unique','message'=>\Yii::t('app-gallery','This username has already been taken.')],
            [['status', 'created_at', 'updated_at', 'role', 'type', 'id_verify_status', 'sex'], 'integer'],
            [['profile'], 'string'],
            [['username', 'password', 'email', 'password_hash', 'password_reset_token', 'id_number'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['display_name'], 'string', 'max' => 50],
            [['realname', 'address', 'workplace'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['publish_books'], 'string', 'max' => 600],
            [['avatar'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
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
            'password' => Yii::t('app-gallery', 'Password'),
            'email' => Yii::t('app-gallery', 'Email'),
            'status' => Yii::t('app-gallery', 'User Status'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'password_hash' => Yii::t('app-gallery', 'Password Hash'),
            'password_reset_token' => Yii::t('app-gallery', 'Password Reset Token'),
            'auth_key' => Yii::t('app-gallery', 'Auth Key'),
            'role' => Yii::t('app-gallery', 'Role'),
            'display_name' => Yii::t('app-gallery', 'Nickname'),
            'type' => Yii::t('app-gallery', 'Type'),
            'realname' => Yii::t('app-gallery', 'Realname'),
            'address' => Yii::t('app-gallery', 'Address'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'id_number' => Yii::t('app-gallery', 'Id Number'),
            'id_verify_status' => Yii::t('app-gallery', 'Id Verify Status'),
            'workplace' => Yii::t('app-gallery', 'Workplace'),
            'profile' => Yii::t('app-gallery', 'Profile'),
            'sex' => Yii::t('app-gallery', 'Sex'),
            'avatar' => Yii::t('app-gallery', 'Avatar'),
            'publish_books' => Yii::t('app-gallery', 'Publish Books'),
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
}
