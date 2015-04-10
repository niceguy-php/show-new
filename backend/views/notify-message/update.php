<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\NotifyMessage $model
 */

$this->title = Yii::t('app-gallery', 'Update Notify Message') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Notify Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="notify-message-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
