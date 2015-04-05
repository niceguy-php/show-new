<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\User $model
 */

$this->title = Yii::t('app-gallery', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
