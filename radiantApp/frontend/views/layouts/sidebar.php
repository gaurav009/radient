<?php 
use yii\helpers\Html;

$controllerId = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;

?>

<div class="sidebar">
                
    <div class="sidebar-wrapper scrollbar-inner">
        <div class="sidebar-content">
            
            <ul class="nav">
                <li class="nav-item <?php if( in_array($controllerId, ['site']) ){ echo 'active';}  ?>"">
                    <?= Html::a('<i class="fas fa-home"></i><p>Dashboard</p>', ['/dashboard']); ?>
                </li>
                
                <!-- && in_array($actionId, ['index']) -->
                <li class="nav-item <?php if( in_array($controllerId, ['company']) ){ echo 'active';}  ?>">
                    <a data-toggle="collapse" href="#manageCompany" class="<?php if( !in_array($controllerId, ['company']) ){ echo 'collapsed';}  ?>">
                        <i class="fas fa-asterisk"></i>
                        <p>Manage Own Company</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php if( in_array($controllerId, ['company']) ){ echo 'show';}  ?>" id="manageCompany">
                        <ul class="nav nav-collapse">
                            <li>
                                <?= Html::a('<span class="sub-item">Add Company</span>', ['/company']); ?>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item <?php if( in_array($controllerId, ['user', 'role', 'access', 'department']) ){ echo 'active';}  ?>">
                    <a data-toggle="collapse" href="#manageUser" class="<?php if( !in_array($controllerId, ['user', 'role', 'access', 'department']) ){ echo 'collapsed';}  ?>">
                        <i class="fas fa-layer-group"></i>
                        <p>Manage Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php if( in_array($controllerId, ['user', 'role', 'access', 'department']) ){ echo 'show';}  ?>" id="manageUser">
                        <ul class="nav nav-collapse">
                            <li>
                                <?= Html::a('<span class="sub-item">User Master</span>', ['/user']); ?>
                            </li>
                            
                            <li>
                                <?= Html::a('<span class="sub-item">Role Master</span>', ['/role']); ?>
                            </li>
                            
                            <li>
                                <?= Html::a('<span class="sub-item">Access Master</span>', ['/access']); ?>
                            </li>
                            <li>
                                <?= Html::a('<span class="sub-item">Department Master</span>', ['/department']); ?>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?php if( in_array($controllerId, ['item', 'brand', 'category']) ){ echo 'active';}  ?>">
                    <a data-toggle="collapse" href="#manageItem" class="<?php if( !in_array($controllerId, ['user', 'role', 'access', 'department']) ){ echo 'collapsed';}  ?>">
                        <i class="fas fa-pen-square"></i>
                        <p>Manage Items</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php if( in_array($controllerId, ['item', 'brand', 'category']) ){ echo 'show';}  ?>" id="manageItem">
                        <ul class="nav nav-collapse">
                            <li>
                                <?= Html::a('<span class="sub-item">Item Master</span>', ['/item']); ?>
                            </li>
                            <li>
                                <?= Html::a('<span class="sub-item">Brand Master</span>', ['/brand']); ?>
                            </li>
                            <li>
                                <?= Html::a('<span class="sub-item">Category Master</span>', ['/category']); ?>
                            </li>
                            <li>
                                <?= Html::a('<span class="sub-item">Source Master</span>', ['/source']); ?>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?php if( in_array($controllerId, ['customer']) ){ echo 'active';}  ?>">
                    <a data-toggle="collapse" href="#manageCustomer" class="<?php if( !in_array($controllerId, ['customer']) ){ echo 'collapsed';}  ?>">
                        <i class="fas fa-table"></i>
                        <p>Manage Customer</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php if( in_array($controllerId, ['customer']) ){ echo 'show';}  ?>" id="manageCustomer">
                        <ul class="nav nav-collapse">
                            <li>
                                <?= Html::a('<span class="sub-item">Customer Master</span>', ['/customer']); ?>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?php if( in_array($controllerId, ['vendor']) ){ echo 'active';}  ?>">
                    <a data-toggle="collapse" href="#manageVendor" class="<?php if( !in_array($controllerId, ['vendor']) ){ echo 'collapsed';}  ?>">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>Manage Vendor </p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?php if( in_array($controllerId, ['vendor']) ){ echo 'show';}  ?>" id="manageVendor">
                        <ul class="nav nav-collapse">
                            <li>
                                <?= Html::a('<span class="sub-item">Vendor Master</span>', ['/vendor']); ?>
                            </li>
                            
                        </ul>
                    </div>
                </li>
                <li class="nav-item <?php if( in_array($controllerId, ['lead']) ){ echo 'active';}  ?>"">
                    <?= Html::a('<i class="fas fa-home"></i><p>Manage Lead</p>', ['/lead']); ?>
                </li>
                <li class="nav-item <?php if( in_array($controllerId, ['country']) ){ echo 'active';}  ?>"">
                    <?= Html::a('<i class="fas fa-home"></i><p>Manage Location</p>', ['/country']); ?>
                </li>
            </ul>
        </div>
    </div>
</div>