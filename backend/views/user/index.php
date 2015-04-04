<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$loginUser = \Yii::$app->session->get('user');
if($loginUser['role']==\common\models\User::ROLE_ADMIN){
    $this->title = Yii::t('app-gallery', 'Users');
}else{
    $this->title = Yii::t('app-gallery', 'Personal Info Setting');
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $widgetData = [
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
    ];
    if($loginUser['role']==\common\models\User::ROLE_ADMIN){
        ?>
    <p>
        <?= Html::a(Yii::t('app-gallery', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php

    }else{

        $widgetData = [
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'realname',
                'display_name',
                'username',

                //'password',
                'email:email',
                // 'created_at',
                // 'updated_at',
                // 'password_hash',
                // 'password_reset_token',
                // 'auth_key',
                // 'role',

                // 'type',
                'address',
                'phone',
                'id_number',
                // 'id_verify_status',
                //'workplace',
                // 'profile:ntext',
                // 'sex',
                //'publish_books',

                ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {update}'],
            ],
        ];
    }
    ?>

    <?= GridView::widget($widgetData); ?>

</div>
