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
    const OPEN = 1;
    const CLOSE = 0;
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
            [['created_at', 'updated_at','full_screen_url'], 'safe'],
            [['name', 'user_name'], 'string', 'max' => 255],
            [['name'],'unique','message'=>\Yii::t('app-gallery','This name has already been taken.')],
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
            'full_screen_url'=>Yii::t('app-gallery','Full Sreen Url'),
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


        //$dbUser = User::find(['id'=>$loginUser['id']]);
        //$num =  empty($dbUser->show_room_num)? 5 : $dbUser->show_room_num ;
        $num = 5;
        for($i=1; $i<= $num; $i++)
        {
            \Yii::$app->db->createCommand()->insert('show_room',['name'=>$loginUser['username'].'微展'.$i,
                'description'=>'拥有微展、拥有互联网思维！站内艺术家将通过本站向您推荐作品，经您审核编辑后，该艺术家的推荐作品将出现在您的微展厅内。每个作品只能推荐给一家艺术机构展示，请珍视这一份托付。',
                'user_id'=>$loginUser['id'],
                'user_name'=>$loginUser['username'],
                'status'=>0,
                'created_at'=>date('Y-m-d H:i:s',time())
            ])->execute();

        }
        //echo '<br/>';
        //echo '<br/>';
        //echo '<br/>';
//        var_dump($dbUser);

    }
}
