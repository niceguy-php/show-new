<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app-gallery', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app-gallery', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'realname',
            'display_name',
            'username',

            //'password',
            'email:email',
            'status',
            // 'created_at',
            // 'updated_at',
            // 'password_hash',
            // 'password_reset_token',
            // 'auth_key',
            // 'role',

            // 'type',
            // 'realname',
            // 'address',
            // 'phone',
            // 'id_number',
            // 'id_verify_status',
            // 'workplace',
            // 'profile:ntext',
            // 'sex',
            // 'publish_books',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
