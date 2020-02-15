<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role_id')->textInput() ?>

    <?= $form->field($model, 'access_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
