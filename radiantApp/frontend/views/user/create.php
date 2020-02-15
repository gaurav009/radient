<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserMaster */

$this->title = 'Create User Master';
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-master-create">

    <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'userCompany' => $userCompany
    ]) ?>

</div>
