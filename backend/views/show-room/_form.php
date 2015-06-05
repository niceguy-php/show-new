<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var backend\models\ShowRoom $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="show-room-form">


    <?php

    $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    if(\common\models\User::isAdmin()){
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'full_screen_url'=>['type'=> Form::INPUT_TEXT,  'options'=>['placeholder'=>'输入全景地址...', 'maxlength'=>255]],
            ]
        ]);
    }
    echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

        'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'输入名称...', 'maxlength'=>255]],

        'description'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'输入描述...','rows'=> 6]],

//'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户...', 'maxlength'=>20]],

        'status'=>['type'=> Form::INPUT_RADIO_LIST,  'items'=>['1'=>'开设','0'=>'关闭']],

//'hall_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Hall ID...', 'maxlength'=>20]],

//'created_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

//'updated_at'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],

        //'user_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter 用户姓名...', 'maxlength'=>255]],

    ]



    ]);

    if(\common\models\User::isGalleryAdmin()){
        $work_list = ArrayHelper::map(\backend\models\Work::find()->where(['user_id'=>\common\models\User::loginUser()['id']])->all(),'id','name');
    }else{
        $work_list = ArrayHelper::map(\backend\models\Work::find()->all(),'id','name');
    }

    $selectedWorks = \backend\models\WorkInExhibition::find()->where(['show_room_id'=>$model->id])->asArray()->all();
    $selectedWorksId = ArrayHelper::getColumn($selectedWorks,'work_id');

    echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;">';
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
    echo Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
<?php

\yii\web\YiiAsset::register($this);

$this->beginBlock('CHECK');
echo <<<JS
(function(){
$('.btn-primary').on('click',function(){
    if($('.select2-search-choice').length > 9){
        alert('不能超过9个作品！');
        return false;
    }else{
        $('#w0').submit();
    }
});
})();
JS;
$this->endBlock();
$this->registerJs($this->blocks['CHECK'],\yii\web\View::POS_END);
?>
