<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use common\models\User;
use frontend\models\Source;
use frontend\models\Lead;
use yii\widgets\ActiveForm;
use frontend\models\Company;
use frontend\models\UserMaster;

$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-index">
  



<div class="row">
    <div class="col-12 col-md-8">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
        <div class="col-md-6">
            <?php $company = UserMaster::getUserOwnCompanies(); ?>
            <?= $form->field($searchModel, 'company_id')->dropDownList($company,['prompt'=>'--company--', 'onChange'=>"this.form.submit()"]); ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php if ( $searchModel->company_id) { ?>
        <div class="col-12 col-md-4">
        <p>
                <?= Html::a('Create Lead', ['create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Upload Lead', ['upload'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    <?php } ?>
</div>
    

<?php if ( $searchModel->company_id) { ?>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="px-2 active"><a class="btn btn-success btn-sm" href="<?= Url::to(['/lead']) ?>">Created Tickets</a></li>
            <li class="px-2"><a class="btn btn-default btn-sm" href="<?= Url::to(['/lead/allocated']) ?>">Assigned Tickets</a></li>
            <li class="px-2"><a class="btn btn-warning btn-sm" href="<?= Url::to(['/lead/scrapped']) ?>">Scrapped Tickets</a></li>
            <li class="px-2"><a class="btn btn-danger btn-sm" href="<?= Url::to(['/lead/closed']) ?>">Closed Tickets</a></li>
            <li class="px-2"><a  class="btn btn-secondary btn-sm" href="<?= Url::to(['/lead/rejected']) ?>">Rejected Tickets</a></li>
        </ul>

        <div class="tab-content">
            <div style="display: contents;" id="activetickets" class="tab-pane fade in active">
            <h5><u>Active</u></h5>
                <?php if(Yii::$app->session->hasFlash('success')): ?>
                    <div class="alert alert-success" role="alert">			
                        <?php echo Yii::$app->session->getFlash('success'); ?>
                    </div>
                <?php endif; ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,    
                    'columns' => [
                        
                        [
                            'header'=>'Lead',
                            'attribute' => 'id',
                            'format' => 'raw',
                            'value'=>function($data) {
                                    return Html::a('Lead-'.$data->id, ['/lead/view', 'id'=>$data->id]);
                            }                                            
                        ],
                        [
                            'header'=>'Lead Source',
                            'attribute' => 'lead_source',
                            'format' => 'raw',
                            'value'=>function($data) {
                                    return Source::getTitle($data->lead_source);
                            }                                            
                        ],
                        'customer_name',
                        'customer_company',
                        'email:email',
                        'priority',
                        [
                            'header'=>'Status',
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value'=>function($data) {
                                if ($data->status == Lead::Lead_Active) {
                                    return "Active";
                                } else if ($data->status == Lead::Lead_Closed) {
                                    return "Closed";
                                } else if ($data->status == Lead::Lead_Scrapped) {
                                    return "Scrapped";
                                } else if ($data->status == Lead::Lead_Rejected) {
                                    return "Rejected";
                                }
                            }                                            
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update}{followup}{allocation}{reopen}',
                            'buttons'=>[
                                'update' => function ($url, $model) {
                                    if ( $model->status == Lead::Lead_Active ) {
                                        return Html::a('<span class="fas fa-pen"></span>', $url, ['title'=>'Modify Lead', 'style'=>'padding: 5px;']);
                                    }
                                },
                                'allocation'=> function($url, $model){
                                    if ( $model->status == Lead::Lead_Active ) {
                                        return Html::a('<i class="fa fa-tasks"></i>', ['/lead/allocation', 'id'=>$model->id], ['title'=>'Add Allocation', 'style'=>'padding: 5px;']);
                                    }
                                },
                                'followup'=> function($url, $model){
                                    if ( $model->status == Lead::Lead_Active ) {
                                        return Html::a('<i class="fa fa-user-plus"></i>', ['/lead/view', 'id'=>$model->id,'#'=>'profile'], ['title'=>'Reopen', 'style'=>'padding: 5px;']);
                                    }
                                }
                            ],
                        ]
                    ],
                ]); ?>
            </div>
        
        </div>
    </div>
<?php } ?>