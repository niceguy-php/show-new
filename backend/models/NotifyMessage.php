<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "notify_message".
 *
 * @property string $id
 * @property string $from_user_id
 * @property string $to_user_id
 * @property string $message
 * @property string $created_at
 * @property integer $read_status
 */
class NotifyMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notify_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'message', 'created_at'], 'required'],
            [['from_user_id', 'read_status'], 'integer'],
            [['created_at','to_user_id'], 'safe'],
            [['message'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'from_user_id' => Yii::t('app-gallery', 'From User ID'),
            'to_user_id' => Yii::t('app-gallery', 'To User ID'),
            'from_user_name' => Yii::t('app-gallery', 'From User ID'),
            'to_user_name' => Yii::t('app-gallery', 'To User ID'),
            'message' => Yii::t('app-gallery', 'Message'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'read_status' => Yii::t('app-gallery', 'Read Status'),
        ];
    }
}
