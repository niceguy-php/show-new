<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\WorkSearch $searchModel
 */

$this->title = Yii::t('app-gallery', 'Works');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-index">
    <div class="page-header hide">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app-gallery', 'Create {modelClass}', [
    'modelClass' => 'Work',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            ['attribute'=>'image','format'=>'raw','value'=>function($model){
                return Html::img($model->image,['width'=>'70','height'=>'50','alt'=>$model->name]);
            }],
            'name',
            'description',

            'year',
            ['attribute'=>'width','value'=>function($model){
                return $model->width.'cm';
            }],
            ['attribute'=>'height','value'=>function($model){
                return $model->height.'cm';
            }],
//            'material', 
  //          'gallery_name',
//            'hall_name', 
            'author_name',
//            'author_profile', 
//            'user_name', 
//            ['attribute'=>'auction_time','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            'auction_price', 
            ['attribute'=>'work_status','value'=>function($model){
                return $model->work_status==\backend\models\Work::INVISIBLE?'不可见':'可见';
            }],
//            'on_sale', 
//            'show_room_name', 
//            'qrcode_image', 
//            'mark_count', 
//            'gallery_id', 
//            'user_id', 
//            'hall_id', 
//            'show_room_id', 
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'updated_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['work/update','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
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
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
