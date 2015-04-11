<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\RecommendApply;

/**
 * RecommendApplySearch represents the model behind the search form about `backend\models\RecommendApply`.
 */
class RecommendApplySearch extends RecommendApply
{
    public function rules()
    {
        return [
            [['id', 'work_id', 'hall_id', 'apply_user_id', 'reply_user_id', 'gallery_id'], 'integer'],
            [['apply_user_name', 'work_name','apply_status', 'apply_reason', 'gallery_name', 'hall_name', 'reply_user_name', 'replay_content', 'created_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {

        $apply_status = [\Yii::t('app-gallery','Apply Deny')=>0,
            \Yii::t('app-gallery','Apply Pass')=>1,
            \Yii::t('app-gallery','Apply Not Audit')=>2];

        $loginUser = User::loginUser();
        if(User::isAdmin()){
            $query = RecommendApply::find();
        }else if(User::isGalleryAdmin()){
            $my_gallery_id = Gallery::find()->where(['user_id'=>$loginUser['id']])->one()['id'];
            $query = RecommendApply::find()->where(['gallery_id'=>$my_gallery_id]);
        }else if(User::isArtist()){
            $query = RecommendApply::find()->where(['apply_user_id'=>$loginUser['id']]);
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
            'apply_status' => $apply_status[$this->apply_status],
            'created_at' => $this->created_at,
            'work_id' => $this->work_id,
            'hall_id' => $this->hall_id,
            'apply_user_id' => $this->apply_user_id,
            'reply_user_id' => $this->reply_user_id,
            'gallery_id' => $this->gallery_id,
        ]);

        $query->andFilterWhere(['like', 'apply_user_name', $this->apply_user_name])
            ->andFilterWhere(['like', 'work_name', $this->work_name])
            ->andFilterWhere(['like', 'apply_reason', $this->apply_reason])
            ->andFilterWhere(['like', 'gallery_name', $this->gallery_name])
            ->andFilterWhere(['like', 'hall_name', $this->hall_name])
            ->andFilterWhere(['like', 'reply_user_name', $this->reply_user_name])
            ->andFilterWhere(['like', 'replay_content', $this->replay_content]);

        return $dataProvider;
    }
}
