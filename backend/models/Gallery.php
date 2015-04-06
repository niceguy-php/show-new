<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gallery".
 *
 * @property string $id
 * @property string $name
 * @property string $master_word
 * @property string $created_at
 * @property string $address
 * @property string $logo
 * @property string $history_profile
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $postcode
 * @property string $user_name
 * @property string $user_id
 * @property string $updated_at
 *
 * @property Article[] $articles
 * @property ExhibitionHall[] $exhibitionHalls
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name', 'master_word', 'created_at', 'address', 'history_profile', 'phone', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'logo'], 'string', 'max' => 255],
            [['master_word', 'history_profile'], 'string', 'max' => 600],
            [['address'], 'string', 'max' => 300],
            [['phone', 'postcode'], 'string', 'max' => 20],
            [['fax'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['user_id'], 'integer'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'message' => \Yii::t('app-gallery','This email address has already been taken.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'name' => Yii::t('app-gallery', 'Name'),
            'master_word' => Yii::t('app-gallery', 'Master Word'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'address' => Yii::t('app-gallery', 'Address'),
            'logo' => Yii::t('app-gallery', 'Gallery Logo'),
            'history_profile' => Yii::t('app-gallery', 'History Profile'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'fax' => Yii::t('app-gallery', 'Fax'),
            'email' => Yii::t('app-gallery', 'Email'),
            'postcode' => Yii::t('app-gallery', 'Postcode'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'user_id' => Yii::t('app-gallery', 'User Id'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['gallery_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExhibitionHalls()
    {
        return $this->hasMany(ExhibitionHall::className(), ['gallery_id' => 'id']);
    }

    public function addDefaultGallery()
    {

        $loginUser = \Yii::$app->session->get('user');
        \Yii::$app->db->createCommand()->insert('gallery',['name'=>'我的美术馆',
            'master_word'=>'艺术之美，在于分享',
            'created_at'=>date('Y-m-d H:i:s',time()),
            'address'=>'成都',
            'logo'=>'/uploads/gallery_logo/default.png',
            'history_profile'=>'我的美术展馆里面有很多珍贵的艺术品哟~',
            'phone'=>'12345678910',
            'email'=>'test@goolya.com',
            'user_id'=>$loginUser['id'],
            'user_name'=>$loginUser['username']
        ])->execute();


    }
}
