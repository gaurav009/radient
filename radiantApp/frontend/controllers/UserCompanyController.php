<?php

namespace frontend\controllers;

use Yii;
use frontend\models\UserCompany;
use frontend\models\search\UserCompany as UserCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * UserCompanyController implements the CRUD actions for UserCompany model.
 */
class UserCompanyController extends Controller
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
     * Lists all UserCompany models.
     * @return mixed
     */
    public function actionIndex($userId)
    {
        $searchModel = new UserCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $userId);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'userId' => $userId
        ]);
    }

    /**
     * Displays a single UserCompany model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new UserCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($userId)
    {
        $model = new UserCompany();

        if ( $model->load(Yii::$app->request->post()) ) {

            if(isset($_FILES['UserCompany']) && $_FILES['UserCompany']['name']['cv']){
                $uploadedFilename = $_FILES['UserCompany']['name']['cv'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $model->cv = UploadedFile::getInstance($model, 'cv');
                $model->cv->saveAs(RP_APP_ROOT.'/__uploaded__/user/' .$filename);
                $model->cv = $filename;
            }
            $model->phone = str_replace('-', '', $model->phone);
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            $model->user_id = $userId;
            if($model->save()){

                Yii::$app->session->setFlash('success', 'User Created successfully.');
                return $this->redirect(['index', 'userId'=>$model->user_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ( $model->load(Yii::$app->request->post()) ) {

            if(isset($_FILES['UserCompany']) && $_FILES['UserCompany']['name']['cv']){
                $uploadedFilename = $_FILES['UserCompany']['name']['cv'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename.'.'.$fileExt;
                $model->cv = UploadedFile::getInstance($model, 'cv');
                $model->cv->saveAs(RP_APP_ROOT.'/__uploaded__/user/' .$filename);
                $model->cv = $filename;
            }

            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');
            $model->phone = str_replace('-', '', $model->phone);
            if($model->save()){
                Yii::$app->session->setFlash('success', 'User Updated successfully.');
                return $this->redirect(['index', 'userId'=>$model->user_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserCompany model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
