<?php



/* @var $this \yii\web\View */

/* @var $content string */



use yii\helpers\Html;

use yii\bootstrap\Nav;

use yii\bootstrap\NavBar;

use yii\widgets\Breadcrumbs;

use frontend\assets\AppAsset;

use common\widgets\Alert;



AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">

    <head>

        <meta charset="<?= Yii::$app->charset ?>">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>



        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/azzara.min.css">

        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/bootstrap.min.css">

        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/fonts.css">
        <link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/css/jquery-ui.css">

    

        <script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/core/jquery.3.2.1.min.js"></script>
        <script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/jquery-ui.js"></script>
        
    </head>

    <body>      

        <div class="wrapper">

        

            <!--

                    Tip 1: You can change the background color of the main header using: data-background-color="blue | purple | light-blue | green | orange | red"

            -->

            <div class="main-header" data-background-color="purple">

                <!-- Logo Header -->

                <div class="logo-header">

                    

                    <a href="#" class="logo">

                        <img src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/img/logoazzara.svg" alt="navbar brand" class="navbar-brand">

                    </a>

                    <?php if(!Yii::$app->user->isGuest){  ?>

                        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">

                            <span class="navbar-toggler-icon">

                                <i class="fa fa-bars"></i>

                            </span>

                        </button>

                        <button class="topbar-toggler more"><i class="fa fa-ellipsis-v"></i></button>

                        <div class="navbar-minimize">

                            <button class="btn btn-minimize btn-rounded">

                                <i class="fa fa-bars"></i>

                            </button>

                        </div>

                    <?php } ?>

                </div>

                <!-- End Logo Header -->



                <!-- Navbar Header -->

                <nav class="navbar navbar-header navbar-expand-lg float-right">

                    

                    <div class="container-fluid">

                        <?php if(Yii::$app->user->isGuest){  

                            echo Html::a('Login', ['/site/login'],['class'=>'linkcol']);

                        }

                        if(!Yii::$app->user->isGuest){  

                            echo Html::a('Logout', ['/site/logout'],['class'=>'linkcol']);

                        }?>

                        

                    </div>

                </nav>

                <!-- End Navbar -->

            </div>

            <!-- Sidebar -->

                <?php if(!Yii::$app->user->isGuest){  

                    echo $this->render('sidebar.php'); 

                }  ?>

            <!-- End Sidebar -->



            <div class="main-panel">

			    <div class="content">

			        

			        <div class="col-md-12">

                    	<div class="card">

		                   <div class="modal-content">

		                       	<div class="modal-body">

			        

                                    <?= $content ?>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/jquery.maskedinput.js"></script>
        <script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/core/popper.min.js"></script>

        <script src="<?= Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/core/bootstrap.min.js"></script>
    </body>

</html>

<?php $this->endPage() ?>