<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = \Yii::t('app-gallery','Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="float: left;width:500px"><img class="" src="/uploads/system/logo_image1.png" width="100%"> </div>
<div class="site-login" style="">
    <h1 class=""><?= Html::encode($this->title) ?></h1>

    <p><?=\Yii::t('app-gallery','Please fill out the following fields to login:')?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    <?=\Yii::t('app-gallery','If you forgot your password you can ')?><?= Html::a(\Yii::t('app-gallery','reset it'), ['site/request-password-reset']) ?>.
                </div>
                <div style="color:#999;margin:1em 0">
                    <?=\Yii::t('app-gallery','Do not have a account ')?><?= Html::a(\Yii::t('app-gallery','Signup'), ['site/signup']) ?>.
                </div>
                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app-gallery','Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
