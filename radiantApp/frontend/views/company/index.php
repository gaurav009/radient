<?php



use yii\helpers\Html;

use yii\grid\GridView;

use common\models\User;

use frontend\models\CountryMaster;

/* @var $this yii\web\View */

/* @var $searchModel frontend\models\search\Company */

/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'Companies';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="company-index">

     <h4 class="page-title"><?= Html::encode($this->title) ?></h4>
    <div class="row">
        <div class="col-sm-12 col-md-8">
            <?= Html::a('Create Company', ['create'], ['class' => 'btn btn-primary']) ?>
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



            'name',

            'email:email',

            'phone',



            [

                'header'=>'Location',

                'attribute' => 'country_id',

                'format' => 'raw',

                'value'=>function($data) {

                    return CountryMaster::getLocation($data->country_id, $data->state_id, $data->city_id);

                }

            ],

            //'website',

            //'gst_no',

            //'state_id',

            //'country_id',

            //'city_id',

            //'address:ntext',

            //'status',

            //'create_on',

            //'created_by',

            //'updated_on',

            //'updated_by',

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

