<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Work;

/**
 * WorkSearch represents the model behind the search form about `backend\models\Work`.
 */
class WorkSearch extends Work
{
    public function rules()
    {
        return [
            [['id', 'year', 'width', 'height', 'on_sale', 'mark_count', 'gallery_id', 'user_id', 'hall_id', 'show_room_id'], 'integer'],
            [['name', 'description', 'material', 'work_status','gallery_name', 'hall_name', 'author_name', 'author_profile', 'user_name', 'auction_time', 'auction_price', 'show_room_name', 'qrcode_image', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $loginUser = \Yii::$app->session->get('user');
        if($loginUser['role'] == \common\models\User::ROLE_ADMIN){
            $query = Work::find();
        }else{
            $query = Work::find()->where(['user_id'=>$loginUser['id']]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '10',
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
           // 'id' => $this->id,
            'year' => $this->year,
            'width' => $this->width,
            'height' => $this->height,
            'auction_time' => $this->auction_time,
            'work_status' => $this->work_status=='可见'?'1':'0',
            'on_sale' => $this->on_sale,
            'mark_count' => $this->mark_count,
            'gallery_id' => $this->gallery_id,
            'user_id' => $this->user_id,
            'hall_id' => $this->hall_id,
            'show_room_id' => $this->show_room_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'material', $this->material])
            ->andFilterWhere(['like', 'gallery_name', $this->gallery_name])
            ->andFilterWhere(['like', 'hall_name', $this->hall_name])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'author_profile', $this->author_profile])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'auction_price', $this->auction_price])
            ->andFilterWhere(['like', 'show_room_name', $this->show_room_name])
            ->andFilterWhere(['like', 'qrcode_image', $this->qrcode_image]);

        return $dataProvider;
    }
}
