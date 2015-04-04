<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$roles = ['1'=>'超级管理员','2'=>'美术馆管理员','3'=>'艺术家','4'=>'普通用户'];

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->realname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app-gallery', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app-gallery', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app-gallery', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'realname',
            'display_name',
            'username',
            ['attribute'=>'sex','value'=>$model->sex==\common\models\User::SEX_MAN?'男':'女'],
            //'password',
            'email:email',
            ['attribute'=>'status','value'=>$model->status==\common\models\User::STATUS_ACTIVE?'允许登录':'禁止登录'],
            ['attribute'=>'avatar','value'=>$model->avatar,'format' => ['image',['width'=>'100','height'=>'100']]],
            ['attribute'=>'created_at','value'=>date("Y-m-d H:i:s",$model->created_at)],
            //'updated_at',
           // 'password_hash',
            //'password_reset_token',
            //'auth_key',
            ['attribute'=>'role','value'=>$roles[$model->role]],
           // 'type',
            'address',
            'phone',
            'id_number',
            //'id_verify_status',
            ['attribute'=>'id_verify_status','value'=>$model->id_verify_status==\common\models\User::USER_VERIFY_SUCCESS?'审核通过':'未审核通过'],
            'workplace',
            'profile:ntext',
            'publish_books',
        ],
    ]) ?>

</div>
