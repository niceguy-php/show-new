<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;


$roles = ['1'=>Yii::t('app-gallery', 'Admin'),
        '2'=>Yii::t('app-gallery', 'Gallery Admin'),
        '3'=>Yii::t('app-gallery', 'Admin'),
        '4'=>Yii::t('app-gallery', 'User')];

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'username',
            'display_name',
            ['attribute'=>'avatar','value'=>$model->avatar,'format' => ['image',['width'=>'100','height'=>'100']]],
            ['attribute'=>'password','value'=>\common\models\User::DISPLAY_PASSWORD],
            ['attribute'=>'sex',
                'value'=>$model->sex==\common\models\User::SEX_MAN?\Yii::t('app-gallery','Male'):Yii::t('app-gallery','Female')],
            'address',
            'phone',
            'email:email',
            ['attribute'=>'status',
                'value'=>$model->status==\common\models\User::STATUS_ACTIVE?\Yii::t('app-gallery','Allow Login'):\Yii::t('app-gallery','Forbid Login')],
            ['attribute'=>'role','value'=>$roles[$model->role]],
            'realname',
            'id_number',
            ['attribute'=>'id_verify_status',
                'value'=>$model->id_verify_status==\common\models\User::USER_VERIFY_SUCCESS?\Yii::t('app-gallery','Yes'):\Yii::t('app-gallery','No')],
            'workplace',
            'profile:ntext',
            'publish_books',
            'gallery_num',
            'show_room_num',
            'publish_books',
            ['attribute'=>'created_at','value'=>date("Y-m-d H:i:s",$model->created_at)],
//            'updated_at',
//            'password_hash',
//            'password_reset_token',
//            'auth_key',
//            'type',
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>

</div>
