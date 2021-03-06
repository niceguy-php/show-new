<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ShowRoom;

/**
 * ShowRoomSearch represents the model behind the search form about `backend\models\ShowRoom`.
 */
class ShowRoomSearch extends ShowRoom
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'hall_id'], 'integer'],
            [['name', 'description', 'user_name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        if(User::isAdmin()){
            $query = ShowRoom::find();
        }else{
            $query = ShowRoom::find()->where(['user_id'=>User::loginUser()['id']]);
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            //'status' => $this->status,
            'hall_id' => $this->hall_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'user_name', $this->user_name]);

        return $dataProvider;
    }
}
