<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\search\CategoryMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-master-search">

   <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'searchtext')->label('Search') ?>

    <?php ActiveForm::end(); ?>

</div>
