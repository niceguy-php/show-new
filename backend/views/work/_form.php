<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var backend\models\Work $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="work-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data'],'type'=>ActiveForm::TYPE_HORIZONTAL]);

    echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [
        'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入名称...', 'maxlength'=>255]],

'description'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入描述...', 'maxlength'=>6000]],

'year'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入创作年代']],

        'image'=>['type'=> Form::INPUT_FILE, 'options'=>['placeholder'=>'Enter Image...', 'maxlength'=>255]],

        'width'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入作品宽度，单位厘米（cm）...']],

'height'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入作品长度，单位厘米（cm）...']],

        'material'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入作品材质...', 'maxlength'=>255]],

        'author_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入作者名字...', 'maxlength'=>100]],

        'author_profile'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入作者简介...', 'maxlength'=>6000]],


        'work_status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>'对外可见','0'=>'不可见']],



//'mark_count'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mark Count...']],



//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户...', 'maxlength'=>20]],

//'hall_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'选择展厅...', 'maxlength'=>20]],

//'show_room_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Show Room ID...', 'maxlength'=>20]],
'on_sale'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>'是','0'=>'否']],
'auction_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

        'auction_end_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'gallery_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 美术馆名称...', 'maxlength'=>255]],

 //       'hall_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 展厅...', 'maxlength'=>255]],

//'user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户姓名...', 'maxlength'=>255]],

//'show_room_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Show Room Name...', 'maxlength'=>255]],

//'qrcode_image'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Qrcode Image...', 'maxlength'=>255]],

'auction_price'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入作品的拍卖底价，单位（元）...', 'maxlength'=>50]],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
