<?php

namespace frontend\controllers;

use Yii;
use frontend\models\DepartmentMaster;
use common\models\User;
use frontend\models\search\DepartmentMaster as DepartmentMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use frontend\models\AccessMaster;

/**
 * DepartmentController implements the CRUD actions for DepartmentMaster model.
 */
class DepartmentController extends Controller
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
     * Lists all DepartmentMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addDepartment') || AccessMaster::hasAccess('updateDepartment') || AccessMaster::hasAccess('uploadDepartment'); // get action permission based on role
        if ($hasAccess) {
        $searchModel = new DepartmentMasterSearch();
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
     * Displays a single DepartmentMaster model.
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
     * Creates a new DepartmentMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addDepartment'); // get action permission based on role
        if ($hasAccess) {
        $model = new DepartmentMaster();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = User::STATUS_ACTIVE;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Department Created successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    }
    /**
     * Updates an existing DepartmentMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $hasAccess =  AccessMaster::hasAccess('updateDepartment'); // get action permission based on role
        if ($hasAccess) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Department Updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
    public function actionFetchuser($id)
    {
       if(Yii::$app->request->isAjax){
            $user = ArrayHelper::map(
                        User::find()->asArray()
                        ->leftJoin('user_company uc', 'uc.user_id=user.id')
                        ->where(['uc.department_id' => $id])
                        ->orderBy('first_name')->all(), 'id', 'first_name'
                    ); 
            
            echo json_encode($user, true);
            exit;
       } 
    }

    

    /**
     * Finds the DepartmentMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DepartmentMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DepartmentMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
