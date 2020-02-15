<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CountryMaster */

$this->title = 'Create Country Master';
$this->params['breadcrumbs'][] = ['label' => 'Country Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
