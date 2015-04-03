<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'avatar')->fileInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'realname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <!--  <?= $form->field($model, 'created_at')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => 32]) ?>-->

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => 50]) ?>

    <!-- <?= $form->field($model, 'type')->textInput() ?>-->



    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'id_number')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'id_verify_status')->textInput() ?>

    <?= $form->field($model, 'workplace')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sex')->textInput() ?>

    <?= $form->field($model, 'publish_books')->textInput(['maxlength' => 600]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app-gallery', 'Create') : Yii::t('app-gallery', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
