<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Vendor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vendor-view">

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
            'name',
            'brand_id',
            'category_id',
            'address',
            'country_id',
            'state_id',
            'city_id',
            'postal_code',
            'gst',
            'aadhar_no',
            'pan_no',
            'email:email',
            'mobile',
            'phone',
            'ac_beneficiary_name',
            'ac_bank_name',
            'ac_number',
            'ac_type',
            'ac_ifsc',
            'ac_address',
            'status',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
        ],
    ]) ?>

</div>
