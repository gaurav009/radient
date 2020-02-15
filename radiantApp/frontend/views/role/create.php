<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RoleMaster */

$this->title = 'Create Role Master';
$this->params['breadcrumbs'][] = ['label' => 'Role Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-master-create">

    <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
