<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\filters\AccessControl;
use frontend\models\UserCompany;

class DownloadController extends \yii\web\Controller
{
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
        ];
    }
    
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
    public function actionMycv($id){
        $this->layout = false;
        $processFlag = false;
        
        $userId = $id;
        if($userId){
            $userResume = UserCompany::findOne(['user_id'=> $userId]);
            
            if(!empty($userResume)){
                $fileName = $userResume->cv;
                $filePath = RP_APP_ROOT.'/__uploaded__/user/' .$userResume->cv;
                $processFlag = true;

                $this->Download($fileName, $filePath,$processFlag);
            }
        }
        
        
        if(!$processFlag){
            $this->Download('', '',$processFlag);
        }
    }
    
   
    private function Download($fileName , $filePath,$processFlag){
        // -----------------------------------------------------------------
        // -----------------------------------------------------------------
        if(!file_exists($filePath))
        {
            $processFlag = false;
        }else{
            $processFlag = true;
        }
        
        if($processFlag)
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            if(strtolower($fileExtension) == 'pdf'){
                header("Content-type:application/pdf");
                header('Content-Disposition: inline; filename=' . urlencode($fileName));
            }elseif(strtolower($fileExtension) == 'txt'){
                header("Content-type:text/plain");
                header('Content-Disposition: inline; filename=' . urlencode($fileName));
            }else{
                header('Content-Disposition: attachment; filename=' . urlencode($fileName));
                //header('Content-Type: application/force-download');
                header('Content-Type: application/octet-stream');
                //header('Content-Type: application/download');
                header('Content-Description: File Transfer'); 
            }           
            flush();
            $fp = fopen($filePath, "r");
            while (!feof($fp))
            {
                echo fread($fp, 65536);
                flush(); // this is essential for large downloads
            } 
            fclose($fp);
        }else{
            header("Content-type:text/plain");
            header('Content-Disposition: inline; filename=notFound.txt');   
            //header('Content-Disposition: attachment; filename=notFound.txt');   
            //header('Content-Type: application/force-download');
            //header('Content-Type: application/octet-stream');
            //header('Content-Type: application/download');
            //header('Content-Description: File Transfer');            
            flush();
            echo 'Sorry, the requested file is not avaialble or you are not authorized to access that file.';  
            flush();
        }
        // -----------------------------------------------------------------
        // -----------------------------------------------------------------
    }
}
