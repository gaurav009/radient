<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

use frontend\models\Source;
use common\models\User;
?>

<div class="source-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?php $parent = ArrayHelper::map(Source::find()->asArray()
            ->where(['status' => User::STATUS_ACTIVE, 'parent_id'=> 0])
            ->orderBy('name')
            ->all(), 'id', 'name'); 
    ?>
    <?= $form->field($model, 'parent_id')->dropDownList($parent, ['prompt'=> 'Top Level'] ) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?php if(!$model->isNewRecord){ ?>
        <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
