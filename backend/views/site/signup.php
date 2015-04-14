<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm   col-md-offset-3*/

$this->title = \Yii::t('app-gallery','Signup');
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div style="float: left;width:500px"><img class="" src="/uploads/system/logo_image1.png" width="100%"> </div>
<div class="site-signup " >
    <h1 class=""><?= Html::encode($this->title) ?></h1>

    <p><?=\Yii::t('app-gallery','Please fill out the following fields to signup:');?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                 <?= $form->field($model, 'role')->dropDownList(['2'=>'机构用户（美术馆、艺术馆、博物馆、画廊商、拍卖行）','3'=>'个人用户（艺术家、艺术爱好者、收藏家、其它）']) ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <!--<?= $form->field($model, 'role')->dropDownList(['2'=>'机构用户','3'=>'个人用户','4'=>'普通用户']) ?>-->

                <div style="color:#999;margin:1em 0">
                    <?=\Yii::t('app-gallery','Already have a account ')?><?= Html::a(\Yii::t('app-gallery','Login'), ['site/login']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton(\Yii::t('app-gallery','Signup'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

</div>