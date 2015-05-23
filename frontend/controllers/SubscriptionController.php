<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use backend\models\Subscription;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class SubscriptionController extends ActiveController
{
    public $modelClass = 'backend\models\Subscription';
    public $result = ['data'=>[],'code'=>0];
    public function init()
    {
        parent::init();
        header("Access-Control-Allow-Origin: *");
        //\Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [],
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => false,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['add','del'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
       /* return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['create','update','view','delete'],
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
        ];*/
    }

    public function actionAdd(){
        if(!User::isLogin()){ $this->result['code'] = -1;return $this->result;}

        $loginUser = User::loginUser();
        $_POST['user_name'] = $loginUser['username'].'('.$loginUser['realname'].')';
        $_POST['user_id'] = $loginUser['id'];
        $_POST['created_at'] = date('Y-m-d H:i:s',time());
        if($_POST){
           \Yii::$app->db->createCommand()->insert('subscription',$_POST)->execute();
        }else{
            $this->result['code'] = -1;
        }
        return $this->result;

    }

    public function actionDel(){

        if(!User::isLogin()){ $this->result['code'] = -1;return $this->result;}

        $condition['user_id'] = User::loginUser()['id'];
        $condition['subscrible_id'] = $_POST['subscrible_id'];
        $condition['subscrible_type'] = $_POST['subscrible_type'];
        if($_POST){
            \Yii::$app->db->createCommand()->delete('subscription',$condition)->execute();
        }else{
            $this->result['code'] = -1;
        }

        return $this->result;
    }


}
