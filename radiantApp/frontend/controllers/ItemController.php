<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Item;
use frontend\models\search\Item as ItemSearch;
use yii\web\Controller;
use common\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use frontend\models\AccessMaster;


class ItemController extends Controller
{
    public $enableCsrfValidation = false;
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addItem') || AccessMaster::hasAccess('updateItem') || AccessMaster::hasAccess('uploadItem'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new ItemSearch();
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
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addItem'); // get action permission based on role
        if ($hasAccess) {
            $model = new Item();

            if ($model->load(Yii::$app->request->post())) {

                if (isset($_FILES['Item']) && $_FILES['Item']['name']['file']) {
                    $uploadedFilename = $_FILES['Item']['name']['file'];
                    $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                    $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                    $filename = preg_replace('/\s+/', '_', $filename);

                    $filename = $filename . '.' . $fileExt;
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $model->file->saveAs(RP_APP_ROOT . '/__uploaded__/item/' . $filename);
                    $model->file = $filename;
                }
                if (!empty($model->vender_id)) {
                    $model->vender_id = implode(',', $model->vender_id);
                }

                $model->status = User::STATUS_ACTIVE;
                $model->created_by = Yii::$app->user->identity->id;
                $model->created_on = date('Y-m-d H:i:s');
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Item Created successfully.');
                    return $this->redirect(['index']);
                }
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $hasAccess =  AccessMaster::hasAccess('updateItem'); // get action permission based on role
        if ($hasAccess) {
            $model = $this->findModel($id);
            $model->vender_id = explode(',', $model->vender_id);

            if ($model->load(Yii::$app->request->post())) {

                if (isset($_FILES['Item']) && $_FILES['Item']['name']['file']) {
                    $uploadedFilename = $_FILES['Item']['name']['file'];
                    $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                    $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                    $filename = preg_replace('/\s+/', '_', $filename);

                    $filename = $filename . '.' . $fileExt;
                    $model->file = UploadedFile::getInstance($model, 'file');
                    $model->file->saveAs(RP_APP_ROOT . '/__uploaded__/item/' . $filename);
                    $model->file = $filename;
                }
                if (!empty($model->vender_id)) {
                    $model->vender_id = implode(',', $model->vender_id);
                }
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Item Updated successfully.');
                    return $this->redirect(['index']);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionImport()
    {
        $hasAccess = AccessMaster::hasAccess('uploadItem'); // get action permission based on role
        if ($hasAccess) {
            $processFlag = true;
            // ----------------
            $totalRows = 0;
            $failed = 0;
            $successRows = 0;
            $errorMsg = '';
            // ----------------
            if ($processFlag) {
                $csvRows = file($_FILES['importFile']['tmp_name'], FILE_IGNORE_NEW_LINES);
                unset($csvRows[0]);

                $i = 1;
                foreach ($csvRows as $k => $v) {
                    $totalRows++;
                    $row = explode(',', trim($v, ''));

                    $model = new Item();
                    $model->item_code = isset($row[0]) ? $row[0] : '';
                    $model->name = isset($row[1]) ? trim($row[1], '"') : '';
                    $model->brand_id = isset($row[2]) ? $row[2] : '';
                    $model->category_id = isset($row[3]) ? $row[3] : '';
                    $model->uom = isset($row[4]) ? $row[4] : '';
                    $model->gst_rate = isset($row[5]) ? $row[5] : '';
                    $model->part_no = isset($row[6]) ? $row[6] : '';
                    $model->hsn = isset($row[7]) ? $row[7] : '';
                    $model->mrp = isset($row[8]) ? $row[8] : '';
                    $model->weight = isset($row[9]) ? $row[9] : '';
                    $model->dimension = isset($row[10]) ? $row[10] : '';
                    $model->unit = isset($row[11]) ? $row[11] : '';
                    $model->location = isset($row[12]) ? $row[12] : '';
                    $model->vender_id = isset($row[13]) ? str_replace('|', ',', $row[13]) : '';
                    $model->link = isset($row[14]) ? $row[14] : '';
                    $model->status = User::STATUS_ACTIVE;
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->created_on = date('Y-m-d H:i:s');
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->updated_on = date('Y-m-d H:i:s');

                    if ($model->save()) {
                        $successRows++;
                    } else {
                        if (!trim($model->name)) {
                            $errorMsg .= "Name is required for row " . $i;
                        }

                        if (!$model->brand_id) {
                            $errorMsg .= "<br />Brand Id is required for row " . $i;
                        }

                        if (!$model->category_id) {
                            $errorMsg .= "<br />Category Id is required for row " . $i;
                        }

                        $checkItem = Item::find()->where(['item_code' => $model->item_code])->one();
                        if (!empty($checkItem)) {
                            $errorMsg .= "<br />Item code  has already been taken for row " . $i;
                        }

                        $failed++;
                    }
                    $i++;
                }

                Yii::$app->session->setFlash('success', 'Item Upload <br /> Total Row ' . $totalRows . ' <br /> Success Row ' . $successRows . ' <br /> Failed Row ' . $failed . $errorMsg);
                Yii::$app->session->setFlash('error', $errorMsg);
                $this->redirect(['/item/index']);
            }
            // -------------
        }
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
