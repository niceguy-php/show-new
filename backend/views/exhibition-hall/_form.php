<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var backend\models\ExhibitionHall $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="exhibition-hall-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(\common\models\User::isAdmin()){
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::find()->all(),'id','name'),
            'language' => 'zh',
            'options' => ['placeholder' => 'Select ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }else{
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::find()->where(['user_id'=>\common\models\User::loginUser()['user_id']])->all(),'id','name'),
            'language' => 'zh',
            'options' => ['placeholder' => 'Select ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }

    echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        //'gallery_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入美术馆名称...', 'maxlength'=>255]],

        'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入名称...', 'maxlength'=>255]],

        'open_ceremony_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

'show_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'close_show_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

'description'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入描述...','rows'=> 6]],

'status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>\Yii::t('app-gallery','Open'),'0'=>\Yii::t('app-gallery','Close')]],

//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入用户...', 'maxlength'=>20]],

//'gallery_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入所属美术馆...', 'maxlength'=>20]],



'address'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入地址...', 'maxlength'=>255]],

//'user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入用户姓名...', 'maxlength'=>255]],

'planner'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入主策划...', 'maxlength'=>200]],

'organizer'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入主办方...', 'maxlength'=>300]],

'assist'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入协助方...', 'maxlength'=>600]],

'artists'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入参展艺术家...', 'maxlength'=>600]],

'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入联系电话...', 'maxlength'=>20]],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
