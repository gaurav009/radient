<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\CityMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'row_id') ?>

    <?= $form->field($model, 'country_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'geo_lat') ?>

    <?php // echo $form->field($model, 'geo_long') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
