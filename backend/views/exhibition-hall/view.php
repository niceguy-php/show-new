<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ExhibitionHall */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Exhibition Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exhibition-hall-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app-gallery', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app-gallery', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app-gallery', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'address',
            'open_ceremony_time',
            'show_time',
            'close_show_time',
            'planner',
            'organizer',
            'assist',
            'description',
            'artists',
            'owner',
            'phone',
            'created_at',
            'updated_at',
            'gallery_id',
        ],
    ]) ?>

</div>
