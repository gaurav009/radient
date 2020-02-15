<?php

namespace frontend\controllers;

use Yii;
use frontend\models\AccessMaster;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

class AccessController extends Controller
{
    public $enableCsrfValidation = false;
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

    public function actionIndex($id=2)
    {
        $errors = [];
        if (Yii::$app->request->post()) {
            $errors = [];
            $processFlag = true;
            $postRequest = Yii::$app->request->post('access');

            $role = isset($postRequest['role']) && intval($postRequest['role']) ? intval($postRequest['role']) : 0;
            $keys = isset($postRequest['keys']) && is_array($postRequest['keys']) ? $postRequest['keys'] : [];
            if ( !$role ){
                $errors['role'] = 'Role is required';
                $processFlag = false;
            }

            if ( !count($keys) ){
                $errors['keys'] = 'Select access permission';
                $processFlag = false;
            }

            if ( $processFlag ) {
                AccessMaster::deleteAll(['role_id'=> $role]);
                foreach ($keys as $k){
                    $model = AccessMaster::find()->where(['role_id'=> $role, 'access_key'=> $k])->one();
                    if( empty($model) ){
                        $model = new AccessMaster();
                    }
                    $model->role_id = $role;
                    $model->access_key = $k;
                    $model->created = date('Y-m-d H:i:s');
                    $model->save();
                }
                Yii::$app->session->setFlash('success', 'Permission added successfully.');
            }
        }
        
        $accessPermission = ArrayHelper::map(
                        AccessMaster::find()->where(['role_id'=> $id])->all(),
                        'access_key', 'access_key');
        return $this->render('index', [
            'errors' => $errors,
            'accessPermission' => $accessPermission
        ]);
    }
}
