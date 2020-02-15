<?php

namespace frontend\controllers;

use Yii;
use frontend\models\CountryMaster;
use frontend\models\search\CountryMaster as CountryMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use yii\helpers\ArrayHelper;
use common\models\User;
use frontend\models\CityMaster;
/**
 * CountryController implements the CRUD actions for CountryMaster model.
 */
class CountryController extends Controller
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
     * Lists all CountryMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountryMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionState($id)
    {
        $searchModel = new CountryMasterSearch();
        $dataProvider = $searchModel->searchState($id);
        
        return $this->render('state', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=> $id
        ]);
    }
    
     public function actionCity($id)
    {
        $searchModel = new CountryMasterSearch();
        $dataProvider = $searchModel->searchCity($id);
        
        return $this->render('city', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=> $id
        ]);
    }

    /**
     * Displays a single CountryMaster model.
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
     * Creates a new CountryMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CountryMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cid]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CountryMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cid]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }




    public function actionFetchstate($id)
    {
       if(Yii::$app->request->isAjax){
            $state = ArrayHelper::map(CountryMaster::find()->asArray()
                         ->where(['is_active' => 'Y','parent_id' => $id])
                         ->orderBy('name')->all(), 'cid', 'name'); 
            
            echo json_encode($state, true);
            exit;
       } 
    }
    
    public function actionFetchcity()
    {
       if(Yii::$app->request->isAjax){
            $state = ArrayHelper::map(CityMaster::find()->asArray()
                         ->where(['status' => 'Y','country_id' => $_REQUEST['country']
                                 ,'region_id' => $_REQUEST['region']])
                         ->orderBy('name')->all(), 'row_id', 'name'); 
            
            echo json_encode($state, true);
            exit;
       } 
    }
    /**
     * Finds the CountryMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CountryMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CountryMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
