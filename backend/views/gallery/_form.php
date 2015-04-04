<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>
<? $this->beginBlock('myjs') ?>
$("#gallery-address").change(function(){
var area_id = $(this).val();
$.ajax({
    type: "POST",
    url: "/area/list",
    data:{id:area_id},
    dataType: "json",
    success:function(data){
        console.log(data);
    }
});
//$.ajax();
});
<?php $this->endBlock()?>
<!--<?php $this->registerJs($this->blocks['myjs'],yii\web\View::POS_LOAD)?>-->

<div class="gallery-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'logo')->fileInput() ?>

    <?= $form->field($model, 'master_word')->textarea(['rows' => 3,'maxlength' => 600]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'address')->textInput(['maxlength'=>255])?>

    <?= $form->field($model, 'history_profile')->textarea(['rows' => 3,'maxlength' => 600]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'postcode')->textInput(['maxlength' => 20]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app-gallery', 'Create') : Yii::t('app-gallery', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
