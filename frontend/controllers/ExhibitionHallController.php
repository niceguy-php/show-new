<?php

namespace frontend\controllers;

use backend\models\User;
use Yii;
use backend\models\ExhibitionHall;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ExhibitionHallController extends ActiveController
{
    public $modelClass = 'backend\models\ExhibitionHall';
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
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('hall_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }


        if($_POST['gallery_id']){
            $this->result['data'] = ExhibitionHall::find()->where(['gallery_id'=>$_POST['gallery_id']])->orderBy(['created_at'=>SORT_DESC])
                ->offset($offset)->limit($limit)->asArray()->all();
        }else{
            $this->result['data'] = ExhibitionHall::find()->orderBy(['created_at'=>SORT_DESC])
                ->offset($offset)->limit($limit)->asArray()->all();
        }
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('hall_offset',$count+$offset);
        }
        return $this->result;
    }

    public function actionCollectedList(){
       // $defalt_collected = ExhibitionHall::find()->where(['show_in_collection'=>ExhibitionHall::IN_COLLECTION])->orderBy(['created_at'=>SORT_DESC])->asArray()->all();
        $limit = isset($_POST['limit'])? $_POST['limit']:10;



        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('collected_hall_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

        $sql = <<<SQL
SELECT * FROM exhibition_hall h
WHERE show_in_collection=1 OR h.id in (SELECT subscrible_id FROM subscription WHERE subscrible_type=2 AND user_id=:user_id)
ORDER BY show_time DESC
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
            \Yii::$app->session->set('collected_hall_offset',$count+$offset);
        }
        return $this->result;
    }

    public function actionGetone(){
        if($_POST){
            $id = $_POST['id'];
            $this->result['data'] = ExhibitionHall::findOne(['id'=>$id]);
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

    public function getByGallery(){
        if($_POST){
            $id = $_POST['id'];
            $this->result['data'] = ExhibitionHall::findOne(['id'=>$id]);
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

    public function actionGetworks(){
        if($_POST){
            $id = $_POST['id'];
            $sql = <<<SQL
SELECT
*
FROM work
WHERE id in (SELECT we.work_id FROM work_in_exhibition we WHERE we.hall_id=:hall_id )
SQL;

            $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':hall_id',$id)->query();
            //$this->result['data']['exhibition_list'] = ExhibitionHall::find(['gallery_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->asArray()->all();

        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

    public function actionGetartistworks(){
        if($_POST){
            $id = $_POST['id'];
            $sql = <<<SQL
SELECT
*
FROM work
WHERE user_id=:user_id
SQL;

            $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':user_id',$id)->query();
            //$this->result['data']['exhibition_list'] = ExhibitionHall::find(['gallery_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->asArray()->all();

        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }



}
