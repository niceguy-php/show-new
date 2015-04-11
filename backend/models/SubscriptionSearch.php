<?php

namespace backend\models;

use common\models\User;
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
            [['id', 'user_id','subscrible_id'], 'integer'],
            [['user_name', 'subscrible_name', 'created_at', 'subscrible_type'], 'safe'],
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
            $query = Subscription::find();
        }else{
            $query = Subscription::find()->where(['user_id'=>User::loginUser()['id']]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '10',
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }else{
            var_dump($this->errors);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'subscrible_id' => $this->subscrible_id,
            'created_at' => $this->created_at,
            'subscrible_type'=>$this->subscrible_type=='展厅'?Subscription::HALL:Subscription::ARTIST,
        ]);

        $query->orFilterWhere(['like', 'user_name', $this->user_name])
            ->orFilterWhere(['like', 'subscrible_name', $this->subscrible_name]);

        return $dataProvider;
    }
}
