<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */

$this->title = Yii::t('app-gallery', 'Create Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'oneLevelAddress'=>$oneLevelAddress
    ]) ?>

</div>
