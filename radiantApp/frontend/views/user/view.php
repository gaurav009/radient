<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first_name',
            'last_name',
            'employee_code',
            'username',
            'auth_key',
            'password_hash',
            'password_reset_token',
            'email:email',
            'agree_tc',
            'is_reporting_manager',
            'phone_home',
            'phone_emergency',
            'address',
            'status',
            'is_admin',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'verification_token',
        ],
    ]) ?>

</div>
