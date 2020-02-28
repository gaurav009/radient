<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Company;

$this->title = 'User Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Company', ['create', 'userId'=>$userId], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">			
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'label'=>'Company',
                'attribute' => 'company_id',
                'format' => 'raw',
                'value'=>function($data) {
                    return Company::getTitle($data->company_id);
                }
            ],
            
            'joining_date',
            'email:email',
            //'cv',
            //'phone',
            //
            //'whatsapp',
            //'linkedin',
            //'twitter',
            //'department_id',
            //'role_id',
            //'reporting_level1',
            //'reporting_level2',
            //'reporting_level3',
            //'vender_id',
            //'brand_id',
            //'category_id',
            //'created_on',
            //'created_by',
            //'updated_on',
            //'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-pen"></span>', $url, ['style'=>'padding-right:10px;']);
                    }
                ],
            ]
        ],
    ]); ?>


</div>
