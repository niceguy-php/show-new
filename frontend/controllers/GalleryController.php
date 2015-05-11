<?php

namespace frontend\controllers;

use backend\models\ExhibitionHall;
use backend\models\Subscription;
use common\models\User;
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
if($_POST && isset($_POST['name'])){
    $name = trim($_POST['name']);
    $sql = <<<SQL
SELECT
*,
(SELECT count(*) FROM subscription WHERE subscrible_id=g.id) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall WHERE gallery_id=g.id) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE e.created_at>=date_add(now(),interval -1 month) AND gallery_id=g.id) as recentCount
FROM gallery as g
WHERE name like CONCAT('%',:name,'%')
ORDER BY g.created_at ASC
LIMIT :offset,:limit
SQL;
    $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->bindParam(':name',$name)->queryAll();
}else{
    $sql = <<<SQL
SELECT
*,
(SELECT count(*) FROM subscription WHERE subscrible_id=g.id) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall WHERE gallery_id=g.id) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE e.created_at>=date_add(now(),interval -1 month) AND gallery_id=g.id) as recentCount
FROM gallery as g
ORDER BY g.created_at ASC
LIMIT :offset,:limit
SQL;
    $this->result['data'] = \Yii::$app->db->createCommand($sql)->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();
}

        $loginUser = User::loginUser();
        $user = User::findOne(['id'=>$loginUser['id']]);

        $this->result['default_gallery_id'] = $user['default_gallery_id'];




        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('gallery_offset',$count+$offset);
        }

           
        
        return $this->result;
    }


    public function actionCollectedList()
    {


        $limit = isset($_POST['limit'])? $_POST['limit']:10;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('collected_gallery_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

/*        $default_sql = <<<SQL
SELECT
*,
(SELECT count(*) FROM subscription WHERE subscrible_id=g.id AND subscrible_type=3) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall WHERE gallery_id=g.id) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE e.created_at>=date_add(now(),interval -1 month) AND gallery_id=g.id) as recentCount
FROM gallery as g
WHERE show_in_subscrible=1 AND id in (SELECT subscrible_id FROM subscription s WHERE user_id=:user_id AND subscrible_type=3)
ORDER BY g.created_at ASC
SQL;

        $default_collected_gallery = \Yii::$app->db->createCommand($default_sql)->queryAll();*/
            //->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();
        //$default_collected_gallery = $this->result['data'] = Gallery::find()->where(['show_in_subscrible'=>1])->orderBy(['created_at'=>SORT_DESC])
          //   ->offset($offset)->limit($limit)->asArray()->all();
        if($_POST && isset($_POST['name'])){

        }else{
            $sql = <<<SQL
SELECT
*,
(SELECT count(*) FROM subscription WHERE subscrible_id=g.id AND subscrible_type=3) as subscribleCount ,
(SELECT count(*) FROM exhibition_hall WHERE gallery_id=g.id) as allCount
,(SELECT count(*) FROM exhibition_hall e WHERE e.created_at>=date_add(now(),interval -1 month) AND gallery_id=g.id) as recentCount
FROM gallery as g
WHERE show_in_subscrible=1 AND id in (SELECT subscrible_id FROM subscription s WHERE user_id=:user_id AND subscrible_type=3)
ORDER BY g.created_at ASC
LIMIT :offset,:limit
SQL;
            $user_id = User::loginUser()['id'];
            $user_collected_gallery = \Yii::$app->db->createCommand($sql)
                ->bindParam(':user_id',$user_id)
                ->bindParam(':offset',$offset)->bindParam(':limit',$limit)->queryAll();
        }
        $this->result['data'] = $user_collected_gallery;

        $count = count($user_collected_gallery);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('collected_gallery_offset',$count+$offset);
        }
        return $this->result;
    }


    public function actionGetExhibitions(){
        if($_POST){
            $id = $_POST['id'];
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
            $this->result['data']['exhibition_list'] = ExhibitionHall::find()->where(['gallery_id'=>$id])->orderBy(['created_at'=>SORT_ASC])->asArray()->all();
            
        }else{
            $this->result['code']=-1;

        }
        return $this->result;
    }

    public function actionHasSubscribled(){
        $subscrible_type = $_POST['type'];
        $subscrible_id = $_POST['id'];
        $loginUser = User::loginUser();
//SELECT * FROM subscription WHERE user_id=44 AND subscrible_id=3 AND subscrible_type=3
        if($loginUser && $subscrible_type && $subscrible_id){
            $subscribled_obj = Subscription::find()->where(['user_id'=>$loginUser['id'],
                                        'subscrible_id'=>$subscrible_id,
                                        'subscrible_type'=>$subscrible_type])->asArray()->one();
            if($subscribled_obj){
                $this->result['data'] = 'true';
            }else{
                $this->result['data'] = 'false';
            }

        }else{
            $this->result['code'] = -1;
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
