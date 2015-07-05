<?php

namespace frontend\controllers;

use Yii;
use backend\models\Article;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Gallery;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends ActiveController
{
    public $modelClass = 'backend\models\Article';
    public $result = ['data'=>[],'code'=>0];
    public function init()
    {
        $session = \Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
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
        if($_POST){

            $offsetMap = [Article::NEWS=>'news_offset',
                            Article::EVENTS=>'events_offset',
                                Article::RESEARCH=>'research_offset'];

            $category = $_POST['category'];
            $gallery_id = $_POST['gallery_id'];

            $limit = isset($_POST['limit'])? $_POST['limit']:5;

            $offset = 0;
            if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get($offsetMap[$category])){//区分上下滑动时异步请求和正常请求
                $offset = $session_offset;

            }

            if(in_array($category,[Article::EVENTS,Article::NEWS,Article::RESEARCH])){
                $condition = ['category'=>$category];
                if(isset($gallery_id)){
                    $condition = ['category'=>$category,'gallery_id'=>$gallery_id];
                }
                $this->result['data'] = Article::find()->where($condition)->orderBy(['created_at'=>SORT_DESC])
                    ->offset($offset)->limit($limit)->asArray()->all();
                $count = count($this->result['data']);
                if($count>0){//上下滑动屏幕时的请求
                    \Yii::$app->session->set($offsetMap[$category],$count+$offset);
                }
            }else{
                $this->result['code'] = -1;
            }
        }else{

            $this->result['code'] = -1;
        }
        return $this->result;
    }

    public function actionCollectedList(){
       // $defalt_collected = Article::find()->where(['show_in_collection'=>Article::IN_COLLECTION])->orderBy(['created_at'=>SORT_DESC])->asArray()->all();

        $limit = isset($_POST['limit'])? $_POST['limit']:100;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('collected_article_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

        $sql = <<<SQL
SELECT * FROM article h
WHERE show_in_collection=1 OR h.id in (SELECT subscrible_id FROM subscription WHERE subscrible_type=5 AND user_id=:user_id)
ORDER BY created_at DESC
LIMIT :offset,:limit
SQL;
        $loginUser = \common\models\User::loginUser();
        $login_uid = isset($loginUser['id'])?$loginUser['id']:0;
        $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':user_id',$login_uid)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();
        // $this->result['data'] = Work::find()->orderBy(['created_at'=>SORT_DESC])
        //    ->offset($offset)->limit($limit)->asArray()->all();
        //$this->result['data'] = $defalt_collected;
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('collected_article_offset',$count+$offset);
        }

        if(isset($_POST['pull']) && $offset==0){
            $this->result['data'] = [];
        }

        return $this->result;
    }

    public function actionGetone(){
        if($_POST){
            $aid = $_POST['id'];
            $this->result['data'] = Article::findOne(['id'=>$aid]);
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

}
