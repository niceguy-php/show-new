<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `backend\models\Comment`.
 */
class CommentSearch extends Comment
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'work_id', 'article_id', 'show_room_id', 'hall_id'], 'integer'],
            [['content', 'user_name', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'work_id' => $this->work_id,
            'article_id' => $this->article_id,
            'show_room_id' => $this->show_room_id,
            'hall_id' => $this->hall_id,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'user_name', $this->user_name]);

        return $dataProvider;
    }
}
