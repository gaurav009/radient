<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\models\CategoryMaster;
use frontend\models\BrandMaster;
use common\models\User;
use frontend\models\search\CategoryMaster as CategoryMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\AccessMaster;
/**
 * CategoryController implements the CRUD actions for CategoryMaster model.
 */
class CategoryController extends Controller
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
     * Lists all CategoryMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addCategory') || AccessMaster::hasAccess('updateCategory') || AccessMaster::hasAccess('uploadCategory'); // get action permission based on role
        if( $hasAccess ){
        $searchModel = new CategoryMasterSearch();
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
     * Displays a single CategoryMaster model.
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
     * Creates a new CategoryMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addCategory') ; // get action permission based on role
        if( $hasAccess ){
        $model = new CategoryMaster();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = User::STATUS_ACTIVE;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Category Created successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
     }
    }
    /**
     * Updates an existing CategoryMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
     $hasAccess = AccessMaster::hasAccess('updateCategory') ; // get action permission based on role
        if( $hasAccess ){
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

    public function actionFetchbrand($id)
    {
       if(Yii::$app->request->isAjax){
            $brand = ArrayHelper::map(BrandMaster::find()->asArray()
                         ->where(['status' => User::STATUS_ACTIVE,'category_id' => $id])
                         ->orderBy('name')->all(), 'id', 'name'); 
            
            echo json_encode($brand, true);
            exit;
       } 
    }

    /**
     * Finds the CategoryMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
