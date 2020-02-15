<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Company;
use common\models\User;
use frontend\models\CompanySocialLink;
use frontend\models\search\Company as CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use frontend\models\AccessMaster;

class CompanyController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addCompany') || AccessMaster::hasAccess('updateCompany'); // get action permission based on role
        if( $hasAccess ){ 
        $model = new Company();
        $socialLink = new CompanySocialLink();

        
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'socialLink'=>$socialLink
        ]);
     
    } else {
        throw new NotFoundHttpException('You are not authorized to view this page.');
    }
    }

    /**
     * Displays a single Company model.
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
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addCompany'); // get action permission based on role
        if( $hasAccess ){  
        $model = new Company();
        $socialLink = new CompanySocialLink();


        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $socialLink->load(Yii::$app->request->post());

            if(isset($_FILES['Company']) && $_FILES['Company']['name']['upload_logo']){
                $uploadedFilename = $_FILES['Company']['name']['upload_logo'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $model->upload_logo = UploadedFile::getInstance($model, 'upload_logo');
                $model->upload_logo->saveAs(RP_APP_ROOT.'/__uploaded__/company/' .$filename);
                $model->upload_logo = $filename;
            }


            $model->status = User::STATUS_ACTIVE;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');

            $socialLink->created_by = Yii::$app->user->identity->id;
            $socialLink->created_on = date('Y-m-d H:i:s');
            $socialLink->updated_by = Yii::$app->user->identity->id;
            $socialLink->updated_on = date('Y-m-d H:i:s');
            
            if($model->validate() && $socialLink->validate()){
                
                if($model->save()){

                    $socialLink->company_id = $model->id;
                    if($socialLink->save()){
                        Yii::$app->session->setFlash('success', 'Company Created successfully.');
                        return $this->redirect(['index']);
                    }
                }
            }
            //echo '<pre>'; print_r($model->errors);print_r($socialLink->errors); die();
        }


        return $this->render('create', [
            'model' => $model,
            'socialLink'=>$socialLink
        ]);
     }
    }
    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $hasAccess = AccessMaster::hasAccess('updateCompany'); // get action permission based on role
        if( $hasAccess ){
        $model = $this->findModel($id);
        $socialLink = CompanySocialLink::findOne(['company_id'=>$id]);

        if ( $model->load(Yii::$app->request->post())
                 && $socialLink->load(Yii::$app->request->post()) ) {

            if(isset($_FILES['Company']) && $_FILES['Company']['name']['upload_logo']){
                $uploadedFilename = $_FILES['Company']['name']['upload_logo'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $model->upload_logo = UploadedFile::getInstance($model, 'upload_logo');
                $model->upload_logo->saveAs(RP_APP_ROOT.'/__uploaded__/company/' .$filename);
                $model->upload_logo = $filename;
            }
            $valid = $model->validate();
            $valid = $socialLink->validate() && $valid;
            if( $valid ){
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if($model->save()){
                    
                    $socialLink->updated_by = Yii::$app->user->identity->id;
                    $socialLink->updated_on = date('Y-m-d H:i:s');
                    if($socialLink->save()){
                        Yii::$app->session->setFlash('success', 'Company Updated successfully.');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'socialLink'=>$socialLink,
            'id'=>$id
        ]);
        }
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
