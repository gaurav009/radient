<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use frontend\models\Source;
use yii\helpers\Url;

$this->title = 'Leads';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-index">
  



 <div class="row">
     <div class="col-12 col-md-8">
    <h4><?= Html::encode($this->title) ?></h4>
</div>

<div class="col-12 col-md-4">
<p>
        <?= Html::a('Create Lead', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Upload Lead', ['upload'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>
</div>
    

   
    <div class="container">
  <ul class="nav nav-tabs">
  <li class="px-2 active"><a class="btn btn-success btn-sm" href="<?= Url::to(['/lead/active']) ?>">Active Tickets</a></li>
    <li class="px-2"><a class="btn btn-default btn-sm" href="<?= Url::to(['/lead/allocated']) ?>">Allocated Tickets</a></li>
    <li class="px-2"><a class="btn btn-warning btn-sm" href="<?= Url::to(['/lead/scrapped']) ?>">Scrapped Tickets</a></li>
    <li class="px-2"><a class="btn btn-danger btn-sm" href="<?= Url::to(['/lead/closed']) ?>">Closed Tickets</a></li>
    <li class="px-2"><a  class="btn btn-secondary btn-sm" href="<?= Url::to(['/lead/rejected']) ?>">Rejected Tickets</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="allocatedtickets" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="scrappedtickets" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="closeticket" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>

    <div id="rejectedtickets" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
 




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
            //'mobile',
            //'requirement:ntext',
            'priority',
            //'buy_potential',
            //'category_id',
            //'brand_id',
            //'company_id',
            //'role_id',
            //'user_id',
            //'call_date',
            //'followup_date',
            //'comment:ntext',
            //'created_on',
            //'created_by',
            //'updated_on',
            //'updated_by',
            [
                'header'=>'Status',
                'attribute' => 'status',
                'format' => 'raw',
                'value'=>function($data) {
                        return ($data->status == User::STATUS_ACTIVE) ? "Active" : "Inactive";
                }                                            
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{followup}{allocation}{reopen}',
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-pen"></span>', $url, ['title'=>'Modify Lead', 'style'=>'padding: 5px;']);
                    },
                    'allocation'=> function($url, $model){
                        return Html::a('<i class="fa fa-tasks"></i>', ['/lead/allocation', 'id'=>$model->id], ['title'=>'Add Allocation', 'style'=>'padding: 5px;']);
                    },
                    'followup'=> function($url, $model){
                        return Html::a('<i class="fa fa-user-plus"></i>', ['/lead/view', 'id'=>$model->id,'#'=>'profile'], ['title'=>'Follow Up', 'style'=>'padding: 5px;']);
                    },
                    'reopen'=> function($url, $model){
                        return Html::a('<i class="fa fa-folder-open"></i>', ['/lead/view', 'id'=>$model->id,'#'=>'profile'], ['title'=>'Follow Up', 'style'=>'padding: 5px;']);
                    }
                    
                ],
            ]
        ],
    ]); ?>


</div>
<div class="modal fade" id="allocationallocation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            <div class="modal-header no-bd">
                <h5 class="modal-title">
                    <span class="fw-mediumbold">
                    Add Allocation</span> 														
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            
            <div class="form-group">
                <label for="squareInput">Select Own Company</label>
                <select class="form-control input-square" id="squareSelect">
                    <option>Radient</option>
                    <option>Dvcomm</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="squareInput">Select Role</label>
                <select class="form-control input-square" id="squareSelect">
                    <option>Sale</option>
                    <option>Marketing</option>
                </select>
            </div>
            <div class="form-group">
                <label for="squareSelect">Select User</label>
                <select class="form-control input-square" id="squareSelect">
                    <option>Jakesh</option>
                    <option>Neha</option>
                </select>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" id="addRowButton" class="btn btn-primary">Add</button>
            </div>
            
                
        </div>
    </div>
</div>