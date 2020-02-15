<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\User;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;

?>
<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>
        
        <div class="row">
            <div class="col-md-3">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'Enter Company Name']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true,'placeholder'=>'Enter Email Id']) ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'phone')->textInput(['placeholder'=>'Enter Phone No']) ?>
            </div>
             <div class="col-md-3">
                <?= $form->field($model, 'gst_no')->textInput(['placeholder'=>'Enter GST No']) ?>
               
   
            </div>
             
        </div>
        <div class="row">
           
            <div class="col-md-4">
                <?= $form->field($model, 'color_code')->textInput(['maxlength' => true,'placeholder'=>'Enter Color code in hex']) ?>
            </div>
            
            
            <div class="col-md-4">
                <?= $form->field($model, 'website')->textInput(['maxlength' => true,'placeholder'=>'Enter Website URL']) ?>
            </div>
            
             <div class="col-md-3">
                <?= $form->field($model, 'upload_logo')->fileInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-1">
                <?php if($model->upload_logo){ ?>
                    <img src="<?= Yii::$app->getUrlManager()->getBaseUrl().'/u/company/'. $model->upload_logo; ?>" style="width: 80px;height: 80px;" />
                <?php } ?>
            </div>
            <div class="col-md-4">
                <?php if(!$model->isNewRecord){ ?>
                    <?= $form->field($model, 'status')->dropDownList([User::STATUS_ACTIVE =>'Active', User::STATUS_INACTIVE=>'Inacive'],['prompt'=>'--status--']); ?>
                <?php } ?>
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
                <?= $form->field($model, 'pin_code')->textInput(['rows' => 6,'placeholder'=>'Enter Pin Code']) ?>
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

        <h4 class="page-title">Social Media Links</h4>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($socialLink, 'instagram')->textInput(['placeholder'=>'Enter instagram URL']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($socialLink, 'facebook')->textInput(['placeholder'=>'Enter facebook URL']) ?>
            </div>
            
            <div class="col-md-4">
                <?= $form->field($socialLink, 'twitter')->textInput(['placeholder'=>'Enter twitter URL']) ?>
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($socialLink, 'linkedin')->textInput(['placeholder'=>'Enter linkedin URL']) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$(document).ready(function(){

    fetchState = function(e){
        $('#company-city_id').html('<option value="">-- Select --</option>');
        $('#company-state_id').html('<option value="">-- Select --</option>');
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
                        $('#company-state_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#company-state_id').val('<?= $model->state_id; ?>');
                        $('#company-state_id').trigger('change');
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
        $('#company-city_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/country/fetchcity']); ?>',
                data: { 'region': $(e).val(),'country':$('#company-country_id').val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#company-city_id').append('<option value="'+idx+'">'+val+' - '+idx+'</option>');
                    });
                    <?php if($model->isNewRecord){ ?>
                        $('#company-city_id').val('<?= $model->city_id; ?>');
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
        $('#company-country_id').val('<?= $model->country_id; ?>');
        $('#company-country_id').trigger('change');
    <?php } ?>
});
</script>



    




