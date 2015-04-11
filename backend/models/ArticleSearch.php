<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `backend\models\Article`.
 */
class ArticleSearch extends Article
{
    public function rules()
    {
        return [
            [['id', 'gallery_id', 'user_id'], 'integer'],
            [['title', 'created_at', 'content', 'gallery_name', 'user_realname', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $loginUser = User::loginUser();
        if(User::isAdmin()){
            $query = Article::find();
        }else{
            $query = Article::find()->where(['user_id'=>$loginUser['id']]);
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
            'gallery_id' => $this->gallery_id,
            'user_id' => $this->user_id,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'gallery_name', $this->gallery_name])
            ->andFilterWhere(['like', 'user_realname', $this->user_realname]);

        return $dataProvider;
    }
}
