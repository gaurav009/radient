<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use frontend\models\Company;
use common\models\User;
use frontend\models\UserMaster;
use frontend\models\DepartmentMaster;
use frontend\models\RoleMaster;
use frontend\models\BrandMaster;
use frontend\models\CategoryMaster;
use frontend\models\Vendor;
use frontend\models\CountryMaster;
use frontend\models\CityMaster;


$this->title = 'Update User Password: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-master-update">

   <h4 class="page-title"><?= Html::encode($this->title) ?></h4>

    <div class="user-master-form col-md-12">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
        <h5>Login Details</h5>
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'password')->passwordInput([]); ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'cpassword')->passwordInput([]); ?>
            </div>
        </div>
    
    
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>

    </div>
</div>
