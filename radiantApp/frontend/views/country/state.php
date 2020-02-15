<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use frontend\models\CountryMaster;

$this->title = 'State Masters';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="country-master-index">


    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        'columns' => [

            [
                'label'=>'State Id',
                'attribute' => 'cid',
                'format' => 'raw',
                'value'=>function($data) {
                    return $data->cid;
                }
            ],
            [
                'label'=>'Country',
                'attribute' => 'parent_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return CountryMaster::getTitle($data->parent_id);
                }
            ],
            
            'name',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewstate}',
                'buttons'=>[
                    'viewstate' => function ($url, $model) {
                        return Html::a('View city', ['/country/city', 'id'=>$model->cid]);
                    },
                ],
            ]

        ],

    ]); ?>





</div>

