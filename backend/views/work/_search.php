<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\WorkSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'width') ?>

    <?php // echo $form->field($model, 'height') ?>

    <?php // echo $form->field($model, 'material') ?>

    <?php // echo $form->field($model, 'gallery_name') ?>

    <?php // echo $form->field($model, 'hall_name') ?>

    <?php // echo $form->field($model, 'author_name') ?>

    <?php // echo $form->field($model, 'author_profile') ?>

    <?php // echo $form->field($model, 'user_name') ?>

    <?php // echo $form->field($model, 'auction_time') ?>

    <?php // echo $form->field($model, 'auction_price') ?>

    <?php // echo $form->field($model, 'work_status') ?>

    <?php // echo $form->field($model, 'on_sale') ?>

    <?php // echo $form->field($model, 'show_room_name') ?>

    <?php // echo $form->field($model, 'qrcode_image') ?>

    <?php // echo $form->field($model, 'mark_count') ?>

    <?php // echo $form->field($model, 'gallery_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'hall_id') ?>

    <?php // echo $form->field($model, 'show_room_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app-gallery', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app-gallery', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
