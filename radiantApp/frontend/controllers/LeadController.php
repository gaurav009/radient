<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Lead;
use frontend\models\search\Lead as LeadSearch;
use frontend\models\search\LeadFollowup as LeadFollowUpSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\User;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use frontend\models\LeadFollowup;
use frontend\models\Customer;
use frontend\models\AccessMaster;
use yii\filters\AccessControl;

class LeadController extends Controller
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

    /*
    * Tabbing for lead
    */
    public function actionIndex()
    {
        $hasAccess = true; // get action permission based on role
        if ($hasAccess) {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->searchActive(Yii::$app->request->queryParams);

            return $this->render('active', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('You are not authorized to view this page.');
        }
    }
    public function actionAllocated()
    {
        $hasAccess = AccessMaster::hasAccess('allocateTicket'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->searchAllocated(Yii::$app->request->queryParams);

            return $this->render('allocated', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('You are not authorized to view this page.');
        }
    }
    public function actionScrapped()
    {
        $hasAccess =  AccessMaster::hasAccess('scrapTicket'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->searchScrapped(Yii::$app->request->queryParams);

            return $this->render('scrapped', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('You are not authorized to view this page.');
        }
    }
    public function actionClosed()
    {
        $hasAccess = AccessMaster::hasAccess('closeTicket'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->searchClosed(Yii::$app->request->queryParams);

            return $this->render('closed', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('You are not authorized to view this page.');
        }
    }
    public function actionRejected()
    {
        $hasAccess = AccessMaster::hasAccess('rejectTicket'); // get action permission based on role
        if ($hasAccess) {
            $searchModel = new LeadSearch();
            $dataProvider = $searchModel->searchRejected(Yii::$app->request->queryParams);

            return $this->render('rejected', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        } else {
            throw new NotFoundHttpException('You are not authorized to view this page.');
        }
    }
    /*
    * Tabbing section end
    */


    public function actionView($id)
    {
        $searchModel = new LeadFollowUpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        $leadFollowup = new LeadFollowup();
        if ($leadFollowup->load(Yii::$app->request->post())) {

            $followStatus = Lead::Lead_Active;
            $submitButton = Yii::$app->request->post('submit');
            if ( $submitButton == 'save') {
                $followStatus = Lead::Lead_Active;
            } else if ( $submitButton == 'reject') {
                $followStatus = Lead::Lead_Rejected;
            } else if ( $submitButton == 'scrap') {
                $followStatus = Lead::Lead_Scrapped;
            } else if ( $submitButton == 'close') {
                $followStatus = Lead::Lead_Closed;
            } 



            $leadFollowup->lead_id = $model->id;
            $leadFollowup->status = $followStatus;
            $leadFollowup->created_by = Yii::$app->user->identity->id;
            $leadFollowup->created_on = date('Y-m-d H:i:s');
            $leadFollowup->updated_by = Yii::$app->user->identity->id;
            $leadFollowup->updated_on = date('Y-m-d H:i:s');
            if ($leadFollowup->save()) {
                return $this->redirect(['index']);
            }
            //echo '<pre>'; print_r($leadFollowup->errors); die();
        }
        return $this->render('view', [
            'model' => $model,
            'leadFollowup' => $leadFollowup,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionAllocation($id)
    {
        $hasAccess = AccessMaster::hasAccess('allocateTicket'); // get action permission based on role
        if ($hasAccess) {
            $model = $this->findModel($id);
            if ($model->load(Yii::$app->request->post())) {

                $model->updated_by = Yii::$app->user->identity->id;
                $model->updated_on = date('Y-m-d H:i:s');
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }

            return $this->render('allocation', [
                'model' => $model
            ]);
        }
    }

    public function actionFollowup($id)
    {
        $hasAccess = AccessMaster::hasAccess('followupTicket'); // get action permission based on role
        if ($hasAccess) {
            $model = $this->findModel($id);
            return $this->render('followup', [
                'model' => $model,
                'leadFollowup' => $leadFollowup
            ]);
        }
    }

    public function actionCreate()
    {
       
        $hasAccess = AccessMaster::hasAccess('addLead'); // get action permission based on role
        if ($hasAccess) { 
        $model = new Lead();

        if ($model->load(Yii::$app->request->post())) {

            $model->status = Lead::Lead_Active;
            $model->created_by = Yii::$app->user->identity->id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');

            if (isset($_FILES['Lead']) && $_FILES['Lead']['name']['attachment']) {
                $uploadedFilename = $_FILES['Lead']['name']['attachment'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename . '.' . $fileExt;
                $model->attachment = UploadedFile::getInstance($model, 'attachment');
                $model->attachment->saveAs(RP_APP_ROOT . '/__uploaded__/lead/' . $filename);
                $model->attachment = $filename;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Lead Created successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
    /**
     * Updates an existing Lead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $hasAccess = AccessMaster::hasAccess('updateLead'); // get action permission based on role
        if ($hasAccess) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->updated_by = Yii::$app->user->identity->id;
            $model->updated_on = date('Y-m-d H:i:s');

            if (isset($_FILES['Lead']) && $_FILES['Lead']['name']['attachment']) {
                $uploadedFilename = $_FILES['Lead']['name']['attachment'];
                $fileExt  = pathinfo($uploadedFilename, PATHINFO_EXTENSION);
                $filename = pathinfo($uploadedFilename, PATHINFO_FILENAME);
                $filename = preg_replace('/\s+/', '_', $filename);

                $filename = $filename . '.' . $fileExt;
                $model->attachment = UploadedFile::getInstance($model, 'attachment');
                $model->attachment->saveAs(RP_APP_ROOT . '/__uploaded__/lead/' . $filename);
                $model->attachment = $filename;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Lead Updated successfully.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
    /**
     * Finds the Lead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lead the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lead::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /*
    * Autocomplete Details
    */
    public function actionAutocompleteCustomerName()
    {
        if (Yii::$app->request->isAjax) {
            $query = isset($_REQUEST['query']) && trim($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

            $opt['query'] = 'Unit';
            $opt['suggestions'] = [];
            if (strlen($query)) {

                $fetchCustomer = Customer::find()->where(['status' => User::STATUS_ACTIVE])
                    ->andFilterWhere(['like', 'name', $query])->all();
                //$fetchCustomer = array_unique($fetchCustomer);
                foreach ($fetchCustomer as $cus) {
                    $opt['suggestions'][] = ['value' => $cus->name, 'data' => $cus->name, 'other' => $cus->attributes];
                }
            }
            return json_encode($opt);
        }
    }

    public function actionAutocompleteCompany()
    {
        if (Yii::$app->request->isAjax) {
            $query = isset($_REQUEST['query']) && trim($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

            $opt['query'] = 'Unit';
            $opt['suggestions'] = [];
            if (strlen($query)) {

                $fetchCustomer = Customer::find()->where(['status' => User::STATUS_ACTIVE])
                    ->andFilterWhere(['like', 'company', $query])->all();
                //$fetchCustomer = array_unique($fetchCustomer);
                foreach ($fetchCustomer as $cus) {
                    $opt['suggestions'][] = ['value' => $cus->company, 'data' => $cus->company, 'other' => $cus->attributes];
                }
            }
            return json_encode($opt);
        }
    }

    public function actionAutocompleteEmail()
    {
        if (Yii::$app->request->isAjax) {
            $query = isset($_REQUEST['query']) && trim($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

            $opt['query'] = 'Unit';
            $opt['suggestions'] = [];
            if (strlen($query)) {

                $fetchCustomer = Customer::find()->where(['status' => User::STATUS_ACTIVE])
                    ->andFilterWhere(['like', 'email', $query])->all();
                //$fetchCustomer = array_unique($fetchCustomer);
                foreach ($fetchCustomer as $cus) {
                    $opt['suggestions'][] = ['value' => $cus->email, 'data' => $cus->email, 'other' => $cus->attributes];
                }
            }
            return json_encode($opt);
        }
    }

    public function actionAutocompleteMobile()
    {
        if (Yii::$app->request->isAjax) {
            $query = isset($_REQUEST['query']) && trim($_REQUEST['query']) ? trim($_REQUEST['query']) : '';

            $opt['query'] = 'Unit';
            $opt['suggestions'] = [];
            if (strlen($query)) {

                $fetchCustomer = Customer::find()->where(['status' => User::STATUS_ACTIVE])
                    ->andFilterWhere(['like', 'mobile', $query])->all();
                //$fetchCustomer = array_unique($fetchCustomer);
                foreach ($fetchCustomer as $cus) {
                    $opt['suggestions'][] = ['value' => $cus->mobile, 'data' => $cus->mobile, 'other' => $cus->attributes];
                }
            }
            return json_encode($opt);
        }
    }
    //==========================//
}
