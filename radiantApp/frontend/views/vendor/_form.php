<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;
use frontend\models\Company;
use frontend\models\CategoryMaster;
use frontend\models\BrandMaster;
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

<div class="vendor-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-md-3">
            <?= $form->field($model, 'company')->textInput(['id'=>'filterCompany']); ?>
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
    <div class="row">
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
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true,'placeholder'=>'Enter Pin Code']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'gst')->textInput(['maxlength' => true]) ?>
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

    <h5>Personal Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'aadhar_no')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'pan_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tan_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput() ?>
        </div>
    </div>

    <h5>Bank Details</h5>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ac_beneficiary_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ac_bank_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ac_number')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ac_type')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'ac_ifsc')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'ac_address')->textInput(['maxlength' => true]) ?>
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
        serviceUrl: '<?= Url::to(['/vendor/autocomplete-company' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            console.log(suggestion);
        },
    });
    fetchbrand = function(e){
        $('#vendor-brand_id').html('<option value="">-- Select --</option>');
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
                        $('#vendor-brand_id').append('<option value="'+idx+'">'+val+'</option>');
                    });
                },
                failure: function(errMsg) {
                    alert(errMsg.message);
                }
            });
        }
        return false;
    }
    
    fetchState = function(e){
        $('#vendor-city_id').html('<option value="">-- Select --</option>');
        $('#vendor-state_id').html('<option value="">-- Select --</option>');
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
                        $('#vendor-state_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#vendor-state_id').val('<?= $model->state_id; ?>');
                        $('#vendor-state_id').trigger('change');
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
        $('#vendor-city_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/country/fetchcity']); ?>',
                data: { 'region': $(e).val(),'country':$('#vendor-country_id').val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#vendor-city_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#vendor-city_id').val('<?= $model->city_id; ?>');
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
        $('#vendor-country_id').val('<?= $model->country_id; ?>');
        $('#vendor-country_id').trigger('change');

        $('#vendor-category_id').val('<?= $model->category_id; ?>');
        $('#vendor-category_id').trigger('change');
    <?php } ?>
});
</script>
