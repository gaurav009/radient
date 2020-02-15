<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Vendor;
use common\models\User;
use frontend\models\search\Vendor as VendorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use frontend\models\AccessMaster;
use yii\web\UploadedFile;

/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends Controller
{
    public $enableCsrfValidation = false;
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
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hasAccess = AccessMaster::hasAccess('addVendor') || AccessMaster::hasAccess('updateVendor') || AccessMaster::hasAccess('uploadVendor'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new VendorSearch();
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
     * Displays a single Vendor model.
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
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $hasAccess = AccessMaster::hasAccess('addVendor'); // get action permission based on role
        if ($hasAccess) {
            $model = new Vendor();

            if ($model->load(Yii::$app->request->post())) {

                $model->status = User::STATUS_ACTIVE;
                $model->created_by = Yii::$app->user->identity->id;
                $model->created_on = date('Y-m-d H:i:s');
                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Vendor Created successfully.');
                    return $this->redirect(['index']);
                }
            }
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $hasAccess = AccessMaster::hasAccess('updateVendor'); // get action permission based on role
        if ($hasAccess) {
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post())) {

                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Vendor Updated successfully.');
                    return $this->redirect(['index']);
                }
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionAutocompleteCompany()
    {
        if (Yii::$app->request->isAjax) {
            $query = isset($_REQUEST['query']) && trim($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

            $opt['query'] = 'Unit';
            $opt['suggestions'] = [];
            if (strlen($query)) {


                $fetchCustomer = ArrayHelper::map(
                    Vendor::find()->where(['status' => User::STATUS_ACTIVE])
                        ->andFilterWhere(['like', 'company', $query])->all(),
                    'company',
                    'company'
                );
                $fetchCustomer = array_unique($fetchCustomer);
                foreach ($fetchCustomer as $cus) {
                    $opt['suggestions'][] = ['value' => $cus, 'data' => $cus];
                }
            }
            return json_encode($opt);
        }
    }

    public function actionImport()
    {
        $hasAccess =  AccessMaster::hasAccess('uploadVendor'); // get action permission based on role
        if ($hasAccess) {
            $processFlag = true;
            // ----------------
            $totalRows = 0;
            $failed = 0;
            $successRows = 0;
            // ----------------
            if ($processFlag) {
                $csvRows = file($_FILES['importFile']['tmp_name'], FILE_IGNORE_NEW_LINES);
                unset($csvRows[0]);

                foreach ($csvRows as $k => $v) {
                    $totalRows++;
                    $row = explode(',', trim($v, ''));

                    $model = new Vendor();
                    $model->vendor_code = isset($row[0]) ? $row[0] : '';
                    $model->company = isset($row[1]) ? $row[1] : '';
                    $model->address = isset($row[2]) ? $row[2] : '';
                    $model->address_1 = isset($row[3]) ? $row[3] : '';
                    $model->address_2 = isset($row[4]) ? $row[4] : '';
                    $model->address_3 = isset($row[5]) ? $row[5] : '';
                    $model->city_id = isset($row[6]) ? $row[6] : '';

                    $model->postal_code = isset($row[7]) ? $row[7] : '';
                    $model->state_id = isset($row[8]) ? $row[8] : '';
                    $model->country_id = isset($row[9]) ? $row[9] : '';
                    $model->email = isset($row[10]) ? $row[10] : '';

                    $model->phone = isset($row[11]) ? $row[11] : '';
                    $model->gst = isset($row[12]) ? $row[12] : '';
                    $model->pan_no = isset($row[13]) ? $row[13] : '';
                    $model->name = isset($row[14]) ? $row[14] : '';
                    $model->mobile = isset($row[14]) ? $row[14] : '';

                    $model->status = User::STATUS_ACTIVE;
                    $model->created_by = Yii::$app->user->identity->id;
                    $model->created_on = date('Y-m-d H:i:s');
                    $model->updated_by = Yii::$app->user->identity->id;
                    $model->updated_on = date('Y-m-d H:i:s');

                    if ($model->save()) {
                        $successRows++;
                    } else {
                        echo '<pre>';
                        print_r($model->attributes);
                        print_r($model->errors);
                        die();
                        $failed++;
                    }
                }

                Yii::$app->session->setFlash('success', 'Vendor Upload <br /> Total Row ' . $totalRows . ' <br /> Success Row ' . $successRows . ' <br /> Failed Row ' . $failed);
                $this->redirect(['/vendor/index']);
            }
            // -------------
        }
    }
    /**
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
