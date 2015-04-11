<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Subscription;

/**
 * SubscriptionSearch represents the model behind the search form about `backend\models\Subscription`.
 */
class SubscriptionSearch extends Subscription
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'subscrible_type','subscrible_id'], 'integer'],
            [['user_name', 'subscrible_name', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Subscription::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'hall_id' => $this->hall_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'hall_name', $this->hall_name]);

        return $dataProvider;
    }
}
