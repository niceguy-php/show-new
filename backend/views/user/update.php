<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$role = \Yii::$app->session->get('user')['role'];


$sub_title = ($role == \common\models\User::ROLE_ADMIN) ?
                        Yii::t('app-gallery', 'Update User: ')
                        :Yii::t('app-gallery', 'Edit Personal Info');

$this->title = $sub_title. ' ' . $model->realname;

$sub_title1 = ($role == \common\models\User::ROLE_ADMIN) ?  Yii::t('app-gallery', 'Users'): Yii::t('app-gallery', 'Personal Info Setting');
$this->params['breadcrumbs'][] = ['label' =>$sub_title1, 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
