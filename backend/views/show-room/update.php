<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ShowRoom $model
 */

$this->title = Yii::t('app-gallery', 'Update Show Room') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Show Rooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app-gallery', 'Update');
?>
<div class="show-room-update">

    <h1 class=" hide"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
