<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(\common\models\User::isAdmin()){
        echo Form::widget([

            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'username'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入帐号...', 'maxlength'=>100]],

                'password'=>['type'=> Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'输入密码...', 'maxlength'=>100, 'value'=>\common\models\User::DEFAULT_INPUT_PASSWORD]],

                'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入昵称...', 'maxlength'=>50]],

                'avatar'=>['type'=> Form::INPUT_FILE, 'options'=>['placeholder'=>'Enter 头像...', 'maxlength'=>255]],

                'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入电子邮箱...', 'maxlength'=>100]],

                'sex'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>'男','0'=>'女']],

                'status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['0'=>'禁止登录','10'=>'允许登录']],

                'role'=>['type'=> Form::INPUT_DROPDOWN_LIST, 'items'=>['1'=>'超级管理员','2'=>'美术馆管理员','3'=>'艺术家']],

                'id_verify_status'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>'通过','0'=>'不通过']],

                'profile'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入个人简介...','rows'=> 6]],

//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建时间...', 'maxlength'=>20]],

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 更新时间...', 'maxlength'=>20]],

//'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Type...']],

                'id_number'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入身份证号...', 'maxlength'=>100]],

//'password_hash'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Hash...', 'maxlength'=>100]],

//'password_reset_token'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Reset Token...', 'maxlength'=>100]],

                'address'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入地址...', 'maxlength'=>255]],

                'realname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入真实姓名...', 'maxlength'=>255]],

                'workplace'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入工作地址...', 'maxlength'=>255]],

                'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入联系电话...', 'maxlength'=>20]],

                'publish_books'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入发布的书籍...', 'maxlength'=>600]],

//'auth_key'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Auth Key...', 'maxlength'=>32]],

            ]


        ]);
    }else{
        echo Form::widget([

            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [

                'username'=>['type'=> Form::INPUT_STATIC, 'options'=>['placeholder'=>'输入帐号...', 'maxlength'=>100]],

                'password'=>['type'=> Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'输入密码...', 'maxlength'=>100, 'value'=>\common\models\User::DEFAULT_INPUT_PASSWORD]],

                'display_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入昵称...', 'maxlength'=>50]],

                'avatar'=>['type'=> Form::INPUT_FILE, 'options'=>['placeholder'=>'Enter 头像...', 'maxlength'=>255]],

                'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入电子邮箱...', 'maxlength'=>100]],

                'sex'=>['type'=> Form::INPUT_RADIO_LIST, 'items'=>['1'=>'男','0'=>'女']],

                'profile'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入个人简介...','rows'=> 6]],

//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 创建时间...', 'maxlength'=>20]],

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 更新时间...', 'maxlength'=>20]],

//'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Type...']],

                'id_number'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入身份证号...', 'maxlength'=>100]],

//'password_hash'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Hash...', 'maxlength'=>100]],

//'password_reset_token'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Password Reset Token...', 'maxlength'=>100]],

                'address'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入地址...', 'maxlength'=>255]],

                'realname'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入真实姓名...', 'maxlength'=>255]],

                'workplace'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入工作地址...', 'maxlength'=>255]],

                'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入联系电话...', 'maxlength'=>20]],

                'publish_books'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入发布的书籍...', 'maxlength'=>600]],

//'auth_key'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Auth Key...', 'maxlength'=>32]],

            ]


        ]);
    }

    echo Html::submitButton($model->isNewRecord ?
        Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
