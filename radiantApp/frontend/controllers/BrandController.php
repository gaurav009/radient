<?php
namespace frontend\controllers;

use Yii;
use frontend\models\BrandMaster;
use frontend\models\search\BrandMaster as BrandMasterSearch;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\CategoryMaster;
use frontend\models\AccessMaster;
/**
 * BrandController implements the CRUD actions for BrandMaster model.
 */
class BrandController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BrandMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addBrand') || AccessMaster::hasAccess('updateBrand') || AccessMaster::hasAccess('uploadBrand'); // get action permission based on role
        if( $hasAccess ){
        $searchModel = new BrandMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } else {
        throw new NotFoundHttpException('You are not authorized to view this page.');
    }
}

    /**
     * Displays a single BrandMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BrandMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     
     public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addBrand') ; // get action permission based on role
        if( $hasAccess ){
        $model = new BrandMaster();
        $errors = [];
        if ($model->load(Yii::$app->request->post())) {
            
            $transaction = Yii::$app->db->beginTransaction();
            $category = $model->category_id;
            if( empty( $category ) || empty($model->name) ){
                
                    $errors['$category'][] = 'Select Category Name';
                    if(empty( $category )){
                        $model->addError('category_id', 'Select category Name');
                    } 
                    if(empty( $model->name )){
                        $model->addError('name', 'Category Name cannot be blank');
                    }
                
            }else{
               
                foreach($category as $categorys){
                    $modelCreate = new BrandMaster();
                    $modelCreate->name = $model->name;
                    $modelCreate->description = $model->description;
                    $modelCreate->category_id = $categorys;
                    $modelCreate->status = User::STATUS_ACTIVE;
                    $modelCreate->created_by = Yii::$app->user->identity->id;
                    $modelCreate->created_on = date('Y-m-d H:i:s');
                    $modelCreate->updated_by = Yii::$app->user->identity->id;
                    $modelCreate->updated_on = date('Y-m-d H:i:s');
                    
                    
                    if(!$modelCreate->save()){
                        if(!empty($model->name)){
                            $errors['name'][] = 'Category Name "'.$model->name.'" is already taken for '.CategoryMaster::getTitle($categorys);
                            //echo '<pre>'; print_r($errors); print_r($modelCreate->attributes); print_r($modelCreate->errors); die();
                        }
                    }else{
                        $modelCreate->brand_code = 'BM0'.$modelCreate->id;
                        $modelCreate->save();
                    }
                    //echo '<pre>'; print_r($modelCreate->attributes); print_r($modelCreate->errors); die();
                }
            }


            if(!empty($errors)){
                $transaction->rollBack();
            }else{
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Brand Created successfully.');
                return $this->redirect(['index']);
            }
        }

        //echo '<pre>'; print_r($errors);  die();
        return $this->render('create', [
            'model' => $model,
            'errors' => $errors
        ]);
       
        }

    }
     
     
   /* public function actionCreate()
    {
        $model = new BrandMaster();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = User::STATUS_ACTIVE;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            
             if( !empty($model->category_id) ){
                $model->category_id = implode(',', $model->category_id);
                
              //  print_r($model->category_id);
                
            }
            
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Brand Created successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

*/

    /**
     * Updates an existing BrandMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
      $hasAccess = AccessMaster::hasAccess('updateBrand') ; // get action permission based on role
        if( $hasAccess )
       {
                    $model = $this->findModel($id);

                    if ($model->load(Yii::$app->request->post())) {

                        $model->updated_by = Yii::$app->user->identity->id;
                        $model->updated_on = date('Y-m-d H:i:s');
                        if($model->save()){
                            Yii::$app->session->setFlash('success', 'Brand Updated successfully.');
                            return $this->redirect(['index']);
                        }
                    }

                    return $this->render('update', [
                        'model' => $model,
                    ]);
        }
    }

    /**
     * Finds the BrandMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrandMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BrandMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
