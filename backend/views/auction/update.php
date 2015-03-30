<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Auction */

$this->title = Yii::t('app-gallery', 'Update {modelClass}: ', [
    'modelClass' => 'Auction',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Auctions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="auction-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
