<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\RecommendApplySearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="recommend-apply-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'apply_user_name') ?>

    <?= $form->field($model, 'work_name') ?>

    <?= $form->field($model, 'apply_reason') ?>

    <?= $form->field($model, 'gallery_name') ?>

    <?php // echo $form->field($model, 'hall_name') ?>

    <?php // echo $form->field($model, 'reply_user_name') ?>

    <?php // echo $form->field($model, 'replay_content') ?>

    <?php // echo $form->field($model, 'apply_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'work_id') ?>

    <?php // echo $form->field($model, 'hall_id') ?>

    <?php // echo $form->field($model, 'apply_user_id') ?>

    <?php // echo $form->field($model, 'reply_user_id') ?>

    <?php // echo $form->field($model, 'gallery_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app-gallery', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app-gallery', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
