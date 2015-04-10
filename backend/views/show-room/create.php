<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ShowRoom $model
 */

$this->title = Yii::t('app-gallery', 'Create Show Room');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Show Rooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="show-room-create">
    <div class="page-header hide">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
