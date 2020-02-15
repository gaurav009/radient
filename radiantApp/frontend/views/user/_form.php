<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
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
<div class="user-master-form col-md-12">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <h5>Personal Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone_home')->textInput() ?>
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-3">
            <?= $form->field($model, 'phone_emergency')->textInput() ?>
        </div>
        <div class="col-md-3">
        <?php  $countryArray = ArrayHelper::map(CountryMaster::find()->asArray()
                ->where(['is_active' => 'Y','parent_id'=>'0'])
                ->orderBy('sorting_order,name')->all(), 'cid', 'name');
            $country = [];
            foreach($countryArray as $cKey => $cValue){
                $country[$cKey] = $cValue.' - '.$cKey; //India 91
                //$country[$cKey] = $cValue.' ( '.$cKey.')'; //India (91)  
            } ?>
            <?= $form->field($model, 'country_id')->dropDownList($country,['prompt'=>'-- Country --','onchange'=>'fetchState(this)']) ?>
        </div>


        <?php 
            if($model->isNewRecord){
                $state = []; 
                $city = [];
            }else{
                $state = ArrayHelper::map(CountryMaster::find()->asArray()
                    ->where(['is_active' => 'Y','parent_id' => $model->country_id])
                    ->orderBy('sorting_order,name')->all(), 'cid', 'name');
                
                $city = ArrayHelper::map(CityMaster::find()->asArray()
                    ->where(['status' => 'Y','region_id'=>$model->state_id,'country_id'=>$model->country_id])
                    ->orderBy('name')->all(), 'row_id', 'name'); 
                
            }
        ?>
        <div class="col-md-3">
        <?= $form->field($model, 'state_id')->dropDownList($state,['prompt'=>'-- State --','onchange'=>'fetchCity(this)']); ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'city_id')->dropDownList($city,['prompt'=>'-- City --']) ?>
        </div>
    </div>
   
   <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'pin_code')->textInput(['rows' => 6,'placeholder'=>'Enter Pin Code']) ?>
        </div>
        <div class="col-md-3">
            <?php 
                $role = ArrayHelper::map(RoleMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->andWhere(['!=', 'id', 1])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($model, 'role')->dropDownList($role , ['prompt'=>'-- Role --']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'address')->textarea(['rows' => 6,'placeholder'=>'Enter Address']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'address_1')->textarea(['rows' => 6,'placeholder'=>'Enter Address']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'address_2')->textarea(['rows' => 6,'placeholder'=>'Enter Address']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'address_3')->textarea(['rows' => 6,'placeholder'=>'Enter Address']) ?>
        </div>
    </div>

    <h5>Select Own Company</h5>
    <div class="row">

        <?php 
            $company = ArrayHelper::map(Company::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-4">
            <?= $form->field($userCompany, 'company_id')->dropDownList($company,['prompt'=>'--company--']); ?>
        </div>
    </div>

    <h5>Joining Details</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($userCompany, 'joining_date')->textInput(['autocomplete'=>'off']); ?>
        </div>
        <div class="col-md-4">
            <?php 
                $hired = ArrayHelper::map(UserMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('first_name')
                    ->all(), 'id', 'first_name'); 
            ?>
            <?= $form->field($userCompany, 'hired_by')->dropDownList($hired,['prompt'=>'--select hired by--']); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($userCompany, 'cv')->fileInput(); ?>
        </div>
        <div class="col-md-1">
            <?= ''//$userCompany->cv ? Html::a('Resume', ['/download/mycv']) : '' ?>
        </div>
    </div>

    <h5>Official Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($userCompany, 'phone')->textInput(['autocomplete'=>'off']); ?>
        </div>
        <?php if($model->isNewRecord){ ?>
            <div class="col-md-3">
                <?= $form->field($userCompany, 'email')->textInput(); ?>
            </div>
        <?php }else { ?>
            <div class="col-md-3">
                <div class="form-group field-usercompany-email required">
                    <label class="control-label" for="usercompany-email">Email</label>
                    <div class="form-control"><?= $userCompany->email; ?></div>
                </div> 
            </div>
        <?php } ?>
        
        <div class="col-md-3">
            <?= $form->field($userCompany, 'whatsapp')->textInput(); ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($userCompany, 'linkedin')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($userCompany, 'twitter')->textInput(); ?>
        </div>
        <div class="col-md-4">
            <?php 
                $department = ArrayHelper::map(DepartmentMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($userCompany, 'department_id')->dropDownList($department,['prompt'=>'--select department--']); ?>
        </div>
    </div>

    <h5>Reporting Hierarchy</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($userCompany, 'reporting_level1')->dropDownList($authToReporting, ['prompt'=>'--select reporting boss--']); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($userCompany, 'reporting_level2')->dropDownList($authToReporting, ['prompt'=>'--select escalation POC--']); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($userCompany, 'reporting_level3')->dropDownList($authToReporting ,['prompt'=>'--select ultimate escalation POC--']); ?>
        </div>
    </div>

    <h5>Communication</h5>
    <div class="row">
        <div class="col-md-4">
            <?php 
                $vendor = ArrayHelper::map(Vendor::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($userCompany, 'vender_id')->dropDownList($vendor,['prompt'=>'--select vendor--']) ?>
        </div>
        
        <?php 
            $category = ArrayHelper::map(CategoryMaster::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-3">
            <?= $form->field($userCompany, 'category_id')->dropDownList($category,['prompt'=>'--category--', 'onchange' => 'fetchbrand(this)']); ?>
        </div>

        <?php 
            if($model->isNewRecord){
                $brand = [];
            }else{
                $brand = ArrayHelper::map(BrandMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE, 'category_id'=>$userCompany->category_id ])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            } 
        ?>
        <div class="col-md-3">
            <?= $form->field($userCompany, 'brand_id')->dropDownList($brand,['prompt'=>'--brand--']); ?>
        </div>
    </div>

    <?php  if($model->isNewRecord){ ?>
    <h5>Login Details</h5>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'password')->passwordInput([]); ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cpassword')->passwordInput([]); ?>
        </div>
    </div>
    <?php  } ?>

    <?= $form->field($model, 'agree_tc')->checkbox() ?>
    <?= $form->field($model, 'is_reporting_manager')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
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
        $('#usercompany-category_id').val('<?= $userCompany->category_id; ?>');
        $('#usercompany-category_id').trigger('change');
    <?php } ?>
});

</script>

<script>
$(document).ready(function(){
    fetchState = function(e){
        $('#usermaster-city_id').html('<option value="">-- Select --</option>');
        $('#usermaster-state_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/country/fetchstate']); ?>',
                data: { 'id': $(e).val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#usermaster-state_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#usermaster-state_id').val('<?= $model->state_id; ?>');
                        $('#usermaster-state_id').trigger('change');
                    <?php } ?>
                },
                failure: function(errMsg) {
                    alert(errMsg.message);
                }
            });
        }
        return false;
    }
    
    fetchCity = function(e){
        $('#usermaster-city_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/country/fetchcity']); ?>',
                data: { 'region': $(e).val(),'country':$('#usermaster-country_id').val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#usermaster-city_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#usermaster-city_id').val('<?= $model->city_id; ?>');
                    <?php } ?>
                },
                failure: function(errMsg) {
                    alert(errMsg.message);
                }
            });
        }
        return false;
    }

    <?php if($model->isNewRecord){ ?>
        $('#usermaster-country_id').val('<?= $model->country_id; ?>');
        $('#usermaster-country_id').trigger('change');
    <?php } ?>
});
</script>
