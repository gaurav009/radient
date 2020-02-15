<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Source;
use common\models\User;

$this->title = 'Sources';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="source-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Source', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">			
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'name',
            [
                'header'=>'Parent',
                'attribute' => 'parent_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return Source::getTitle($data->parent_id);
                }                                              
            ],
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
