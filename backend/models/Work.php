<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "work".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property integer $year
 * @property integer $width
 * @property integer $height
 * @property string $material
 * @property string $gallery_name
 * @property string $hall_name
 * @property string $author_name
 * @property string $author_profile
 * @property string $user_name
 * @property string $auction_time
 * @property string $auction_price
 * @property integer $work_status
 * @property integer $on_sale
 * @property string $show_room_name
 * @property string $qrcode_image
 * @property integer $mark_count
 * @property string $gallery_id
 * @property string $user_id
 * @property string $hall_id
 * @property string $show_room_id
 * @property string $created_at
 * @property string $updated_at
 * @property string show_in_collection
 *
 * @property Auction[] $auctions
 * @property Comment[] $comments
 */
class Work extends \yii\db\ActiveRecord
{
    const IN_COLLECTION  = 1;
    const NOT_IN_COLLECTION = 0;
    const VISIBLE = 1;
    const INVISIBLE = 0;
    const ONSELL = 1;
    const SALESTOP = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'year', 'width', 'height', 'author_name', 'work_status'], 'required'],
            [['name'],'unique','message'=>\Yii::t('app-gallery','This name has already been taken.')],
           // [['image'], 'file', 'skipOnEmpty' => false],
            [['image'], 'file', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],

            [['year', 'width', 'height', 'work_status', 'on_sale', 'mark_count', 'gallery_id', 'user_id', 'hall_id', 'show_room_id','show_in_collection'], 'integer'],
            [['auction_time', 'auction_end_time','created_at', 'updated_at'], 'safe'],
            [['name', 'image', 'material', 'gallery_name', 'hall_name', 'user_name', 'show_room_name', 'qrcode_image'], 'string', 'max' => 255],
            [['description', 'author_profile'], 'string', 'max' => 6000],
            [['author_name'], 'string', 'max' => 100],
            [['auction_price'], 'string', 'max' => 50],
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
            'name' => Yii::t('app-gallery', 'Name'),
            'description' => Yii::t('app-gallery', 'Description'),
            'image' => Yii::t('app-gallery', 'Image'),
            'year' => Yii::t('app-gallery', 'Year'),
            'width' => Yii::t('app-gallery', 'Width'),
            'height' => Yii::t('app-gallery', 'Height'),
            'material' => Yii::t('app-gallery', 'Material'),
            'gallery_name' => Yii::t('app-gallery', 'Gallery Name'),
            'hall_name' => Yii::t('app-gallery', 'Hall Name'),
            'author_name' => Yii::t('app-gallery', 'Author Name'),
            'author_profile' => Yii::t('app-gallery', 'Author Profile'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'auction_time' => Yii::t('app-gallery', 'Auction Time'),
            'auction_end_time' => Yii::t('app-gallery', 'Auction End Time'),
            'auction_price' => Yii::t('app-gallery', 'Auction Price'),
            'work_status' => Yii::t('app-gallery', 'Work Status'),
            'on_sale' => Yii::t('app-gallery', 'On Sale'),
            'show_room_name' => Yii::t('app-gallery', 'Show Room Name'),
            'qrcode_image' => Yii::t('app-gallery', 'Qrcode Image'),
            'mark_count' => Yii::t('app-gallery', 'Mark Count'),
            'gallery_id' => Yii::t('app-gallery', 'Gallery ID'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'hall_id' => Yii::t('app-gallery', 'Hall ID'),
            'show_room_id' => Yii::t('app-gallery', 'Show Room ID'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'show_in_collection'=>Yii::t('app-gallery', 'Show in user collection')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuctions()
    {
        return $this->hasMany(Auction::className(), ['work_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['work_id' => 'id']);
    }
}
