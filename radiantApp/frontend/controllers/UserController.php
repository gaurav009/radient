<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserMaster;
use frontend\models\UserCompany;
use common\models\User;
use frontend\models\search\UserMaster as UserMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;


class UserController extends Controller
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
     * Lists all UserMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserMaster model.
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
     * Creates a new UserMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserMaster();
        $userCompany = new UserCompany();

        if ($model->load(Yii::$app->request->post()) && $userCompany->load(Yii::$app->request->post())) {
            
            if(isset($_FILES['UserCompany']) && $_FILES['UserCompany']['name']['cv']){
                $uploadedFilename = $_FILES['UserCompany']['name']['cv'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $userCompany->cv = UploadedFile::getInstance($userCompany, 'cv');
                $userCompany->cv->saveAs(RP_APP_ROOT.'/__uploaded__/user/' .$filename);
                $userCompany->cv = $filename;
            }
            $model->is_admin = 0;
            $model->status = User::STATUS_ACTIVE;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_at = time();
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_at = time();
            $model->email = $userCompany->email;
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->verification_token = Yii::$app->security->generateRandomString() . '_' . time();


            $userCompany->phone = str_replace('-', '', $userCompany->phone);
            $userCompany->created_by = Yii::$app->user->identity->id;
            $userCompany->created_on = date('Y-m-d H:i:s');
            $userCompany->updated_by = Yii::$app->user->identity->id;
            $userCompany->updated_on = date('Y-m-d H:i:s');
            
                
            $valid = $model->validate();
            $valid = $userCompany->validate() && $valid;

            if( $valid ){
                if($model->save()){
                    $userCompany->user_id = $model->id;
                    if($userCompany->save()){
                        Yii::$app->session->setFlash('success', 'User Created successfully.');
                        return $this->redirect(['index']);
                    }
                    
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'userCompany' => $userCompany
        ]);
    }

    /**
     * Updates an existing UserMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userCompany = UserCompany::findOne(['user_id'=>$id]);

        if ( $model->load(Yii::$app->request->post()) 
                && $userCompany->load(Yii::$app->request->post()) ) {

            if(isset($_FILES['UserCompany']) && $_FILES['UserCompany']['name']['cv']){
                $uploadedFilename = $_FILES['UserCompany']['name']['cv'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $userCompany->cv = UploadedFile::getInstance($userCompany, 'cv');
                $userCompany->cv->saveAs(RP_APP_ROOT.'/__uploaded__/user/' .$filename);
                $userCompany->cv = $filename;
            }

            if ($model->password) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            } else {
                $model->password = '1234567';
                $model->cpassword = '1234567';
            }
            
            $valid = $model->validate();
            $valid = $userCompany->validate() && $valid;

            if( $valid ){
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = time();
                if($model->save()){
                    $userCompany->phone = str_replace('-', '', $userCompany->phone);
                    if($userCompany->save()){
                        Yii::$app->session->setFlash('success', 'User Updated successfully.');
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'userCompany' => $userCompany
        ]);
    }
    
    public function actionPassword($id)
    {
        $model = $this->findModel($id);

        if ( $model->load(Yii::$app->request->post()) ) {

            if($model->password){
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password);
            }
            
            $valid = $model->validate();

            if( $valid ){
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_at = time();
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'User Password Updated successfully.');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('password', [
            'model' => $model
        ]);
    }

    
    /**
     * Finds the UserMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
