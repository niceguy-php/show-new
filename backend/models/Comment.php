<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $id
 * @property string $content
 * @property string $user_name
 * @property string $created_at
 * @property string $user_id
 * @property string $work_id
 * @property string $article_id
 * @property string $show_room_id
 * @property string $hall_id
 *
 * @property Article $article
 * @property ExhibitionHall $hall
 * @property ShowRoom $showRoom
 * @property User $user
 * @property Work $work
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
            [['created_at'], 'safe'],
            [['user_id', 'work_id', 'article_id', 'show_room_id', 'hall_id'], 'integer'],
            [['content'], 'string', 'max' => 500],
            [['user_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'content' => Yii::t('app-gallery', 'Content'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'work_id' => Yii::t('app-gallery', 'Work ID'),
            'article_id' => Yii::t('app-gallery', 'Article ID'),
            'show_room_id' => Yii::t('app-gallery', 'Show Room ID'),
            'hall_id' => Yii::t('app-gallery', 'Hall ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHall()
    {
        return $this->hasOne(ExhibitionHall::className(), ['id' => 'hall_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShowRoom()
    {
        return $this->hasOne(ShowRoom::className(), ['id' => 'show_room_id']);
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
