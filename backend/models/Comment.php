<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $id
 * @property string $work_name
 * @property string $content
 * @property string $user_name
 * @property string $created_at
 * @property string $user_id
 * @property string $work_id
 * @property string $article_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['work_name', 'content', 'user_name'], 'required'],
            [['created_at'], 'safe'],
            [['user_id', 'work_id', 'article_id'], 'integer'],
            [['work_name', 'user_name'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 500]
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
            'content' => Yii::t('app-gallery', 'Comment Content'),
            'user_name' => Yii::t('app-gallery', 'Comment User Name'),
            'created_at' => Yii::t('app-gallery', 'Comment Time'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'work_id' => Yii::t('app-gallery', 'Work ID'),
            'article_id' => Yii::t('app-gallery', 'Article ID'),
        ];
    }
}
