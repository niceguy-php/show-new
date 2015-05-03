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
 * @property string $category
 * @property string show_in_collection
 *
 * @property Gallery $gallery
 * @property User $user
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    const IN_COLLECTION  = 1;//在用户收藏中默认显示
    const NOT_IN_COLLECTION = 0;//在用户收藏中默认不现实
    const NEWS = 1;//新闻
    const EVENTS = 2;//业务动态
    const RESEARCH = 3;//艺术研究
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
            [['gallery_id', 'user_id','category','show_in_collection'], 'integer'],
            [['title', 'gallery_name', 'user_realname','image'], 'string', 'max' => 255],
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
            'title' => Yii::t('app-gallery', 'Title'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'content' => Yii::t('app-gallery', 'Content'),
            'gallery_id' => Yii::t('app-gallery', 'Gallery ID'),
            'gallery_name' => Yii::t('app-gallery', 'Gallery Name'),
            'user_realname' => Yii::t('app-gallery', 'User Realname'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
            'category'=>Yii::t('app-gallery','Article Category'),
            'image'=>Yii::t('app-gallery','Article Image'),
            'show_in_collection'=>Yii::t('app-gallery', 'Show in user collection')
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
