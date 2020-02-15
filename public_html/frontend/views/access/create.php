<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AccessMaster */

$this->title = 'Create Access Master';
$this->params['breadcrumbs'][] = ['label' => 'Access Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-master-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
