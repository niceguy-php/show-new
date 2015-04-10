<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\ExhibitionHall $model
 */

$this->title = Yii::t('app-gallery', 'Create Exhibition Hall');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Exhibition Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exhibition-hall-create">
    <div class="page-header hide">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
