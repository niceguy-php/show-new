<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\ShowRoom $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Show Rooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="show-room-view">
    <div class="page-header hide">
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
            'name',
            'description:ntext',
            'user_name',
            //'user_id',
            ['attribute'=>'status',
                'value'=>$model->status==\backend\models\ShowRoom::OPEN?\Yii::t('app-gallery','Open'):\Yii::t('app-gallery','Close')],
            //'hall_id',
            [
                'attribute'=>'created_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'updated_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
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

    <?php

    echo '<div class="row" style="margin-left: 0px;"><h3>参展作品</h3>';
    $works = \Yii::$app->db->createCommand("SELECT id,name FROM `work` WHERE id in (SELECT work_id FROM work_in_exhibition where show_room_id = :show_room_id)")
        ->bindValue(':show_room_id',$model->id)->query();
    $works_arr = [];
    foreach($works as $w){
        $a_html = Html::a($w['name'],\yii\helpers\Url::toRoute(['work/view', 'id' => $w['id']]));
        $works_arr[] = $a_html;
    }
    $str = implode('，',$works_arr);
    echo $str ? $str:'你还未配置参展作品~';
    echo '</div>';
    ?>

</div>
