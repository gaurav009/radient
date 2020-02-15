<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessMaster */

$this->title = 'Update Access Master: ' . $model->role_id;
$this->params['breadcrumbs'][] = ['label' => 'Access Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role_id, 'url' => ['view', 'role_id' => $model->role_id, 'access_key' => $model->access_key]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="access-master-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
