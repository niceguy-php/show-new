<?php

namespace backend\models;

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
 *
 * @property Comment[] $comments
 * @property Gallery $gallery
 */
class ExhibitionHall extends \yii\db\ActiveRecord
{
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
            [['name', 'address', 'open_ceremony_time', 'show_time', 'close_show_time', 'planner', 'organizer', 'assist', 'description', 'artists', 'status', 'phone', 'gallery_id'], 'required'],
            [['open_ceremony_time', 'show_time', 'close_show_time', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['status', 'user_id', 'gallery_id'], 'integer'],
            [['gallery_name', 'name', 'address', 'user_name'], 'string', 'max' => 255],
            [['planner'], 'string', 'max' => 200],
            [['organizer'], 'string', 'max' => 300],
            [['assist', 'artists'], 'string', 'max' => 600],
            [['phone'], 'string', 'max' => 20]
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
