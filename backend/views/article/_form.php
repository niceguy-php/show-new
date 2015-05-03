<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\Article;

/**
 * @var yii\web\View $this
 * @var backend\models\Article $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(\common\models\User::isAdmin()){
        echo Form::widget(['model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' =>
                ['show_in_collection'=>['type'=> Form::INPUT_RADIO_LIST,
                    'items'=>['1'=>\Yii::t('app-gallery','Show'),'0'=>\Yii::t('app-gallery','Not Show')]]
                ]
        ]);
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::IDName(),'id','name'),
            'language' => 'zh',
            'options' => ['placeholder' => 'Select ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    }else{
        echo $form->field($model, 'gallery_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\backend\models\Gallery::IDName(\common\models\User::loginUser()['id']),'id','name'),
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

'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入标题...', 'maxlength'=>255]],
        'category'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items'=>[Article::NEWS=>Yii::t('app-gallery','News')
            , Article::EVENTS=>Yii::t('app-gallery','Art Events'),
            Article::RESEARCH=>Yii::t('app-gallery','Art Research')
        ]],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

'content'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入内容...','rows'=> 12]],

//'gallery_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Gallery Name...', 'maxlength'=>255]],

//'user_realname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户姓名...', 'maxlength'=>255]],

//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'gallery_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 所属美术馆...', 'maxlength'=>20]],

//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户...', 'maxlength'=>20]],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
