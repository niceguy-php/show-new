<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use common\models\User;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\NotifyMessage $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="notify-message-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);
    $user_list['0'] = '@all';
    $user_list['gallery'] = '@所有美术馆' ;
    $user_list['artist'] = '@所有艺术家';
    $user_list['user'] = '@所有普通用户';
    if(User::isAdmin()){
        $user_list = $user_list + ArrayHelper::map(User::find()->all(),'id','username');
    }

    //$user_list = Array\common\models\User::find();
    //array_unshift($user_list,'@all','@所有美术馆','@所有艺术家','@所有普通用户');
    //array_unshift($user_list,'@all');

//    var_dump($user_list);
    echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;padding: 0 0">';
    echo '<label class="col-md-2 control-label">通知接收人</label>';
    echo '<div class="col-md-10">';
    echo Select2::widget([
        'name' => 'user_id',
        'data' => $user_list,
        'value'=>$user_list,
        'options' => [
            'placeholder' => '选择接收通知消息的用户 ，通知所有人选择@all...',
            'multiple' => true
        ],
    ]);
    echo '</div></div></div>';

    echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

//'from_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter From User ID...', 'maxlength'=>20]],

//'to_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter To User ID...', 'maxlength'=>20]],

'message'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入通知内容...','rows'=>12, 'maxlength'=>2000]],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'read_status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Read Status...']],

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Send') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
