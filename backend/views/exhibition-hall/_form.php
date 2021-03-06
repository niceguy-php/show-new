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

    <?php $form = ActiveForm::begin(['options'=>['enctype' => 'multipart/form-data'],'type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(\common\models\User::isAdmin()){
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'full_screen_url'=>['type'=> Form::INPUT_TEXT,  'options'=>['placeholder'=>'输入全景地址...', 'maxlength'=>255]],
            ]
        ]);

             echo Form::widget(['model' => $model,
                 'form' => $form,
                 'columns' => 1,
                 'attributes' =>
                     ['show_in_collection'=>['type'=> Form::INPUT_RADIO_LIST,
                         'items'=>['1'=>\Yii::t('app-gallery','Show'),'0'=>\Yii::t('app-gallery','Not Show')]]
                 ]
             ]);
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::find()->all(),'id','name'),
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

        'type'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>\Yii::t('app-gallery','Exhibition'),'2'=>\Yii::t('app-gallery','Collection')]],

'status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>\Yii::t('app-gallery','Open'),'0'=>\Yii::t('app-gallery','Close')]],

//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入用户...', 'maxlength'=>20]],

//'gallery_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入所属美术馆...', 'maxlength'=>20]],



'address'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入地址...', 'maxlength'=>255]],

//'user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入用户姓名...', 'maxlength'=>255]],





    ]


    ]);

    if(\common\models\User::isGalleryAdmin()||\common\models\User::isArtist()){
        $work_list = ArrayHelper::map(\backend\models\Work::find()->where(['user_id'=>\common\models\User::loginUser()['id']])->all(),'id','name');
        $user_recommend_works = \backend\models\RecommendApply::getUserRecommendWorks();
        $work_list = $work_list + ArrayHelper::map($user_recommend_works,'work_id','work_name');
    }else{
        $work_list = ArrayHelper::map(\backend\models\Work::find()->all(),'id','name');
    }

    $selectedWorks = \backend\models\WorkInExhibition::find()->where(['hall_id'=>$model->id])->asArray()->all();
    $selectedWorksId = ArrayHelper::getColumn($selectedWorks,'work_id');

    echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;padding: 0 0">';
    echo '<label class="col-md-2 control-label">参展艺术品</label>';
    echo '<div class="col-md-10">';
    echo Select2::widget([
        'name' => 'work_id',
        'data' => $work_list,
        'value'=>$selectedWorksId,
        'options' => [
            'placeholder' => '选择参展艺术品 ...',
            'multiple' => true
        ],
    ]);
    echo '</div></div></div>';

    echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'planner'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入主策划...', 'maxlength'=>200]],

            'organizer'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入主办方...', 'maxlength'=>300]],
            'assist'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入协助方...', 'maxlength'=>600]],

            'artists'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入参展艺术家...', 'maxlength'=>600]],

            'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入联系电话...', 'maxlength'=>20]],

            'pic1'=>['type'=> Form::INPUT_FILE],
            'pic2'=>['type'=> Form::INPUT_FILE],
            'pic3'=>['type'=> Form::INPUT_FILE],
            'pic4'=>['type'=> Form::INPUT_FILE],
            'pic5'=>['type'=> Form::INPUT_FILE],

        ]


    ]);


    /*echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;">';
    echo '<label class="col-md-2 control-label">上传四张现场图片</label>';
    echo '<div class="col-md-10">';
    echo Html::fileInput('pic1');
    echo Html::fileInput('pic2');
    echo Html::fileInput('pic3');
    echo Html::fileInput('pic4');
    echo '</div></div></div>';
*/

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>



