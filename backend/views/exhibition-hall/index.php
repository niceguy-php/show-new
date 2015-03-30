<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ExhibitionHallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app-gallery', 'Exhibition Halls');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exhibition-hall-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app-gallery', 'Create Exhibition Hall'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'address',
            'open_ceremony_time',
            'show_time',
            // 'close_show_time',
            // 'planner',
            // 'organizer',
            // 'assist',
            // 'description',
            // 'artists',
            // 'owner',
            // 'phone',
            // 'created_at',
            // 'updated_at',
            // 'gallery_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
