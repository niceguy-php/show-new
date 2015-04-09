<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Work $model
 */

$this->title = Yii::t('app-gallery', 'Update Work') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Works'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="work-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
