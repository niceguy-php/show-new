<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExhibitionHallSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exhibition-hall-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'open_ceremony_time') ?>

    <?= $form->field($model, 'show_time') ?>

    <?php // echo $form->field($model, 'close_show_time') ?>

    <?php // echo $form->field($model, 'planner') ?>

    <?php // echo $form->field($model, 'organizer') ?>

    <?php // echo $form->field($model, 'assist') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'artists') ?>

    <?php // echo $form->field($model, 'owner') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'gallery_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app-gallery', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app-gallery', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
