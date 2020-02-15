<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Access Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-master-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Access Master', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'role_id',
            'access_key',
            'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
