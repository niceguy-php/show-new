<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "exhibition_hall".
 *
 * @property string $id
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
 * @property string $owner
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 * @property string $gallery_id
 *
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
            [['open_ceremony_time', 'show_time', 'close_show_time', 'created_at', 'updated_at'], 'safe'],
            [['owner', 'gallery_id'], 'integer'],
            [['gallery_id'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
            [['planner'], 'string', 'max' => 200],
            [['organizer', 'assist', 'description'], 'string', 'max' => 300],
            [['artists'], 'string', 'max' => 600],
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
            'owner' => Yii::t('app-gallery', 'Owner'),
            'phone' => Yii::t('app-gallery', 'Phone'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'gallery_id' => Yii::t('app-gallery', 'Gallery ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }
}
