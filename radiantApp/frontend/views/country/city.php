<?php
use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\CountryMaster;

$this->title = 'City';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="country-master-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([

        'dataProvider' => $dataProvider,

        'columns' => [
            [
                'label'=>'City Id',
                'attribute' => 'row_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return $data->row_id;
                }
            ],
            [
                'label'=>'Country',
                'attribute' => 'country_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return CountryMaster::getTitle($data->country_id);
                }
            ],
            [
                'label'=>'State',
                'attribute' => 'region_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return CountryMaster::getTitle($data->region_id);
                }
            ],
            'name'
        ],

    ]); ?>





</div>

