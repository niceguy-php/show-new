<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\Article $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 标题...', 'maxlength'=>255]], 

'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter 内容...','rows'=> 6]], 

'gallery_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Gallery Name...', 'maxlength'=>255]], 

'user_realname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户姓名...', 'maxlength'=>255]], 

'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'gallery_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 所属美术馆...', 'maxlength'=>20]], 

'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户...', 'maxlength'=>20]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
