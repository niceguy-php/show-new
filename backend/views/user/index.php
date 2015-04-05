<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;


$roles = ['1'=>Yii::t('app-gallery', 'Admin'),
    '2'=>Yii::t('app-gallery', 'Gallery Admin'),
    '3'=>Yii::t('app-gallery', 'Admin'),
    '4'=>Yii::t('app-gallery', 'User')];
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\UserSearch $searchModel
 */

$this->title = $roles== \common\models\User::isAdmin() ? Yii::t('app-gallery', 'Users') : Yii::t('app-gallery', 'Personal Info Setting');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app-gallery', 'Create {modelClass}', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           //'id',
            'username',
            'display_name',
            //'avatar',
            //'password',
//            'sex', 
            'address',
            'phone',
            'email:email',
            //'role',
            //['attribute'=>'role','value'=>$roles[$model->role]],
            'realname',
//            'id_number', 
//            'id_verify_status', 
//            'workplace', 
//            'profile:ntext', 
//            'publish_books', 
//            'created_at', 
//            'updated_at', 
//            'password_hash', 
//            'password_reset_token', 
//            'auth_key', 
//            'type', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['user/update','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
                'template'=>\common\models\User::isAdmin()?'{view} {update} {delete}':'{view} {update}',

            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'export'=>false,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>\common\models\User::isAdmin() ? Html::a('<i class="glyphicon glyphicon-plus"></i> '.\Yii::t('app','Add'), ['create'], ['class' => 'btn btn-success']):'',
            'after'=>\common\models\User::isAdmin() ? Html::a('<i class="glyphicon glyphicon-repeat"></i>'.\Yii::t('app','Reset List'), ['index'], ['class' => 'btn btn-info']):'',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
