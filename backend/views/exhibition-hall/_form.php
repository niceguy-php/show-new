<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\ExhibitionHall */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exhibition-hall-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'gallery_id')->dropDownList(ArrayHelper::map(\backend\models\Gallery::find()-> select( 'id,name' ) ->all(),'id','name'),['class'=>"form-control inline-block"]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'open_ceremony_time')->textInput() ?>

    <?= $form->field($model, 'show_time')->textInput() ?>

    <?= $form->field($model, 'close_show_time')->textInput() ?>

    <?= $form->field($model, 'planner')->textInput(['maxlength' => 200]) ?>

    <?= $form->field($model, 'organizer')->textInput(['maxlength' => 300]) ?>

    <?= $form->field($model, 'assist')->textInput(['maxlength' => 300]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 300]) ?>

    <?= $form->field($model, 'artists')->textInput(['maxlength' => 600]) ?>

    <?= $form->field($model, 'owner')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app-gallery', 'Create') : Yii::t('app-gallery', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
