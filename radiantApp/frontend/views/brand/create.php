<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BrandMaster */

$this->title = 'Create Brand Master';
$this->params['breadcrumbs'][] = ['label' => 'Brand Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-master-create">

   <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'errors' => $errors,
    ]) ?>

</div>
