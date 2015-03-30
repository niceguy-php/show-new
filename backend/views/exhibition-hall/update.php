<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExhibitionHall */

$this->title = Yii::t('app-gallery', 'Update {modelClass}: ', [
    'modelClass' => 'Exhibition Hall',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Exhibition Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="exhibition-hall-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
