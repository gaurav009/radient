<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;
use frontend\models\Company;
?>

<style>
/* this is for autocomplete */    
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
</style>

<script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/core/jquery.autocomplete.js"></script>
<div class="customer-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>

    <h5>Customer Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Enter Customer Name']) ?>
        </div>
        

        <div class="col-md-3">
            <?= $form->field($model, 'company')->textInput(['id'=>'filterCompany']); ?>
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
        <div class="col-md-3">
            <?= $form->field($model, 'pin_code')->textInput(['maxlength' => true,'placeholder'=>'Enter Pin Code']) ?>
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

    <h5>More Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'aadhar_no')->textInput(['maxlength' => true,'placeholder'=>'Enter Adhar No']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'pan_no')->textInput(['maxlength' => true,'placeholder'=>'Enter PAN No']) ?>
        </div>
        
         <div class="col-md-3">
            <?= $form->field($model, 'gst')->textInput(['maxlength' => true,'placeholder'=>'Enter GST No']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tan_no')->textInput(['maxlength' => true,'placeholder'=>'Enter TAN No']) ?>
        </div>
       
    </div>
    <div class="row">
         <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder'=>'Enter Email Id']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['placeholder'=>'Enter Phone No']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile')->textInput(['placeholder'=>'Enter Mobile No']) ?>
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

    $('#filterCompany').autocomplete({
        serviceUrl: '<?= Url::to(['/customer/autocomplete-company' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            console.log(suggestion);
        },
    });
    fetchState = function(e){
        $('#customer-city_id').html('<option value="">-- Select --</option>');
        $('#customer-state_id').html('<option value="">-- Select --</option>');
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
                        $('#customer-state_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#customer-state_id').val('<?= $model->state_id; ?>');
                        $('#customer-state_id').trigger('change');
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
        $('#customer-city_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/country/fetchcity']); ?>',
                data: { 'region': $(e).val(),'country':$('#customer-country_id').val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#customer-city_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#customer-city_id').val('<?= $model->city_id; ?>');
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
        $('#customer-country_id').val('<?= $model->country_id; ?>');
        $('#customer-country_id').trigger('change');
    <?php } ?>
});
</script>