<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
?>

<div class="role-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Enter Role']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true,'placeholder'=>'Enter Decription']) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

