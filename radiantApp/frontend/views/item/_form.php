<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\CategoryMaster;
use frontend\models\BrandMaster;
use frontend\models\Vendor;
?>

<div class="item-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'part_no')->textInput(['maxlength' => true]) ?>
        </div>
        <?php 
            $category = ArrayHelper::map(CategoryMaster::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-3">
            <?= $form->field($model, 'category_id')->dropDownList($category,['prompt'=>'--category--', 'onchange' => 'fetchbrand(this)']); ?>
        </div>

        <?php 
            if($model->isNewRecord){
                $brand = [];
            }else{
                $brand = ArrayHelper::map(BrandMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE, 'category_id'=>$model->category_id ])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            } 
        ?>
        <div class="col-md-3">
            <?= $form->field($model, 'brand_id')->dropDownList($brand,['prompt'=>'--select brand--']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'hsn')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?php $umoArray = ['CM'=>'CM', 'Meter'=>'Meter']; ?>
            <?= $form->field($model, 'uom')->dropDownList($umoArray,['prompt'=>'-- select umo--']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mrp')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>
        </div>
         <div class="col-md-3">
            <?= $form->field($model, 'gst_rate')->textInput(['maxlength' => true]) ?>
        </div>
        
        
    </div>

    <h5>Qty</h5>
    <div class="row">
        <!--<div class="col-md-3">
            <//?= $form->field($model, 'height')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <//?= $form->field($model, 'width')->textInput(['maxlength' => true]) ?>
        </div> !-->
        
        <div class="col-md-3">
            <?= $form->field($model, 'dimension')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?php $unitArray = ['pcs'=>'pcs', 'number'=>'number']; ?>
            <?= $form->field($model, 'unit')->dropDownList($unitArray,['prompt'=>'--select unit--']) ?>
        </div>
    </div>

    <h5>Other Details</h5>
    <div class="row">
        <!--<div class="col-md-3">
            <//?= $form->field($model, 'gst')->textInput(['maxlength' => true]) ?>
        </div> !-->
        <div class="col-md-4">
            <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?php 
                $vendor = ArrayHelper::map(Vendor::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($model, 'vender_id')->dropDownList($vendor,['prompt'=>'--vendor--', 'multiple'=>'multiple']) ?>
        </div>
         <div class="col-md-4">
            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'file')->fileInput() ?>
        </div>
        <div class="col-md-1">
            <?php if($model->file){ ?>
                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl().'/u/item/'. $model->file; ?>" style="width: 80px;height: 80px;" />
            <?php } ?>
        </div>
       
        <div class="col-md-3">
            <?php if(!$model->isNewRecord){ ?>
                <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
            <?php } ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
$(document).ready(function(){
    fetchbrand = function(e){
        $('#item-brand_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/category/fetchbrand']); ?>',
                data: { 'id': $(e).val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#item-brand_id').append('<option value="'+idx+'">'+val+'</option>');
                    });
                },
                failure: function(errMsg) {
                    alert(errMsg.message);
                }
            });
        }
        return false;
    }
    <?php if($model->isNewRecord){ ?>

        $('#item-category_id').val('<?= $model->category_id; ?>');
        $('#item-category_id').trigger('change');
    <?php } ?>
});
</script>
