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
 * @property string $updated_at
 * @property String
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
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'user_id'=>Yii::t('app-gallery', 'User Id'),
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
}
