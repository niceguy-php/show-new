<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Subscription $model
 */

$this->title = Yii::t('app-gallery', 'Create Subscription');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Subscriptions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
