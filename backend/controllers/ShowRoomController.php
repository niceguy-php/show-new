<?php

namespace backend\controllers;

use backend\models\WorkInExhibition;
use Yii;
use backend\models\ShowRoom;
use backend\models\ShowRoomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ShowRoomController implements the CRUD actions for ShowRoom model.
 */
class ShowRoomController extends Controller
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
                        'allow' => true,
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
     * Lists all ShowRoom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShowRoomSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ShowRoom model.
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
     * Creates a new ShowRoom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShowRoom;
        $model->created_at = date('Y-m-d H:i:s',time());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if( isset(\Yii::$app->request->post()['work_id']) ){
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    foreach(\Yii::$app->request->post()['work_id'] as $work_id){
                        \Yii::$app->db->createCommand()->insert('work_in_exhibition',
                            ['work_id'=>$work_id,'show_room_id'=>$model->id]
                        )->execute();
                    }
                    // ... 执行其他 SQL 语句 ...
                    $transaction->commit();
                } catch(Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShowRoom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date('Y-m-d H:i:s',time());

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(isset(\Yii::$app->request->post()['work_id'])){

                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    \Yii::$app->db->createCommand()->delete('work_in_exhibition',['show_room_id'=>$model->id])->execute();
                    foreach(\Yii::$app->request->post()['work_id'] as $work_id){
                        \Yii::$app->db->createCommand()->insert('work_in_exhibition',
                            ['work_id'=>$work_id,'show_room_id'=>$model->id]
                        )->execute();
                    }
                    // ... 执行其他 SQL 语句 ...
                    $transaction->commit();

                } catch(Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShowRoom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
            WorkInExhibition::deleteAll(['show_room_id'=>$id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShowRoom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ShowRoom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShowRoom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
