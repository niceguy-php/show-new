<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\ExhibitionHall $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Exhibition Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exhibition-hall-view">
    <div class="page-header hide">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?php

    echo '<div class="row " style="margin-left: 0px;margin-bottom: 20px;"><h3>参展作品</h3>';
    $works = \Yii::$app->db->createCommand("SELECT id,name FROM `work` WHERE id in (SELECT work_id FROM work_in_exhibition where hall_id = :hall_id)")
        ->bindValue(':hall_id',$model->id)->query();
    //    $works_name = array_values($works);
    $works_arr = [];
    foreach($works as $w){
        $a_html = Html::a($w['name'],\yii\helpers\Url::toRoute(['work/view', 'id' => $w['id']]));
        $works_arr[] = $a_html;
    }
    $str = implode('，',$works_arr);
    echo $str ? $str:'你还未配置参展作品~';
    echo '</div>';
    ?>
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
            'full_screen_url',
            'gallery_name',
            'name',
            'address',
            [
                'attribute'=>'open_ceremony_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'show_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'close_show_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            'planner',
            'organizer',
            'assist',
            'description:ntext',
            'artists',
            ['attribute'=>'status',
                'value'=>$model->status==\backend\models\ExhibitionHall::OPEN ?\Yii::t('app-gallery','Open'):\Yii::t('app-gallery','Close')],
            'user_name',
            'phone',
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

            ['attribute'=>'pic1','format' => 'raw','value'=>!empty($model->pic1)?Html::img($model->pic1,['width'=>'200','height'=>'200']):'未上传'],
            ['attribute'=>'pic2','format' => 'raw','value'=>!empty($model->pic2)?Html::img($model->pic2,['width'=>'200','height'=>'200']):'未上传'],
            ['attribute'=>'pic3','format' => 'raw','value'=>!empty($model->pic3)?Html::img($model->pic3,['width'=>'200','height'=>'200']):'未上传'],
            ['attribute'=>'pic4','format' => 'raw','value'=>!empty($model->pic4)?Html::img($model->pic4,['width'=>'200','height'=>'200']):'未上传'],
            ['attribute'=>'pic5','format' => 'raw','value'=>!empty($model->pic5)?Html::img($model->pic5,['width'=>'200','height'=>'200']):'未上传'],
            /*['attribute'=>'pic1','value'=>$model->pic1,'format' => ['image',['width'=>'200','height'=>'200']]],
            ['attribute'=>'pic2','value'=>$model->pic2?$model->pic2:'','format' => ['image',['width'=>'200','height'=>'200']]],
            ['attribute'=>'pic4','value'=>$model->pic4,'format' => ['image',['width'=>'200','height'=>'200']]],
            ['attribute'=>'pic5','value'=>$model->pic5,'format' => ['image',['width'=>'200','height'=>'200']]],*/
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ])


    ?>

</div>
