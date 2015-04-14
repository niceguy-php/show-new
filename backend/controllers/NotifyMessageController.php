<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use backend\models\NotifyMessage;
use backend\models\NotifyMessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * NotifyMessageController implements the CRUD actions for NotifyMessage model.
 */
class NotifyMessageController extends Controller
{
    public function behaviors()
    {
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

    /**
     * Lists all NotifyMessage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotifyMessageSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single NotifyMessage model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new NotifyMessage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NotifyMessage;

        $post = Yii::$app->request->post();
        if (User::isAdmin() && $post && isset($post['NotifyMessage']['message']) && isset($post['user_id'])){
            $user_ids = $post['user_id'];
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $map = ['gallery'=>'@所有美术馆','artist'=>'@所有艺术家','user'=>'@所有普通用户','0'=>'@all'];
                $loginUser = User::loginUser();
                foreach($user_ids as $uid){

                    if(!in_array($uid,['gallery','artist','user','0'])){
                        $user = User::find()->where(['id'=>$uid])->one();
                        $to_user_name = $user->username.'('.$user->realname.')';
                    }else{
                        $to_user_name = $map[$uid];
                    }
                    \Yii::$app->db->createCommand()->insert('notify_message',
                        ['from_user_id'=>$loginUser['id'],
                            'to_user_id'=>$uid,
                            'to_user_name'=>$to_user_name,
                            'from_user_name'=>$loginUser['username'].'('.$loginUser['realname'].')',
                        'created_at'=>date('Y-m-d H:i:s',time()),
                            'read_status'=>0,
                            'message'=>$post['NotifyMessage']['message']
                        ])->execute();
                }
                $transaction->commit();
            } catch(Exception $e) {
                $transaction->rollBack();
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing NotifyMessage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing NotifyMessage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NotifyMessage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return NotifyMessage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(User::isAdmin()){

            if (($model = NotifyMessage::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

        }

    }
}
