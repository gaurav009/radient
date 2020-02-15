<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


$this->title = 'Country Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-master-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="country-master-search">

        <?php $form = ActiveForm::begin([
            'action' => ['/country/index'],
            'method' => 'get',
        ]); ?>
    
        <?= $form->field($searchModel, 'name'); ?>
    
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>
    
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            
            [
                'label'=>'Country Id',
                'attribute' => 'cid',
                'format' => 'raw',
                'value'=>function($data) {
                    return $data->cid;
                }
            ],
            'code',
            'dialing_code',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewstate}',
                'buttons'=>[
                    'viewstate' => function ($url, $model) {
                        return Html::a('View State', ['/country/state', 'id'=>$model->cid]);
                    },
                ],
            ]
        ],
    ]); ?>


</div>
