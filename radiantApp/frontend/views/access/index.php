<?php

   use yii\helpers\Html;

   use yii\helpers\Url;

   use yii\helpers\ArrayHelper;

   use frontend\models\RoleMaster;

   use common\models\User;



   $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : 2;

?>

<div class="col-md-12">

    <div class="container col-md-12">

        <?php if(Yii::$app->session->hasFlash('success')): ?>

            <div class="alert alert-success" role="alert">			

                <?php echo Yii::$app->session->getFlash('success'); ?>

            </div>

        <?php endif; ?>

        <form method="post">

            <h4>Manage Role</h4>

            <div class="col-md-12">

                <?php $roles = ArrayHelper::map(RoleMaster::find()->asArray()

                    ->where(['status' => User::STATUS_ACTIVE])

                    ->andWhere(['!=', 'id', 1])

                    ->orderBy('name')

                    ->all(), 'id', 'name'); ?>

                <div class="form-group field-usermaster-role required">

                    <label class="control-label" for="usermaster-role">

                        <h6>Select Role</h6>

                    </label>

                    <select id="usermaster-role" class="form-control" name="access[role]" aria-required="true" onchange="fetchResult(this)">

                        <option value="">-- Role --</option>

                        <?php foreach($roles as $key => $value ){ ?>

                            <option value="<?= $key ?>" <?= $id == $key ? 'selected' : ''; ?>><?= $value ?></option>

                        <?php } ?>

                    </select>

                    <div class="help-block text-danger">

                        <?= isset($errors['role']) ? $errors['role'] : '' ?>

                    </div>

                    <div class="help-block text-danger">

                        <?= isset($errors['keys']) ? $errors['keys'] : '' ?>

                    </div>

                </div>

            </div>

            <div class="col-sm-12">

                <h5>Company Master</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Own Company</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addCompany" <?= isset($accessPermission['addCompany']) ? 'checked' : ''?> >

                <label>Add Company</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateCompany" <?= isset($accessPermission['updateCompany']) ? 'checked' : ''?>>

                <label>Update Company</label>

                </div>

            </div>
            
            <div class="col-sm-12">

<h5>Manage Department</h5>

</div>

<div class="row-a">

<div class="form-group form-floating-label col-sm-3">

<h6>Department Master</h6>

</div>

<div class="form-group form-floating-label col-sm-2">

<input type="checkbox" name="access[keys][]" value="addDepartment" <?= isset($accessPermission['addDepartment']) ? 'checked' : ''?>>

<label>Add Department</label>

</div>

<div class="form-group form-floating-label col-sm-2">

<input type="checkbox" name="access[keys][]" value="updateDepartment" <?= isset($accessPermission['updateDepartment']) ? 'checked' : ''?>>

<label>Update Department</label>

</div>

<div class="form-group form-floating-label col-sm-2">

<input type="checkbox" name="access[keys][]" value="uploadDepartment" <?= isset($accessPermission['uploadDepartment']) ? 'checked' : ''?>>

<label>Upload Department</label>

</div>

