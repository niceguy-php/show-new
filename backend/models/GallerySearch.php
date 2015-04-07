<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Gallery;

/**
 * GallerySearch represents the model behind the search form about `backend\models\Gallery`.
 */
class GallerySearch extends Gallery
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'master_word', 'created_at', 'address', 'logo', 'history_profile', 'phone', 'fax', 'email', 'postcode', 'updated_at','user_name'], 'safe'],
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
            $query = Gallery::find();
        }else{
            $query = Gallery::find()->where(['user_id'=>User::loginUser()['id']]);
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'master_word', $this->master_word])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'history_profile', $this->history_profile])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'postcode', $this->postcode])
            ->andFilterWhere(['like', 'user_name', $this->user_name]);

        return $dataProvider;
    }
}
