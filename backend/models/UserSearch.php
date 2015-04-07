<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'type'], 'integer'],
            [['username', 'display_name', 'avatar', 'password', 'sex', 'address', 'phone', 'email', 'status', 'role', 'realname', 'id_number', 'id_verify_status', 'workplace', 'profile', 'publish_books', 'password_hash', 'password_reset_token', 'auth_key'], 'safe'],
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
            $query = User::find();
        }else{
            $query = User::find()->where(['id'=>$loginUser['id']]);
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
            'type' => $this->type,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'role', $this->role])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'id_number', $this->id_number])
            ->andFilterWhere(['like', 'id_verify_status', $this->id_verify_status])
            ->andFilterWhere(['like', 'workplace', $this->workplace])
            ->andFilterWhere(['like', 'profile', $this->profile])
            ->andFilterWhere(['like', 'publish_books', $this->publish_books])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }
}
