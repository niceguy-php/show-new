<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery $model
 */

$this->title = Yii::t('app-gallery', 'Create Gallery');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
