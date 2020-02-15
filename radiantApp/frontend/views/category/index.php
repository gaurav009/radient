<?php



use yii\helpers\Html;

use yii\grid\GridView;

use common\models\User;



/* @var $this yii\web\View */

/* @var $searchModel frontend\models\search\CategoryMaster */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Category Masters';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="category-master-index">



 <h4 class="page-title"><?= Html::encode($this->title) ?></h4>
<div class="row">
   <div class="col-sm-12 col-md-8">
        <?= Html::a('Create Category Master', ['create'], ['class' => 'btn btn-primary']) ?>
   </div>
   <div class="col-sm-12 col-md-4">
     <?= $this->render('_search', ['model' => $searchModel]); ?>
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


            'id', 
            'name',

            'description',

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

