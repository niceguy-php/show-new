<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\Comment $model
 */

$this->title = Yii::t('app-gallery', 'Create {modelClass}', [
    'modelClass' => 'Comment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
