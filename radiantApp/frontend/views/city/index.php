<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\CityMaster */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'City Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-master-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create City Master', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'row_id',
            'country_id',
            'region_id',
            'name',
            'geo_lat',
            //'geo_long',
            //'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
