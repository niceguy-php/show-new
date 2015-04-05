<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "show_room".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $user_name
 * @property string $user_id
 * @property integer $status
 * @property string $hall_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Comment[] $comments
 */
class ShowRoom extends \yii\db\ActiveRecord
{
    const MAX_ROOM = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'show_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description','status','name'],'required'],
            [['description'], 'string'],
            [['user_id', 'status', 'hall_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'user_name'], 'string', 'max' => 255]
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
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'status' => Yii::t('app-gallery', 'Room Status'),
            'hall_id' => Yii::t('app-gallery', 'Hall ID'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'updated_at' => Yii::t('app-gallery', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['show_room_id' => 'id']);
    }

    public function addDefaultShowRoom()
    {
        $loginUser = \Yii::$app->session->get('user');
        for($i=0; $i++; $i < self::MAX_ROOM){

            $this->insertInternal(['name'=>'山水田园展厅',
                                'description'=>'与大自然近距离接触，畅游其间',
                                'user_id'=>$loginUser['id'],
                                'user_name'=>$loginUser['user_name'],
                                'status'=>1,
                                'created_at'=>date('Y-m-d H:i:s',time())
            ]);

        }
    }
}
