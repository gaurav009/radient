<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\User;
use frontend\models\Company;
use frontend\models\DepartmentMaster;
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
            $department = ArrayHelper::map(DepartmentMaster::find()->asArray()
                ->where(['status' => User::STATUS_ACTIVE])
                ->orderBy('name')
                ->all(), 'id', 'name'); 
        ?>
        <div class="col-md-12">
            <?= $form->field($model, 'department_id')->dropDownList($department,['prompt'=>'--department--', 'onchange' => 'fetchUser(this)']); ?>
        </div>
    
        <div class="col-md-12">
            <?php 
            if($model->isNewRecord){
                $user = [];
            }else{
                $user = ArrayHelper::map(
                    User::find()->asArray()
                    ->leftJoin('user_company uc', 'uc.user_id=user.id')
                    ->where(['uc.department_id' => $model->department_id])
                    ->orderBy('first_name')->all(), 'id', 'first_name'
                ); 
            }
            ?>
            <?= $form->field($model, 'user_id')->dropDownList($user, ['prompt'=>'N/A']); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
$(document).ready(function(){

    fetchUser = function(e){
        $('#lead-user_id').html('<option value="">-- Select --</option>');
        if($(e).val() == 0){
            return false;
        }else{
            $.ajax({
                type: 'get',
                url: '<?= Url::to(['/department/fetchuser']); ?>',
                data: { 'id': $(e).val()},
                dataType: 'json',
                success: function(data){
                    $.each(data,function(idx,val){
                        $('#lead-user_id').append('<option value="'+idx+'">'+val+'</option>');
                    });
                },
                failure: function(errMsg) {
                    alert(errMsg.message);
                }
            });
        }
        return false;
    }
    <?php if($model->isNewRecord){ ?>
        $('#lead-department_id').val('<?= $model->department_id; ?>');
        $('#lead-department_id').trigger('change');
    <?php } ?>
});
</script>