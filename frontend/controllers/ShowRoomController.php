<?php

namespace frontend\controllers;

use Yii;
use backend\models\ShowRoom;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ShowRoomController extends ActiveController
{
    public $modelClass = 'backend\models\ShowRoom';
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
        

        $limit = isset($_POST['limit'])? $_POST['limit']:10;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('showroom_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }
if(isset($_POST['gallery_id'])){
    $sql =<<<SQL
SELECT s.*,g.name AS gallery_name FROM show_room s, gallery g WHERE s.user_id = g.user_id AND s.status=1 AND s.gallery_id=:gallery_id
ORDER BY s.created_at DESC
LIMIT :offset,:limit
SQL;

    $this->result['data'] =  \Yii::$app->db->createCommand($sql)
        ->bindParam(':gallery_id',$_POST['gallery_id'])
        ->bindParam(':offset',$offset)
        ->bindParam(':limit',$limit)
        ->queryAll();
}else{
$sql =<<<SQL
SELECT s.*,g.name AS gallery_name FROM show_room s, gallery g WHERE s.user_id = g.user_id AND s.status=1
ORDER BY s.created_at DESC
LIMIT :offset,:limit
SQL;

$this->result['data'] =  \Yii::$app->db->createCommand($sql)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();

}

/*$this->result['data'] = ShowRoom::find()->where(['status'=>ShowRoom::OPEN])->orderBy(['created_at'=>SORT_DESC])
    ->offset($offset)->limit($limit)->asArray()->all();*/
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('showroom_offset',$count+$offset);
        }

           
        
        return $this->result;
    }


    public function actionGetone(){
        if($_POST){
            $id = $_POST['id'];
            $this->result['data'] = ShowRoom::findOne(['id'=>$id]);
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
WHERE id in (SELECT we.work_id FROM work_in_exhibition we WHERE we.show_room_id=:room_id )
SQL;

            $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':room_id',$id)->query();
            //$this->result['data']['exhibition_list'] = ExhibitionHall::find(['gallery_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->asArray()->all();

        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

}
