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
 * @property string $gallery_id
 * @property string $gallery_name
 * @property string $user_realname
 * @property string $user_id
 * @property string $updated_at
 *
 * @property Gallery $gallery
 * @property User $user
 * @property Comment[] $comments
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
            [['title', 'content', 'gallery_id'], 'required'],
            [['title'],'unique','message'=>\Yii::t('app-gallery','This title has already been taken.')],
            [['created_at', 'updated_at'], 'safe'],
            [['content'], 'string'],
            [['gallery_id', 'user_id'], 'integer'],
            [['title', 'gallery_name', 'user_realname'], 'string', 'max' => 255]
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
            'gallery_id' => Yii::t('app-gallery', 'Gallery ID'),
            'gallery_name' => Yii::t('app-gallery', 'Gallery Name'),
            'user_realname' => Yii::t('app-gallery', 'User Realname'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
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
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }
}
