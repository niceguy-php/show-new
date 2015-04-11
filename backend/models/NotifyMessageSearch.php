<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\NotifyMessage;

/**
 * NotifyMessageSearch represents the model behind the search form about `backend\models\NotifyMessage`.
 */
class NotifyMessageSearch extends NotifyMessage
{
    public function rules()
    {
        return [
            [['id', 'from_user_id', 'to_user_id', 'read_status'], 'integer'],
            [['message'], 'safe'],
            [['to_user_name','from_user_name'],'string','max'=>255],
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
            $query = NotifyMessage::find();
        }else{
            $loginUser = User::loginUser();
            if($loginUser['role']==User::ROLE_GALLERY_ADMIN){
                $query = NotifyMessage::find()->where(['to_user_id'=>'gallery'])
                    ->orWhere(['to_user_id'=>'all'])
                    ->orWhere(['to_user_id'=>$loginUser['id']]);
            }else if($loginUser['role']==User::ROLE_ARTIST){
                $query = NotifyMessage::find()->where(['to_user_id'=>'artist'])
                    ->orWhere(['to_user_id'=>'all'])
                    ->orWhere(['to_user_id'=>$loginUser['id']]);
            }else{
                $query = NotifyMessage::find()->where(['to_user_id'=>'user'])
                    ->orWhere(['to_user_id'=>'all'])
                    ->orWhere(['to_user_id'=>$loginUser['id']]);
            }
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
            'from_user_id' => $this->from_user_id,
            'to_user_id' => $this->to_user_id,
            'created_at' => $this->created_at,
            'read_status' => $this->read_status
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'from_user_name', $this->from_user_name])
            ->andFilterWhere(['like', 'to_user_name', $this->from_user_name]);

        return $dataProvider;
    }
}
