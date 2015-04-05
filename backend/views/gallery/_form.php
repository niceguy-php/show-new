<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
/**
 * @var yii\web\View $this
 * @var backend\models\Gallery $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'type'=>ActiveForm::TYPE_HORIZONTAL]);
    echo $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => array_merge(["" => ""], ArrayHelper::map(\backend\models\User::find()->all(),'id','username')),
        'language' => 'zh',
        'options' => ['placeholder' => 'Select ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入名称...', 'maxlength'=>255]],

'master_word'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入馆长寄语...', 'maxlength'=>600]],

'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

'address'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入地址...', 'maxlength'=>300]],

'history_profile'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入馆史...', 'maxlength'=>600]],

'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入联系电话...', 'maxlength'=>20]],

'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入电子邮箱...', 'maxlength'=>100]],

//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

'logo'=>['type'=> Form::INPUT_FILE, 'options'=>['placeholder'=>'Enter Logo...', 'maxlength'=>255]],

'postcode'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入邮编...', 'maxlength'=>20]],

'fax'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入传真...', 'maxlength'=>50]],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
