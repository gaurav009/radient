<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="country-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //= $form->field($model, 'cid') ?>

    <?php //= $form->field($model, 'parent_id') ?>

    <?php //= $form->field($model, 'code') ?>

    <?php //= $form->field($model, 'dialing_code') ?>

    <?= $form->field($model, 'name'); ?>

    <?php // echo $form->field($model, 'sorting_order') ?>

    <?php // echo $form->field($model, 'is_active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
