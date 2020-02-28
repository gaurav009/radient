<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use yii\helpers\ArrayHelper;
use frontend\models\Company;
use common\models\User;
use frontend\models\UserMaster;
use frontend\models\DepartmentMaster;
use frontend\models\RoleMaster;
use frontend\models\BrandMaster;
use frontend\models\CategoryMaster;
use frontend\models\Vendor;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;

$authToReporting = ArrayHelper::map(UserMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE, 'is_reporting_manager'=> 1])
                    ->orderBy('first_name')
                    ->all(), 'id', 'first_name'); 
?>

<div class="user-company-form">

    <?php $form = ActiveForm::begin(); ?>

    <h5>Select Own Company</h5>
    <div class="row">

        <?php 
            $company = ArrayHelper::map(Company::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-4">
            <?= $form->field($model, 'company_id')->dropDownList($company,['prompt'=>'--company--']); ?>
        </div>
    </div>

    <h5>Joining Details</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'joining_date')->textInput(['autocomplete'=>'off']); ?>
        </div>
        <div class="col-md-4">
            <?php 
                $hired = ArrayHelper::map(UserMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('first_name')
                    ->all(), 'id', 'first_name'); 
            ?>
            <?= $form->field($model, 'hired_by')->dropDownList($hired,['prompt'=>'--select hired by--']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'cv')->fileInput(); ?>
        </div>
        <div class="col-md-1">
            <?= ''//$model->cv ? Html::a('Resume', ['/download/mycv']) : '' ?>
        </div>
    </div>

    <h5>Official Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['autocomplete'=>'off']); ?>
        </div>
        <?php if($model->isNewRecord){ ?>
            <div class="col-md-3">
                <?= $form->field($model, 'email')->textInput(); ?>
            </div>
        <?php }else { ?>
            <div class="col-md-3">
                <div class="form-group field-usercompany-email required">
                    <label class="control-label" for="usercompany-email">Email</label>
                    <div class="form-control"><?= $model->email; ?></div>
                </div> 
            </div>
        <?php } ?>
        
        <div class="col-md-3">
            <?= $form->field($model, 'whatsapp')->textInput(); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'linkedin')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'twitter')->textInput(); ?>
        </div>
        <div class="col-md-4">
            <?php 
                $department = ArrayHelper::map(DepartmentMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($model, 'department_id')->dropDownList($department,['prompt'=>'--select department--']); ?>
        </div>
    </div>

    <h5>Reporting Hierarchy</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'reporting_level1')->dropDownList($authToReporting, ['prompt'=>'--select reporting boss--']); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'reporting_level2')->dropDownList($authToReporting, ['prompt'=>'--select escalation POC--']); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'reporting_level3')->dropDownList($authToReporting ,['prompt'=>'--select ultimate escalation POC--']); ?>
        </div>
    </div>

    <h5>Communication</h5>
    <div class="row">
        <div class="col-md-4">
            <?php 
                $vendor = ArrayHelper::map(Vendor::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('vendor_code')
                    ->all(), 'id', 'vendor_code'); 
            ?>
            <?= $form->field($model, 'vender_id')->dropDownList($vendor,['prompt'=>'--select vendor--']) ?>
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
            <?= $form->field($model, 'brand_id')->dropDownList($brand,['prompt'=>'--brand--']); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function(){
        $("#usercompany-phone").mask("999-999-9999?99",{placeholder:" "});
        $("#usercompany-whatsapp").mask("999-999-9999?99",{placeholder:" "});
        
        $('#usercompany-joining_date').datepicker({ 
            dateFormat: 'yy-mm-dd',
            minDate: -365, // today
            maxDate: 365, // +90 days from today
        });
        fetchbrand = function(e){
            $('#usercompany-brand_id').html('<option value="">-- Select --</option>');
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
                            $('#usercompany-brand_id').append('<option value="'+idx+'">'+val+'</option>');
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
            $('#usercompany-category_id').val('<?= $model->category_id; ?>');
            $('#usercompany-category_id').trigger('change');
        <?php } ?>
    });
</script>
