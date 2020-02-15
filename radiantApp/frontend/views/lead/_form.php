<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\Company;
use frontend\models\CategoryMaster;
use frontend\models\BrandMaster;
use frontend\models\DepartmentMaster;
use frontend\models\UserMaster;
use frontend\models\Source;
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

<div class="lead-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        
        <div class="col-md-3">
            <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
            <span onclick="resetField(this)">Close</span>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'customer_company')->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
            <span onclick="resetField(this)">Close</span>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'autocomplete'=>'off']) ?>
            <span onclick="resetField(this)">Close</span>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mobile')->textInput(['autocomplete'=>'off']) ?>
            <span onclick="resetField(this)">Close</span>
        </div>
        
    </div>

    <div class="row">
        <div class="col-md-3">
            <?php 
                $sourceArr = [];
                $source = Source::find()->where(['parent_id'=>0, 'status'=>User::STATUS_ACTIVE])->all();
                foreach($source as $src){
                    $subSource = Source::find()->where(['parent_id'=>$src->id, 'status'=>User::STATUS_ACTIVE])->all();
                    foreach($subSource as $subSrc){
                        $sourceArr[$src->name][$subSrc->id] = $subSrc->name;
                    }
                }
            ?>
            <?= $form->field($model, 'lead_source')->dropDownList($sourceArr,['prompt'=>'--source--']) ?>
        </div>
        <div class="col-md-3">
            <?php 
                $priority = [
                    'Normal' => 'Normal',
                    'High' => 'High',
                    'Critical' => 'Critical'
                ];
            ?>
            <?= $form->field($model, 'priority')->dropDownList($priority,['prompt'=>'--priority--']); ?>
        </div>
        <div class="col-md-3">
            <?php $potential = [ 1=> 'Yes', 0=> 'No']; ?>
            <?= $form->field($model, 'buy_potential')->radioList($potential, ['onclick'=> 'buypotential()'])  ?>
        </div>

        <div class="col-md-3">
            <?php $potential = [ 1=> 'Yes', 0=> 'No']; ?>
            <?= $form->field($model, 'buy_potential')->radioList($potential, ['onclick'=> 'buypotential()'])  ?>
        </div>

    </div>

    <div class="row" id="buyPotentialTextArea" style="display:none;">
        <div class="col-md-12">
            <?= $form->field($model, 'buy_potential_detail')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
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

        <div class="col-md-3">
            <?= $form->field($model, 'call_date')->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'followup_date')->textInput() ?>
        </div>
        
        
    </div>

    <h5 class="modal-title">
        <span class="fw-mediumbold">Add Allocation</span> 														
    </h5>
    <div class="row">
        <?php 
            $company = ArrayHelper::map(Company::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-3">
            <?= $form->field($model, 'company_id')->dropDownList($company,['prompt'=>'--company--']); ?>
        </div>
        
        <div class="col-md-3">
            <?php 
                $department = ArrayHelper::map(DepartmentMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($model, 'department_id')->dropDownList($department, ['prompt'=>'--select department--']); ?>
        </div>
        <div class="col-md-3">
            <?php 
                $user = ArrayHelper::map(UserMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE, 'is_admin'=> 0])
                    ->orderBy('first_name')
                    ->all(), 'id', 'first_name'); 
            ?>
            <?= $form->field($model, 'user_id')->dropDownList($user, ['prompt'=>'N/A']); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'requirement')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'attachment')->fileInput(['maxlength' => true]) ?>
            <?php if($model->attachment){ ?>
                <a target="_blank" href="<?= Yii::$app->getUrlManager()->getBaseUrl().'/u/lead/'. $model->attachment; ?>"><?= $model->attachment ?></a>
            <?php } ?>
        </div>
        
        <div class="col-md-4">
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
$(document).ready(function(){
    
    buypotential = function(){
        $('#buyPotentialTextArea').hide();
        var radioValue = $("input[name='Lead[buy_potential]']:checked").val();
        if(radioValue == 1){
            $('#buyPotentialTextArea').show();
        }
    }
    buypotential();
    $('#lead-call_date').datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: -365, // today
        maxDate: 365, // +90 days from today
    });
    <?php if(!$model->followup_date){ ?>
        $('#lead-call_date').datepicker('setDate', new Date());
    <?php } ?>

    $('#lead-followup_date').datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: -365, // today
        maxDate: 365, // +90 days from today
    });
    <?php if(!$model->followup_date){ ?>
        $('#lead-followup_date').datepicker('setDate', new Date().getDay+7);
    <?php } ?>
    
    resetField = function(e){
        $(e).parent().find('input').val('');
    }
    fetchbrand = function(e){
        $('#lead-brand_id').html('<option value="">-- Select --</option>');
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
                        $('#lead-brand_id').append('<option value="'+idx+'">'+val+'</option>');
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
        $('#lead-category_id').val('<?= $model->category_id; ?>');
        $('#lead-category_id').trigger('change');
    <?php } ?>



    $('#lead-customer_name').autocomplete({
        serviceUrl: '<?= Url::to(['/lead/autocomplete-customer-name' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            $("#lead-customer_company").val(suggestion.other.company);
            $("#lead-email").val(suggestion.other.email);
            $("#lead-mobile").val(suggestion.other.mobile);
        },
    });
    $('#lead-customer_company').autocomplete({
        serviceUrl: '<?= Url::to(['/lead/autocomplete-company' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            $("#lead-customer_name").val(suggestion.other.name);
            $("#lead-email").val(suggestion.other.email);
            $("#lead-mobile").val(suggestion.other.mobile);
        },
    });
    $('#lead-email').autocomplete({
        serviceUrl: '<?= Url::to(['/lead/autocomplete-email' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            $("#lead-customer_name").val(suggestion.other.name);
            $("#lead-customer_company").val(suggestion.other.company);
            $("#lead-mobile").val(suggestion.other.mobile);
        },
    });
    $('#lead-mobile').autocomplete({
        serviceUrl: '<?= Url::to(['/lead/autocomplete-mobile' ]);?>',
        minChars : 1,
        onSelect: function (suggestion) {
            $("#lead-customer_name").val(suggestion.other.name);
            $("#lead-customer_company").val(suggestion.other.company);
            $("#lead-email").val(suggestion.other.email);
        },
    });
    
    
});
</script>