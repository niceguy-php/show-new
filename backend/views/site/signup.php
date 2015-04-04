<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = \Yii::t('app-gallery','Signup');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?=\Yii::t('app-gallery','Please fill out the following fields to signup:');?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                 <?= $form->field($model, 'role')->dropDownList(['2'=>'美术馆','3'=>'艺术家']) ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <!--<?= $form->field($model, 'role')->dropDownList(['2'=>'美术馆','3'=>'艺术家','4'=>'普通用户']) ?>-->

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app-gallery','Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
