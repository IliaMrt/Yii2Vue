<?php

//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Headers: authorization');
//header('Access-Control-Allow-Credentials: true');

namespace app\modules\api\controllers;

use app\models\Feedbacks;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\filters\Cors;
use yii\rest\Controller;

class DefaultController extends Controller

{

//    public function behaviors(){
//        return array_merge(parent::behaviors(),[
//            'cors'=>Cors::class
//        ]);
//    }
    public function behaviors()
    {

        return ArrayHelper::merge([
            [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['get', 'POST','HEAD', 'OPTIONS'],
                ],
            ],
        ], parent::behaviors());
    }


    public function actionIndex()
    {
    }

    public function actionGetCafes()
    {
        $client = new Client(['baseUrl' => 'https://bandaumnikov.ru/api/test/site/get-index']);
        $articleResponse = $client->get('')->send();
        return $articleResponse->content;
    }

    public function actionGetFeedbacksCount()
    {
        return Feedbacks::feedbacksCount();
    }

    public function actionGetFeedbacksById()
    {
        return Feedbacks::findByCafeId($this->request->get('id'));
    }

    public function actionSaveFeedback()
    {
        return Feedbacks::saveFeedback($this->request->post());
    }

}