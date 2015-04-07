<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ExhibitionHall;

/**
 * ExhibitionHallSearch represents the model behind the search form about `backend\models\ExhibitionHall`.
 */
class ExhibitionHallSearch extends ExhibitionHall
{
    public function rules()
    {
        return [
            [['id', 'status', 'user_id', 'gallery_id'], 'integer'],
            [['gallery_name', 'name', 'address', 'open_ceremony_time', 'show_time', 'close_show_time', 'planner', 'organizer', 'assist', 'description', 'artists', 'user_name', 'phone', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ExhibitionHall::find();

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
            'open_ceremony_time' => $this->open_ceremony_time,
            'show_time' => $this->show_time,
            'close_show_time' => $this->close_show_time,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'gallery_id' => $this->gallery_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'gallery_name', $this->gallery_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'planner', $this->planner])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->andFilterWhere(['like', 'assist', $this->assist])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'artists', $this->artists])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
