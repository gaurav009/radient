<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessMaster */

$this->title = $model->role_id;
$this->params['breadcrumbs'][] = ['label' => 'Access Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="access-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'role_id' => $model->role_id, 'access_key' => $model->access_key], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'role_id' => $model->role_id, 'access_key' => $model->access_key], [
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
            'role_id',
            'access_key',
            'created',
        ],
    ]) ?>

</div>
