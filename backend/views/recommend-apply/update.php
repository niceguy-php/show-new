<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\RecommendApply $model
 */

$this->title = Yii::t('app-gallery', 'Update {modelClass}: ', [
    'modelClass' => 'Recommend Apply',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Recommend Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="recommend-apply-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
