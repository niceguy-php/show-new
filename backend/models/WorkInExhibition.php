<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "work_in_exhibition".
 *
 * @property string $id
 * @property string $work_id
 * @property string $show_room_id
 * @property string $hall_id
 */
class WorkInExhibition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_in_exhibition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_id'], 'required'],
            [['id', 'work_id', 'show_room_id', 'hall_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'work_id' => Yii::t('app-gallery', 'Work ID'),
            'show_room_id' => Yii::t('app-gallery', 'Show Room ID'),
            'hall_id' => Yii::t('app-gallery', 'Hall ID'),
        ];
    }
}
