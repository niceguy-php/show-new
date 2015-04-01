<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $title
 * @property string $created_at
 * @property string $content
 * @property string $user_id
 * @property string $user_realname
 * @property string $updated_at
 *
 * @property User $user
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string'],
            [['user_id'], 'integer'],
            [['title', 'user_realname'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
{
    return [
        'id' => Yii::t('app-gallery', 'ID'),
        'title' => Yii::t('app-gallery', 'Title'),
        'created_at' => Yii::t('app-gallery', 'Created At'),
        'content' => Yii::t('app-gallery', 'Content'),
        'user_id' => Yii::t('app-gallery', 'User ID'),
        'user_realname' => Yii::t('app-gallery', 'User Realname'),
        'updated_at' => Yii::t('app-gallery', 'Updated At'),
    ];
}

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
