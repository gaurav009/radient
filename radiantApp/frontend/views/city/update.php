<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CityMaster */

$this->title = 'Update City Master: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'City Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->row_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="city-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
