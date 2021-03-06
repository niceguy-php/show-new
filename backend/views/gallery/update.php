<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery $model
 */

$this->title = Yii::t('app-gallery', 'Update Gallery: ') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="gallery-update">

    <h1 class="hide"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
