<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Auction */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Auctions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auction-view">

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
            'work_name',
            'price',
            'start_auction_at',
            'end_auction_at',
            'description:ntext',
            'status',
            'work_id',
            'user_phone',
            'user_id',
            'user_name',
            'created_at',
        ],
    ]) ?>

</div>
