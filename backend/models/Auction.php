<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "auction".
 *
 * @property string $id
 * @property string $work_name
 * @property integer $price
 * @property string $start_auction_at
 * @property string $end_auction_at
 * @property string $description
 * @property integer $status
 * @property string $work_id
 * @property string $user_phone
 * @property string $user_id
 * @property string $user_name
 * @property string $created_at
 *
 * @property User $user
 * @property Work $work
 */
class Auction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'status', 'work_id', 'user_id'], 'integer'],
            [['start_auction_at', 'end_auction_at', 'created_at'], 'safe'],
            [['description'], 'string'],
            [['work_name', 'user_name'], 'string', 'max' => 255],
            [['user_phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'work_name' => Yii::t('app-gallery', 'Work Name'),
            'price' => Yii::t('app-gallery', 'Price'),
            'start_auction_at' => Yii::t('app-gallery', 'Start Auction At'),
            'end_auction_at' => Yii::t('app-gallery', 'End Auction At'),
            'description' => Yii::t('app-gallery', 'Description'),
            'status' => Yii::t('app-gallery', 'Status'),
            'work_id' => Yii::t('app-gallery', 'Work ID'),
            'user_phone' => Yii::t('app-gallery', 'User Phone'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(Work::className(), ['id' => 'work_id']);
    }
}
