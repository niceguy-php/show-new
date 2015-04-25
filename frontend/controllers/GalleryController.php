<?php

namespace frontend\controllers;

use Yii;
use backend\models\Gallery;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class GalleryController extends ActiveController
{
    public $modelClass = 'backend\models\Gallery';
    public $result = ['data'=>[],'code'=>0];
    public function init()
    {
        parent::init();
        //\Yii::$app->user->enableSession = false;
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        /*$behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => [],
            'rules' => [
                [
                    'actions' => ['index'],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['create','update','view','delete'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];*/
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

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionList()
    {
        

        $limit = isset($_POST['limit'])? $_POST['limit']:5;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('gallery_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

       
        $this->result['data'] = Gallery::find()->orderBy(['created_at'=>SORT_DESC])
            ->offset($offset)->limit($limit)->asArray()->all();
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('gallery_offset',$count+$offset);
        }

           
        
        return $this->result;
    }


    public function actionGetone(){
        if($_POST){
            $id = $_POST['id'];
            $this->result['data'] = Gallery::findOne(['id'=>$id]);
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

}