</div>


            <div class="col-sm-12">

                <h5>Manage Item</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Item Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addItem" <?= isset($accessPermission['addItem']) ? 'checked' : ''?>>

                <label>Add Item</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateItem" <?= isset($accessPermission['updateItem']) ? 'checked' : ''?>>

                <label>Update Item</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadItem" <?= isset($accessPermission['uploadItem']) ? 'checked' : ''?>>

                <label>Upload Item</label>

                </div>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Brand Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addBrand" <?= isset($accessPermission['addBrand']) ? 'checked' : ''?>>

                <label>Add Brand</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateBrand" <?= isset($accessPermission['updateBrand']) ? 'checked' : ''?>>

                <label>Update Brand</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadBrand" <?= isset($accessPermission['uploadBrand']) ? 'checked' : ''?>>

                <label>Upload Brand</label>

                </div>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Category Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addCategory" <?= isset($accessPermission['addCategory']) ? 'checked' : ''?>>

                <label>Add Category</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateCategory" <?= isset($accessPermission['updateCategory']) ? 'checked' : ''?>>

                <label>Update Category</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadCategory" <?= isset($accessPermission['uploadCategory']) ? 'checked' : ''?>>

                <label>Upload Category</label>

                </div>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Source Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addSource" <?= isset($accessPermission['addSource']) ? 'checked' : ''?>>

                <label>Add Source</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateSource" <?= isset($accessPermission['updateSource']) ? 'checked' : ''?>>

                <label>Update Source</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadSource" <?= isset($accessPermission['uploadSource']) ? 'checked' : ''?>>

                <label>Upload Source</label>

                </div>

            </div>

            <div class="col-sm-12">

                <h5>Customer Master</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Customer Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addCustomer" <?= isset($accessPermission['addCustomer']) ? 'checked' : ''?>>

                <label>Add Customer</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateCustomer" <?= isset($accessPermission['updateCustomer']) ? 'checked' : ''?>>

                <label>Update Customer</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadCustomer" <?= isset($accessPermission['uploadCustomer']) ? 'checked' : ''?>>

                <label>Upload Customer</label>

                </div>

            </div>

            <div class="col-sm-12">

                <h5>Vendor Master</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Vendor Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addVendor" <?= isset($accessPermission['addVendor']) ? 'checked' : ''?>>

                <label>Add Vendor</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateVendor" <?= isset($accessPermission['updateVendor']) ? 'checked' : ''?>>

                <label>Update Vendor</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadVendor" <?= isset($accessPermission['uploadVendor']) ? 'checked' : ''?>>

                <label>Upload Vendor</label>

                </div>

            </div>

            <div class="col-sm-12">

                <h5>Manage Lead</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Lead Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addLead" <?= isset($accessPermission['addLead']) ? 'checked' : ''?>>

                <label>Add Lead</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateLead" <?= isset($accessPermission['updateLead']) ? 'checked' : ''?>>

                <label>Update Lead</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadLead" <?= isset($accessPermission['uploadLead']) ? 'checked' : ''?>>

                <label>Upload Vendor</label>

                </div>

            </div>

            <div class="col-sm-12">

                <h5>Manage Ticket</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Ticket Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addTicket" <?= isset($accessPermission['addTicket']) ? 'checked' : ''?>>

                <label>Add Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="uploadTicket" <?= isset($accessPermission['uploadTicket']) ? 'checked' : ''?>>

                <label>Upload Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="rejectTicket" <?= isset($accessPermission['rejectTicket']) ? 'checked' : ''?>>

                <label>Reject Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="scrapTicket" <?= isset($accessPermission['scrapTicket']) ? 'checked' : ''?>>

                <label>Scrap Ticket</label>

                </div>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="closeTicket" <?= isset($accessPermission['closeTicket']) ? 'checked' : ''?>>

                <label>Close Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="allocateTicket" <?= isset($accessPermission['allocateTicket']) ? 'checked' : ''?>>

                <label>Allocate Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="reopenTicket" <?= isset($accessPermission['reopenTicket']) ? 'checked' : ''?>>

                <label>Reopen Ticket</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

<input type="checkbox" name="access[keys][]" value="followupTicket" <?= isset($accessPermission['followupTicket']) ? 'checked' : ''?>>

<label>Reopen Ticket</label>

</div>

            </div>

            <div class="col-sm-12">

                <h5>Manage Quotation</h5>

            </div>

            <div class="row-a">

                <div class="form-group form-floating-label col-sm-3">

                <h6>Quotation Master</h6>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="addQuotation" <?= isset($accessPermission['addQuotation']) ? 'checked' : ''?>>

                <label>Add Quotation</label>

                </div>

                <div class="form-group form-floating-label col-sm-2">

                <input type="checkbox" name="access[keys][]" value="updateQuotation" <?= isset($accessPermission['updateQuotation']) ? 'checked' : ''?>>

                <label>Update Quotation</label>

                </div>

            </div>

            <div class="form-action">

                <input type="submit" class="btn btn-primary" value="Submit">

                <a href="#" id="show-signup" class="btn btn-danger  btn-login mr-3">Cancel</a>

            </div>

        </form>

    </div>

</div>

<script>

$(document).ready(function(){

    fetchResult = function(e){

        if( $(e).val() ){

            location.href = '<?= Url::to(['/access']); ?>?id='+$(e).val();

        }

    }

});

</script>