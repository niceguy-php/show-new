<?php
/**
 * Created by PhpStorm.
 * User: qiumeilin
 * Date: 2015/4/4
 * Time: 8:54
 */

namespace backend\controllers;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Area;
use yii\filters\AccessControl;


class AreaController extends Controller
{
    public function behaviors()
    {
        //$behaviors = parent::behaviors();
       // $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','create','update','view','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    function actionList()
    {
        $id = \Yii::$app->request->post('id');

        if(isset($id))
            return json_encode(Area::twoLevel($id));
    }

}