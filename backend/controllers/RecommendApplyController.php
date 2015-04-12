<?php

namespace backend\controllers;

use backend\models\Gallery;
use backend\models\Work;
use common\models\User;
use Yii;
use backend\models\RecommendApply;
use backend\models\RecommendApplySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RecommendApplyController implements the CRUD actions for RecommendApply model.
 */
class RecommendApplyController extends Controller
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
     * Lists all RecommendApply models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecommendApplySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single RecommendApply model.
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
     * Creates a new RecommendApply model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new RecommendApply;
        $loginUser = User::loginUser();

        $post = Yii::$app->request->post();
        $post['RecommendApply']['reply_user_id'] = 0;
        $post['RecommendApply']['replay_content'] = '';
        if ($model->load(Yii::$app->request->post()) ) {
            $model->apply_user_id = $loginUser['id'];
            $model->apply_user_name = $loginUser['username'].'('.$loginUser['realname'].')';
            $model->work_name = Work::find()->where(['id'=>$model->work_id])->one()['name'];
            $model->gallery_name = Gallery::find()->where(['id'=>$model->gallery_id])->one()['name'];
            $model->apply_status =RecommendApply::APPLY_NOTAUDIT;
            $model->created_at = date('Y-m-d H:i:s',time());
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->errors);
                //return $this->render('create', ['model' => $model]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RecommendApply model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if(User::isAdmin()||User::isGalleryAdmin()){

            if($_POST){
                $staus = $_POST['RecommendApply']['apply_status'];
                $reply_content = trim($_POST['RecommendApply']['replay_content']);
                $loginUser = User::loginUser();
                $id = intval($_GET['id']);
                if(in_array($staus,['0','1','2']) && isset($reply_content) &&is_numeric($id)){
                    \Yii::$app->db->createCommand()->update('recommend_apply',
                        ['apply_status'=>$staus,'replay_content'=>$reply_content,
                            'reply_user_id'=>$loginUser['id'],
                            'reply_user_name'=>$loginUser['username'].'('.$loginUser['realname'].')'],
                        'id = '.$id)->execute();
                    return $this->redirect(['index']);

                }else{
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        }else{


            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Deletes an existing RecommendApply model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if($model->apply_status != RecommendApply::APPLY_PASS){
            $model->delete();
        }else{

        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the RecommendApply model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RecommendApply the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RecommendApply::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
