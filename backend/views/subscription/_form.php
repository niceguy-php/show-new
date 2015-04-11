<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var backend\models\Subscription $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="subscription-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    $halls = ArrayHelper::map(\backend\models\ExhibitionHall::findBySql("SELECT h.id,CONCAT(h.name,'(',g.name,')') AS name FROM exhibition_hall h,gallery g WHERE g.id = h.gallery_id")->asArray()->all(),'id','name');

    echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;padding: 0 0">';
    echo '<label class="col-md-2 control-label">'. Yii::t('app-gallery', 'Subscribe Works From Exhibition Halls').'</label>';
    echo '<div class="col-md-10">';
    echo Select2::widget([
        'name' => 'hall_id',
        'data' => $halls,
       // 'value'=>$selectedWorksId,
        'options' => [
            'placeholder' => '选择展厅作品 ...',
            'multiple' => true
        ],
    ]);
    echo '</div></div></div>';


    //查出有真实姓名并且通过实名制认证的用户列表
    $artist = ArrayHelper::map(\backend\models\ExhibitionHall::findBySql("SELECT id,CONCAT(username,'(',realname,')') AS name FROM user WHERE role=3 AND realname IS NOT NULL AND realname <>'' AND status = 1")->asArray()->all(),'id','name');

    echo '<div class="row"><div class="col-sm-12" style="margin-bottom: 20px;padding: 0 0">';
    echo '<label class="col-md-2 control-label">'. Yii::t('app-gallery', 'Subscribe Works From Artists').'</label>';
    echo '<div class="col-md-10">';
    echo Select2::widget([
        'name' => 'artist_id',
        'data' => $artist,
        // 'value'=>$selectedWorksId,
        'options' => [
            'placeholder' => '选择艺术家 ...',
            'multiple' => true
        ],
    ]);
    echo '</div></div></div>';


    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
