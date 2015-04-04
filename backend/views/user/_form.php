<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
$role = \Yii::$app->session->get('user')['role'];
$admin_condition = ($role==\common\models\User::ROLE_ADMIN);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $admin_condition ?$form->field($model, 'username')->textInput(['maxlength' => 100]):'' ?>

    <?= $form->field($model, 'display_name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'avatar')->fileInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 100,'name'=>'password','value'=>'!@#********!@#']) ?>

    <?= $form->field($model, 'sex')->radioList(['1'=>'男','0'=>'女']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?=$admin_condition ? $form->field($model, 'status')->radioList(['0'=>'禁止登录','10'=>'允许登录']):'' ?>

    <!--  <?= $form->field($model, 'created_at')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => 32]) ?>-->

    <?=$admin_condition ?  $form->field($model, 'role')->dropDownList(['1'=>'超级管理员','2'=>'美术馆管理员','3'=>'艺术家']):'' ?>

    <!-- <?= $form->field($model, 'type')->textInput() ?>-->
    <?= $form->field($model, 'realname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'id_number')->textInput(['maxlength' => 100]) ?>

    <?=$admin_condition ?  $form->field($model, 'id_verify_status')->radioList(['1'=>'通过','0'=>'不通过']) :''?>

    <?= $form->field($model, 'workplace')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>



    <?= $form->field($model, 'publish_books')->textInput(['maxlength' => 600]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app-gallery', 'Create') : Yii::t('app-gallery', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
