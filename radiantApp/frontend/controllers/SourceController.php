<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Source;
use frontend\models\search\Source as SourceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use frontend\models\AccessMaster;

/**

 * SourceController implements the CRUD actions for Source model.

 */

class SourceController extends Controller

{
    /**

     * {@inheritdoc}

     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    /**
     * Lists all Source models.

     * @return mixed

     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addSource') || AccessMaster::hasAccess('updateSource') || AccessMaster::hasAccess('uploadSource'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new SourceSearch();
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

     * Displays a single Source model.

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

     * Creates a new Source model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addSource'); // get action permission based on role
        if ($hasAccess) {

            $model = new Source();
            if ($model->load(Yii::$app->request->post())) {
                $model->status = User::STATUS_ACTIVE;
                $model->created_by = Yii::$app->user->identity->id;

                $model->created_on = date('Y-m-d H:i:s');

                $model->updated_by = Yii::$app->user->identity->id;

                $model->updated_on = date('Y-m-d H:i:s');

                if (!$model->parent_id) {

                    $model->parent_id = 0;
                }



                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'Source Created successfully.');

                    return $this->redirect(['index']);
                }
            }



            return $this->render('create', [

                'model' => $model,

            ]);
        }
    }

    /**

     * Updates an existing Source model.

     * If update is successful, the browser will be redirected to the 'view' page.

     * @param integer $id

     * @return mixed

     * @throws NotFoundHttpException if the model cannot be found

     */

    public function actionUpdate($id)

    {
        $hasAccess =  AccessMaster::hasAccess('updateSource'); // get action permission based on role
        if ($hasAccess) {
            $model = $this->findModel($id);



            if ($model->load(Yii::$app->request->post())) {



                $model->updated_by = Yii::$app->user->identity->id;

                $model->updated_on = date('Y-m-d H:i:s');

                if (!$model->parent_id) {

                    $model->parent_id = 0;
                }

                if ($model->save()) {

                    Yii::$app->session->setFlash('success', 'Source Updated successfully.');

                    return $this->redirect(['index']);
                }
            }



            return $this->render('update', [

                'model' => $model,

            ]);
        }
    }



    /**

     * Deletes an existing Source model.

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

     * Finds the Source model based on its primary key value.

     * If the model is not found, a 404 HTTP exception will be thrown.

     * @param integer $id

     * @return Source the loaded model

     * @throws NotFoundHttpException if the model cannot be found

     */

    protected function findModel($id)

    {

        if (($model = Source::findOne($id)) !== null) {

            return $model;
        }



        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
