<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "gallery".
 *
 * @property string $id
 * @property string $name
 * @property string $master_word
 * @property string $created_at
 * @property string $address
 * @property string $history_profile
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $postcode
 * @property string $updated_at
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
            [['name', 'address', 'master_word','phone','email','history_profile','postcode'], 'required','message'=>"请输入{attribute}"],
            [['created_at'], 'required','message'=>"请选择{attribute}"],
            //[['logo'], 'required','message'=>"请上传{attribute}"],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['master_word', 'history_profile'], 'string', 'max' => 600],
            [['address'], 'string', 'max' => 300],
            [['phone', 'postcode'], 'string', 'max' => 20],
            [['fax'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['logo'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
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
            'created_at' => Yii::t('app-gallery', 'Gallery Created At'),
            'address' => Yii::t('app-gallery', 'Address'),
            'history_profile' => Yii::t('app-gallery', 'History Profile'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'fax' => Yii::t('app-gallery', 'Fax'),
            'email' => Yii::t('app-gallery', 'Email'),
            'postcode' => Yii::t('app-gallery', 'Postcode'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'logo'=>Yii::t('app-gallery', 'Gallery Logo'),
        ];
    }
}
