<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
            //'password',
            'email:email',
            'status',
            ['attribute'=>'avatar','value'=>$model->avatar,'format' => ['image',['width'=>'100','height'=>'100']]],
            ['attribute'=>'created_at','value'=>date("Y-m-d H:i:s",$model->created_at)],
            //'updated_at',
           // 'password_hash',
            //'password_reset_token',
            //'auth_key',
            'role',
           // 'type',
            'address',
            'phone',
            'id_number',
            'id_verify_status',
            'workplace',
            'profile:ntext',
            'sex',
            'publish_books',
        ],
    ]) ?>

</div>
