<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\CategoryMaster */

$this->title = 'Create Category Master';
$this->params['breadcrumbs'][] = ['label' => 'Category Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-master-create">

   <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
