<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\NotifyMessageSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="notify-message-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'from_user_id') ?>

    <?= $form->field($model, 'to_user_id') ?>

    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'read_status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app-gallery', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app-gallery', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
