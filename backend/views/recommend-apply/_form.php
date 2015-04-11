<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use common\models\User;

$apply_status = ['0'=>\Yii::t('app-gallery','Apply Deny'),
    '1'=>\Yii::t('app-gallery','Apply Pass'),
    '2'=>\Yii::t('app-gallery','Apply Not Audit')];
/**
 * @var yii\web\View $this
 * @var backend\models\RecommendApply $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="recommend-apply-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(User::isAdmin()){
       $work_list =  ArrayHelper::map(\backend\models\Work::find()->all(),'id','name');
    }else{
        $work_list = ArrayHelper::map(\backend\models\Work::find()->where(['user_id'=>User::loginUser()['id']])->all(),'id','name');
    }




    if(User::isAdmin() || User::isGalleryAdmin()){
        echo Form::widget([

            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'work_name'=>['type'=> Form::INPUT_STATIC],
                'gallery_name'=>['type'=> Form::INPUT_STATIC],
                'apply_user_name'=>['type'=> Form::INPUT_STATIC],
                'apply_reason'=>['type'=> Form::INPUT_STATIC, 'options'=>['placeholder'=>'输入申请原因...', 'maxlength'=>300]],

'replay_content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入申请回复...', 'maxlength'=>255]],

'apply_status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>$apply_status],

//'work_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 作品...', 'maxlength'=>20]],

//'hall_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 展厅...', 'maxlength'=>20]],



//'reply_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 回复人...', 'maxlength'=>20]],

//'gallery_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 所属美术馆...', 'maxlength'=>20]],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'apply_user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 申请人...', 'maxlength'=>255]],

//'work_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 申请展览作品...', 'maxlength'=>255]],

//'gallery_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 美术馆名称...', 'maxlength'=>255]],

//'hall_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 展厅...', 'maxlength'=>255]],

//'reply_user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 回复人...', 'maxlength'=>255]],

            ]

        ]);
    }else{
        echo $form->field($model, 'work_id')->widget(Select2::classname(), [
            'data' =>$work_list,
            'language' => 'zh',
            'options' => ['placeholder' => 'Select ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::find()->all(),'id','name'),
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
                'apply_reason'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入申请原因...', 'maxlength'=>300]],
            ]
        ]);
    }
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
