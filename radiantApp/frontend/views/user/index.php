<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

$this->title = 'User Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-master-index">

  <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a('Create User Master', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success" role="alert">			
            <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label'=>'Name',
                'attribute' => 'first_name',
                'format' => 'raw',
                'value'=>function($data) {
                    return trim($data->first_name.' '.$data->last_name);
                }
            ],
            'username',
            //'email:email',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'agree_tc',
            [
                'label'=>'Reporting Manager',
                'attribute' => 'is_reporting_manager',
                'format' => 'raw',
                'value'=>function($data) {
                    return $data->is_reporting_manager ? 'Yes' : 'No';
                }
            ],
            //'phone_home',
            //'phone_emergency',
            //'address',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'verification_token',

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
                'template' => '{update}{password}{company}',
                'buttons'=>[
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fas fa-pen"></span>', $url, ['style'=>'padding-right:10px;']);
                    },
                    'password' => function ($url, $model) {
                        return Html::a('<span class="fas fa-lock"></span>', ['/user/password', 'id'=> $model->id], ['style'=>'padding-right:10px;']);
                    },
                    'company' => function ($url, $model) {
                        return Html::a('<span class="fas fa-industry"></span>', ['/user-company', 'userId'=> $model->id]);
                    },
                ],
            ]
        ],
    ]); ?>


</div>
