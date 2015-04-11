<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\RecommendApply $model
 */

$apply_status = ['0'=>\Yii::t('app-gallery','Apply Deny'),
    '1'=>\Yii::t('app-gallery','Apply Pass'),
    '2'=>\Yii::t('app-gallery','Apply Not Audit')];

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Recommend Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommend-apply-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'apply_user_name',
            'work_name',
            'apply_reason',
            'gallery_name',
            //'hall_name',
            ['attribute'=>'reply_user_name','value'=>isset($model->reply_user_name)?$model->reply_user_name:\Yii::t('app-gallery','Waiting')],
            ['attribute'=>'replay_content','value'=>isset($model->replay_content)?$model->replay_content:\Yii::t('app-gallery','Waiting')],
            [
                'attribute'=>'created_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            //'work_id',
            //'hall_id',
            //'apply_user_id',
            //'reply_user_id',
            //'gallery_id',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
