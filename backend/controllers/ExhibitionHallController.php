<?php

namespace backend\controllers;

use backend\models\Gallery;
use Yii;
use backend\models\ExhibitionHall;
use backend\models\ExhibitionHallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExhibitionHallController implements the CRUD actions for ExhibitionHall model.
 */
class ExhibitionHallController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExhibitionHall models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExhibitionHallSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ExhibitionHall model.
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
     * Creates a new ExhibitionHall model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExhibitionHall;

        if ( $model->load(Yii::$app->request->post())  ) {

            $gallery_id = \Yii::$app->request->post()['ExhibitionHall']['gallery_id'];
            $model->gallery_name = Gallery::findOne(['id'=>$gallery_id])['name'];
            $model->created_at = date('Y-m-d H:i:s',time());

            if($model->save()){
                if( isset(\Yii::$app->request->post()['work_id']) ){
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        foreach(\Yii::$app->request->post()['work_id'] as $work_id){
                            \Yii::$app->db->createCommand()->insert('work_in_exhibition',
                                ['work_id'=>$work_id,'hall_id'=>$model->id]
                            )->execute();
                        }
                        // ... 执行其他 SQL 语句 ...
                        $transaction->commit();
                    } catch(Exception $e) {
                        $transaction->rollBack();
                    }
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ExhibitionHall model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post())) {
            $gallery_id = \Yii::$app->request->post()['ExhibitionHall']['gallery_id'];
            $model->gallery_name = Gallery::findOne(['id'=>$gallery_id])['name'];
            $model->updated_at = date('Y-m-d H:i:s',time());
            if($model->save()){

                if(isset(\Yii::$app->request->post()['work_id'])){

                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        \Yii::$app->db->createCommand()->delete('work_in_exhibition',['hall_id'=>$model->id])->execute();
                        foreach(\Yii::$app->request->post()['work_id'] as $work_id){
                            \Yii::$app->db->createCommand()->insert('work_in_exhibition',
                                ['work_id'=>$work_id,'hall_id'=>$model->id]
                            )->execute();
                        }
                        // ... 执行其他 SQL 语句 ...
                        $transaction->commit();

                    } catch(Exception $e) {
                        $transaction->rollBack();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ExhibitionHall model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        if($this->findModel($id)->delete()){
            WorkInExhibition::deleteAll(['hall_id'=>$id]);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExhibitionHall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ExhibitionHall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExhibitionHall::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
