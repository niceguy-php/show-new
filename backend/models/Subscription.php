<?php

namespace backend\models;


use Yii;
use common\models\User;

/**
 * This is the model class for table "subscription".
 *
 * @property string $id
 * @property string $user_name
 * @property string $user_id
 * @property string $hall_name
 * @property string $hall_id
 * @property string $created_at
 */
class Subscription extends \yii\db\ActiveRecord
{
    const ARTIST = 1;
    const HALL = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subscrible_id'], 'integer'],
            [['created_at'], 'safe'],
            [['user_name', 'subscrible_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app-gallery', 'ID'),
            'user_name' => Yii::t('app-gallery', 'User Name'),
            'user_id' => Yii::t('app-gallery', 'User ID'),
            'subscrible_name' => Yii::t('app-gallery', 'Subscription Name'),
            'subscrible_id' => Yii::t('app-gallery', 'Hall ID'),
            'created_at' => Yii::t('app-gallery', 'Created At'),
            'subscrible_type'=>Yii::t('app-gallery','Subscription Type')
        ];
    }

    public static function subscrible_artist($param){
        if(isset($param['$artist_id'])){
            $loginUser = User::loginUser();
            foreach($param['$artist_id'] as $aid){
                $artist = User::findOne(['id'=>$aid]);
                \Yii::$app->db->createCommand()->insert('subscription',[
                    'user_id'=>$loginUser['id'],
                    'user_name'=>$loginUser['username'].'('.$loginUser['realname'].')',
                    'subscrible_id'=>$aid,
                    'subscrible_name'=>$artist['username'].'('.$artist['realname'].')',
                    'subscrible_type'=>Subscription::ARTIST,
                    'created_at'=>date('Y-m-d H:i:s',time())

                ])->execute();
            }
        }

    }

    public static function subscrible_hall($param){

        if(isset($param['hall_id'])) {
            $loginUser = User::loginUser();
            foreach ($param['hall_id'] as $hid) {
                $hall = ExhibitionHall::findOne(['id' => $hid]);
                \Yii::$app->db->createCommand()->insert('subscription', [
                    'user_id' => $loginUser['id'],
                    'user_name' => $loginUser['username'] . '(' . $loginUser['realname'] . ')',
                    'subscrible_id' => $hid,
                    'subscrible_name' => $hall['name'],
                    'subscrible_type' => Subscription::HALL,
                    'created_at' => date('Y-m-d H:i:s', time())
                ])->execute();
            }
        }

    }
}
