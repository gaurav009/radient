<?php
use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
?>

<div class="category-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Enter Category Name']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true,'placeholder'=>'Enter Description']) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
    <?php } ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

