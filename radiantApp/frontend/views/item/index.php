<?php



use yii\helpers\Html;

use yii\grid\GridView;

use common\models\User;

use frontend\models\BrandMaster;

use frontend\models\CategoryMaster;

use frontend\models\Vendor;





$this->title = 'Items';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="item-index">



   <h4 class="page-title"><?= Html::encode($this->title) ?></h4>



    <p>

        <?= Html::a('Create Item', ['create'], ['class' => 'btn btn-primary']) ?>

       <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModalU">
            <i class="fa fa-plus"></i>
            Upload Item
        </button>

    </p>
    
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">			
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-error" role="alert">			
            <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>
    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        'columns' => [
           'item_code',
            [
                'label'=>'Item',
                'attribute' => 'name',
                'format' => 'raw',
                'value'=>function($data) {
                    return str_replace('"', '', $data->name);
                }
            ],
            [
                'label'=>'Brand',
                'attribute' => 'brand_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return BrandMaster::getTitle($data->brand_id);
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
            
          /*  [
                'label'=>'Vendor',
                'attribute' => 'vender_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return Vendor::getTitles($data->vender_id);
                }
            ], */

            'hsn',

            'uom',
            'part_no',
            'gst_rate',

            //'mrp',

            //'height',

            //'weight',

            //'dimension',

            //'unit',

            //'gst',

            //'location',

            //'vender_id',

            //'file',

            //'link',

            //'status',



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

                <form id="w0" action="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/item/import" method="post" enctype="multipart/form-data" >  
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
