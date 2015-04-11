<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'work_name'=>['type'=> Form::INPUT_STATIC, 'options'=>['placeholder'=>'Enter 申请展览作品...', 'maxlength'=>255]],

'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入评论内容...', 'maxlength'=>500]],

'user_name'=>['type'=> Form::INPUT_STATIC],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户...', 'maxlength'=>20]],

//'work_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 作品...', 'maxlength'=>20]],

//'article_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Article ID...', 'maxlength'=>20]],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
