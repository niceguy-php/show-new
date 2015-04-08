<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "recommend_apply".
 *
 * @property string $id
 * @property string $apply_user_name
 * @property string $work_name
 * @property string $apply_reason
 * @property string $gallery_name
 * @property string $hall_name
 * @property string $reply_user_name
 * @property string $replay_content
 * @property integer $apply_status
 * @property string $created_at
 * @property string $work_id
 * @property string $hall_id
 * @property string $apply_user_id
 * @property string $reply_user_id
 * @property string $gallery_id
 */
class RecommendApply extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recommend_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['apply_reason', 'replay_content', 'apply_status', 'work_id', 'hall_id', 'apply_user_id', 'reply_user_id', 'gallery_id'], 'required'],
            [['apply_status', 'work_id', 'hall_id', 'apply_user_id', 'reply_user_id', 'gallery_id'], 'integer'],
            [['created_at'], 'safe'],
            [['apply_user_name', 'work_name', 'gallery_name', 'hall_name', 'reply_user_name', 'replay_content'], 'string', 'max' => 255],
            [['apply_reason'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'apply_user_name' => Yii::t('app-gallery', 'Apply User Name'),
            'work_name' => Yii::t('app-gallery', 'Work Name'),
            'apply_reason' => Yii::t('app-gallery', 'Apply Reason'),
            'gallery_name' => Yii::t('app-gallery', 'Gallery Name'),
            'hall_name' => Yii::t('app-gallery', 'Recommend To Exhibition Hall'),
            'reply_user_name' => Yii::t('app-gallery', 'Reply User Name'),
            'replay_content' => Yii::t('app-gallery', 'Replay Content'),
            'apply_status' => Yii::t('app-gallery', 'Apply Status'),
            'created_at' => Yii::t('app-gallery', 'Apply Datetime'),
            'work_id' => Yii::t('app-gallery', 'Work ID'),
            'hall_id' => Yii::t('app-gallery', 'Recommend To Exhibition Hall'),
            'apply_user_id' => Yii::t('app-gallery', 'Apply User ID'),
            'reply_user_id' => Yii::t('app-gallery', 'Reply User ID'),
            'gallery_id' => Yii::t('app-gallery', 'Recommend To Gallery'),
        ];
    }
}
