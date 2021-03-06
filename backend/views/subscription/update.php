<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Subscription $model
 */

$this->title = Yii::t('app-gallery', 'Update Subscription') . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="subscription-update">

    <h1 class="hide"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
