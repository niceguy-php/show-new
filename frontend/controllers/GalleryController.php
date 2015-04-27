<?php

namespace frontend\controllers;

use backend\models\ExhibitionHall;
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

       
       /* $this->result['data'] = Gallery::find()->orderBy(['created_at'=>SORT_DESC])
            ->offset($offset)->limit($limit)->asArray()->all();*/

        $sql = <<<SQL
SELECT
*,
(SELECT count(*) FROM subscription) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE e.created_at>=date_add(now(),interval -1 month)) as recentCount
FROM gallery as g
ORDER BY g.created_at ASC
LIMIT :offset,:limit
SQL;

        $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();

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
            $sql = <<<SQL
select
*,
(SELECT count(*) FROM subscription WHERE subscrible_id=:id) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall WHERE gallery_id=:id) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE gallery_id=:id AND e.created_at>=date_add(now(),interval -1 month)) as recentCount
from gallery as g
where id=:id
SQL;

            $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':id',$id)->queryOne();
            $this->result['data']['exhibition_list'] = ExhibitionHall::find(['gallery_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->asArray()->all();
            
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }


}
