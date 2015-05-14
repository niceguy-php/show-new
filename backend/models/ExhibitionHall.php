<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "exhibition_hall".
 *
 * @property string $id
 * @property string $gallery_name
 * @property string $name
 * @property string $address
 * @property string $open_ceremony_time
 * @property string $show_time
 * @property string $close_show_time
 * @property string $planner
 * @property string $organizer
 * @property string $assist
 * @property string $description
 * @property string $artists
 * @property integer $status
 * @property string $user_name
 * @property string $phone
 * @property string $user_id
 * @property string $gallery_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $pic1
 * @property string $pic2
 * @property string $pic3
 * @property string $pic4
 * @property string $pic5
 * @property string show_in_collection
 *
 * @property Comment[] $comments
 * @property Gallery $gallery
 */
class ExhibitionHall extends \yii\db\ActiveRecord
{
    const IN_COLLECTION  = 1;
    const NOT_IN_COLLECTION = 0;
    const OPEN =1;
    const CLOSE =0;
    const EXHIBTION = 1;//普通展览
    const COLLECTION = 2;//馆藏展览
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'exhibition_hall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['name', 'address', 'open_ceremony_time', 'show_time', 'close_show_time', 'planner', 'organizer', 'assist', 'description', 'artists', 'status', 'phone'], 'required'],
            [['gallery_id'],'required','when'=>function($model){
                return User::isAdmin();
            }],
            [['name'],'unique','message'=>\Yii::t('app-gallery','This name has already been taken.')],
            [['open_ceremony_time', 'show_time', 'close_show_time', 'created_at', 'updated_at','full_screen_url'], 'safe'],
            [['description'], 'string'],
            [['status', 'user_id', 'gallery_id','show_in_collection','type'], 'integer'],
            [['gallery_name', 'name', 'address', 'user_name', 'pic1', 'pic2', 'pic3', 'pic4', 'pic5'], 'string', 'max' => 255],
            [['planner'], 'string', 'max' => 200],
            [['organizer'], 'string', 'max' => 300],
            [['assist', 'artists'], 'string', 'max' => 600],
            [['phone'], 'string', 'max' => 20],
            [['pic1','pic2','pic3','pic4','pic5'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
            ['show_in_collection', 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'gallery_name' => Yii::t('app-gallery', 'Gallery Name'),
            'name' => Yii::t('app-gallery', 'Name'),
            'address' => Yii::t('app-gallery', 'Address'),
            'open_ceremony_time' => Yii::t('app-gallery', 'Open Ceremony Time'),
            'show_time' => Yii::t('app-gallery', 'Show Time'),
            'close_show_time' => Yii::t('app-gallery', 'Close Show Time'),
            'planner' => Yii::t('app-gallery', 'Planner'),
            'organizer' => Yii::t('app-gallery', 'Organizer'),
            'assist' => Yii::t('app-gallery', 'Assist'),
            'description' => Yii::t('app-gallery', 'Description'),
            'artists' => Yii::t('app-gallery', 'Artists'),
            'status' => Yii::t('app-gallery', 'Exhibition Status'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'gallery_id' => Yii::t('app-gallery', 'Gallery ID'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'pic1' => Yii::t('app-gallery', 'Pic1'),
            'pic2' => Yii::t('app-gallery', 'Pic2'),
            'pic3' => Yii::t('app-gallery', 'Pic3'),
            'pic4' => Yii::t('app-gallery', 'Pic4'),
            'pic5' => Yii::t('app-gallery', 'Pic5'),
            'show_in_collection'=>Yii::t('app-gallery', 'Show in user collection'),
             'full_screen_url'=>Yii::t('app-gallery','Full Sreen Url'),
            'type'=>Yii::t('app-gallery','展览类型')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['hall_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
