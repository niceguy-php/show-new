<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\RecommendApplySearch $searchModel
 */

$this->title = Yii::t('app-gallery', 'Recommend Applies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommend-apply-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app-gallery', 'Create {modelClass}', [
    'modelClass' => 'Recommend Apply',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'apply_user_name','format'=>'raw','value'=>function($model){
                return Html::a($model->apply_user_name,\yii\helpers\Url::to(['user/view','id'=>$model->apply_user_id]));
            }],
            ['attribute'=>'work_name','format'=>'raw','value'=>function($model){
                return Html::a($model->work_name,\yii\helpers\Url::to(['work/view','id'=>$model->work_id]));
            }],
            'apply_reason',
            'gallery_name',
            //'hall_name',
            ['attribute'=>'reply_user_name','value'=>function($model){
                return isset($model->reply_user_name)?$model->reply_user_name:'待审核';
            }],
            ['attribute'=>'replay_content','value'=>function($model){
                return isset($model->replay_content)?$model->replay_content:'待审核';
            }],
            ['attribute'=>'apply_status','value'=>function($model){
                if(\backend\models\RecommendApply::APPLY_DENY == $model->apply_status){
                    return \Yii::t('app-gallery','Apply Deny');
                }else if(\backend\models\RecommendApply::APPLY_PASS == $model->apply_status){
                    return \Yii::t('app-gallery','Apply Pass');
                }else{
                    return \Yii::t('app-gallery','Apply Not Audit');
                }
            }],
            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'work_id', 
//            'hall_id', 
//            'apply_user_id', 
//            'reply_user_id', 
//            'gallery_id', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['recommend-apply/update','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
                'template'=>'{view} {update}'
    /*function($model){
                    if($model->apply_status == \backend\models\RecommendApply::APPLY_PASS){
                        return '{view} {update}';
                    }else{
                        return '{view} {update} {create}';
                    }
                }*/
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'export'=>false,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>\common\models\User::isArtist()?Html::a('<i class="glyphicon glyphicon-plus"></i> '.\Yii::t('app','Add'), ['create'], ['class' => 'btn btn-success']):'',
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.\Yii::t('app','Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
