<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\CategoryMaster;
use yii\helpers\ArrayHelper;
use frontend\models\BrandMaster;

//echo '<pre>'; print_r($model->errors); print_r($errors);  die();
?>

<div class="brand-master-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $category = ArrayHelper::map(CategoryMaster::find()->asArray()
            ->where(['status' => User::STATUS_ACTIVE])
            ->orderBy('name')
            ->all(), 'id', 'name'); 
    ?>
     <?php if($model->isNewRecord){ ?>
    
    <?= $form->field($model, 'category_id')->dropDownList($category,['prompt'=>'--category--','multiple'=>'multiple']); ?>
    <?php } else {?>
     <?= $form->field($model, 'category_id')->dropDownList($category,['prompt'=>'--category--']); ?>
    <?php } ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Enter Name']) ?>
    
    <div class="form-group">
        <?php if(isset($errors['name']) && is_array($errors['name'])){ 
            foreach ($errors['name'] as $error){ ?>
                <div class="help-block"><?= $error; ?></div>
        <?php } } ?>
    </div>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true,'placeholder'=>'Enter Description']) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
    <?php } ?>
    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


