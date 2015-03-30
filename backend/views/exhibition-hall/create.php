<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ExhibitionHall */

$this->title = Yii::t('app-gallery', 'Create Exhibition Hall');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Exhibition Halls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exhibition-hall-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
