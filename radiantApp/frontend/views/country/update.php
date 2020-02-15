<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CountryMaster */

$this->title = 'Update Country Master: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Country Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="country-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
