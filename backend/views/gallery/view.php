<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Gallery */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app-gallery', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app-gallery', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app-gallery', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            ['attribute'=>'logo','value'=>$model->logo,'format' => ['image',['width'=>'100','height'=>'100']]],
            'master_word',
            'created_at',
            'address',
            'history_profile',
            'phone',
            'fax',
            'email:email',
            'postcode',
            'updated_at',
        ],
    ]) ?>

</div>
