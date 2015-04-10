<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\NotifyMessage $model
 */

$this->title = Yii::t('app-gallery', 'Create Notify Message');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Notify Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notify-message-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
