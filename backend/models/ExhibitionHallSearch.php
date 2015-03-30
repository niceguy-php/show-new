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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner', 'gallery_id'], 'integer'],
            [['name', 'address', 'open_ceremony_time', 'show_time', 'close_show_time', 'planner', 'organizer', 'assist', 'description', 'artists', 'phone', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ExhibitionHall::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'open_ceremony_time' => $this->open_ceremony_time,
            'show_time' => $this->show_time,
            'close_show_time' => $this->close_show_time,
            'owner' => $this->owner,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gallery_id' => $this->gallery_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'planner', $this->planner])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->andFilterWhere(['like', 'assist', $this->assist])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'artists', $this->artists])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
