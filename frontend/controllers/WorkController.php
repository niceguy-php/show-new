<?php

namespace frontend\controllers;

use Yii;
use backend\models\Work;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class WorkController extends ActiveController
{
    public $modelClass = 'backend\models\Work';
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
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('work_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

       
        $this->result['data'] = Work::find()->orderBy(['created_at'=>SORT_DESC])
            ->offset($offset)->limit($limit)->asArray()->all();
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('work_offset',$count+$offset);
        }

           
        
        return $this->result;
    }

    public function actionCollectedList()
    {

        //$defalt_collected = Work::find()->where(['show_in_collection'=>Work::IN_COLLECTION])->orderBy(['created_at'=>SORT_DESC])->asArray()->all();

        $limit = isset($_POST['limit'])? $_POST['limit']:5;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('collected_work_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

        $sql = <<<SQL
SELECT * FROM work h
WHERE show_in_collection=1 OR h.id in (SELECT subscrible_id FROM subscription WHERE subscrible_type=4 AND user_id=:user_id)
ORDER BY created_at DESC
LIMIT :offset,:limit
SQL;

        $loginUser = \common\models\User::loginUser();
        $login_uid = isset($loginUser['id'])?$loginUser['id']:0;
        $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':user_id',$login_uid)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();


       // $this->result['data'] = Work::find()->orderBy(['created_at'=>SORT_DESC])
        //    ->offset($offset)->limit($limit)->asArray()->all();
       // $this->result['data'] = $defalt_collected;
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('collected_work_offset',$count+$offset);
        }



        return $this->result;
    }


    public function actionGetone(){
        if($_POST){
            $id = $_POST['id'];
            $this->result['data'] = Work::findOne(['id'=>$id]);
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

    public function actionView($id)
    {
        //$model = $this->findModel($id);
        $model = $this->findModelForView($id);


        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    protected function findModelForView($id)
    {

        if (($model = Work::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
