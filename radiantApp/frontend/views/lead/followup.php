<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\Company;
use frontend\models\RoleMaster;
use frontend\models\UserMaster;


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Leads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="lead-view">

    <h5 class="modal-title">
        <span class="fw-mediumbold">Add Allocation</span> 														
    </h5>

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <?php 
            $company = ArrayHelper::map(Company::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-12">
            <?= $form->field($model, 'company_id')->dropDownList($company,['prompt'=>'--company--']); ?>
        </div>
        
        <div class="col-md-12">
            <?php 
                $role = ArrayHelper::map(RoleMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE])
                    ->orderBy('name')
                    ->all(), 'id', 'name'); 
            ?>
            <?= $form->field($model, 'role_id')->dropDownList($role, ['prompt'=>'--select role--']); ?>
        </div>

        <div class="col-md-12">
            <?php 
                $user = ArrayHelper::map(UserMaster::find()->asArray()
                    ->where(['status' => User::STATUS_ACTIVE, 'is_admin'=> 0])
                    ->orderBy('first_name')
                    ->all(), 'id', 'first_name'); 
            ?>
            <?= $form->field($model, 'user_id')->dropDownList($user, ['prompt'=>'N/A']); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
