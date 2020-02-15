<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use frontend\models\CategoryMaster;
use frontend\models\BrandMaster;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;


$this->title = 'Vendors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-index">

      <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Create Vendor', ['create'], ['class' => 'btn btn-primary']) ?>
        
         <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModalU">
											<i class="fa fa-plus"></i>
											Upload Vendors CSV
										</button>
        
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">			
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
             'vendor_code',
              'company',
             
            [

                'label'=>'City',
                'attribute' => 'city_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return CityMaster::getTitle($data->city_id);

                }

            ],
              
              
              
            [
                'label'=>'Category',
                'attribute' => 'category_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return CategoryMaster::getTitle($data->category_id);
                }
            ],
          
           // 'address',
            //'country_id',
            //'state_id',
            
            //'postal_code',
            //'gst',
            //'aadhar_no',
            //'pan_no',
            //'email:email',
            //'mobile',
            //'phone',
            //'ac_beneficiary_name',
            //'ac_bank_name',
            //'ac_number',
            //'ac_type',
            //'ac_ifsc',
            //'ac_address',
           
          
           [
               'label'=>'Brand',
               'attribute' => 'brand_id',
               'format' => 'raw',
               'value'=>function($data) {
                   return BrandMaster::getTitle($data->brand_id);
               }
           ],
            'name',
            [
                'header'=>'Status',
                'attribute' => 'status',
                'format' => 'raw',
                'value'=>function($data) {
                        return ($data->status == User::STATUS_ACTIVE) ? "Active" : "Inactive";
                },
                'filter'=>[ User::STATUS_ACTIVE => 'Active', User::STATUS_INACTIVE => 'Inactive' ],                                              
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-pen"></span>', $url);
                    },
                ],
            ]
        ],
    ]); ?>


</div>


<div class="modal fade" id="addRowModalU" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">

                <form id="w0" action="/vendor/import" method="post" enctype="multipart/form-data" >  
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        <span class="btn btn-default btn-file">
                            Browse 
                            <input type="file" name="importFile">
                        </span>	
                        
                        <button type="submit" class="btn btn-primary">Submit</button
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </form>
                
            </div>
        </div>
    </div>
</div>

