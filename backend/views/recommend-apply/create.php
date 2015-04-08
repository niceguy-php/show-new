<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\RecommendApply $model
 */

$this->title = Yii::t('app-gallery', 'Create {modelClass}', [
    'modelClass' => 'Recommend Apply',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Recommend Applies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="recommend-apply-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
