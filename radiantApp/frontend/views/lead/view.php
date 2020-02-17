<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use frontend\models\Company;
use frontend\models\CategoryMaster;
use frontend\models\RoleMaster;
use frontend\models\BrandMaster;
use frontend\models\DepartmentMaster;
use frontend\models\Lead;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lead-view">

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Lead Information</a>
        </li>
    </ul>


    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
                <div class="col-3">									
                    <label class="ld4">Lead Id </label>
                    <p><?= "Lead-".$model->id ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Customer Name </label>
                    <p><?= $model->customer_name ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Email</label>
                    <p><?= $model->email ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Mobile</label>
                    <p><?= $model->mobile ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Requirements</label>
                    <p><?= $model->requirement ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Priority</label>
                    <p><?= $model->priority ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Buy Potential</label>
                    <p><?= $model->buy_potential ? 'Yes' : 'No'; ?></p>	
                </div>
                
                <div class="col-3">									
                    <label class="ld4">Call Date</label>
                    <p><?= $model->call_date ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Followup Date </label>
                    <p><?= $model->followup_date ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Comment</label>
                    <p><?= $model->comment ?></p>	
                </div>
                
                
                
                <div class="col-3">									
                    <label class="ld4">Company Name</label>
                    <p><?= Company::getTitle($model->company_id) ?><p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Category</label>
                    <p><?= CategoryMaster::getTitle($model->category_id) ?><p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Brand </label>
                    <p><?= BrandMaster::getTitle($model->brand_id) ?></p>	
                </div>
                <div class="col-3">									
                    <label class="ld4">Department</label>
                    <p><?= DepartmentMaster::getTitle($model->department_id) ?><p>	
                </div>

                <div class="col-3">									
                    <label class="ld4">Attachment</label>
                    <p>
                    <?php if($model->attachment){ ?>
                        <a target="_blank" href="<?= Yii::$app->getUrlManager()->getBaseUrl().'/u/lead/'. $model->attachment; ?>"><?= $model->attachment ?></a>
                    <?php } ?>
                    <p>	
                </div>
						
            </div>	
        </div>

        <?php if ( $model->status == Lead::Lead_Active ) { ?>
            <div class="modal-content">
                                                                        
                <div class="modal-header no-bd">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        <h3>Add Follow Up</h3></span> 														
                    </h5>
                </div>
                                                                        
                <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($leadFollowup, 'date')->textInput() ?>

                    <?= $form->field($leadFollowup, 'comment')->textarea(['rows' => 6]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['value'=>'save', 'name' => 'submit', 'class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton('Save & Reject', ['value'=>'reject','name' => 'submit', 'class' => 'btn btn-secondary']) ?>
                        <?= Html::submitButton('Save & Scrap', ['value'=>'scrap','name' => 'submit', 'class' => 'btn btn-warning']) ?>
                        <?= Html::submitButton('Save & Close', ['value'=>'close','name' => 'submit', 'class' => 'btn btn-danger']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
            </div>
        <?php } ?>
                            
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [

                    'id',
                    'date',
                    'comment:ntext'
                ],
            ]); ?>
        
    </div>
</div>



<script>

 $(document).ready(function(){
	$('#myTab a:second').tab('show');
});

$(document).ready(function(){
     $('#leadfollowup-date').datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: -365, // today
        maxDate: 365, // +90 days from today
    });
});
    
    </script>