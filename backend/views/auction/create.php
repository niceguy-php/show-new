<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Auction */

$this->title = Yii::t('app-gallery', 'Create Auction');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Auctions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auction-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
