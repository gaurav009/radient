<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\DepartmentMaster */

$this->title = 'Update Department Master: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Department Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="department-master-update">

     <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
