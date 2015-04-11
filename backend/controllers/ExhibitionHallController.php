<?php

namespace backend\controllers;

use backend\models\Gallery;
use backend\models\UploadForm;
use common\models\User;
use Yii;
use backend\models\ExhibitionHall;
use backend\models\ExhibitionHallSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ExhibitionHallController implements the CRUD actions for ExhibitionHall model.
 */
class ExhibitionHallController extends Controller
{
    public $uploadPath = '../web/uploads/sence_pic/';
    public $dbUploadPath = '/uploads/sence_pic/';
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
        $loginUser = User::loginUser();

        if ( $model->load(Yii::$app->request->post())  ) {

            if(User::isAdmin()){
                $gallery_id = \Yii::$app->request->post()['ExhibitionHall']['gallery_id'];
            }else{
                $gallery_id = Gallery::find()->where(['user_id'=>$loginUser['id']])->one()['id'];
                $model->gallery_id = $gallery_id;
                $model->user_id = $loginUser['id'];
                $model->user_name = $loginUser['username'].'('.$loginUser['realname'].')';
            }


            $model->gallery_name = Gallery::findOne(['id'=>$gallery_id])['name'];
            $model->created_at = date('Y-m-d H:i:s',time());

            $pic1 = UploadedFile::getInstance($model, 'pic1');
            $pic2 = UploadedFile::getInstance($model, 'pic2');
            $pic3 = UploadedFile::getInstance($model, 'pic3');
            $pic4 = UploadedFile::getInstance($model, 'pic4');
            $pic5 = UploadedFile::getInstance($model, 'pic5');

            if($pic1&&!UploadForm::uploadSizeCheck($pic1->size)){
                $model->addError('pic1',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic2&&!UploadForm::uploadSizeCheck($pic2->size)){
                $model->addError('pic2',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic3&&!UploadForm::uploadSizeCheck($pic3->size)){
                $model->addError('pic3',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic4&&!UploadForm::uploadSizeCheck($pic4->size)){
                $model->addError('pic4',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic5&&!UploadForm::uploadSizeCheck($pic5->size)){
                $model->addError('pic5',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($model->errors){
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            if ($model->validate()) {

                if ($pic1) {
                    $filename1 = time() . rand(1000, 9999);
                    $ext = $pic1->extension;
                    $pic1->saveAs($this->uploadPath . $filename1 . '.' . $ext);
                    $model->pic1 = $this->dbUploadPath . $filename1 . '.' . $ext;
                }
                if ($pic2) {
                    $filename2 = time() . rand(1000, 9999);
                    $ext = $pic2->extension;
                    $pic2->saveAs($this->uploadPath . $filename2 . '.' . $ext);
                    $model->pic2 = $this->dbUploadPath . $filename2 . '.' . $ext;
                }
                if ($pic3) {
                    $filename3 = time() . rand(1000, 9999);
                    $ext = $pic3->extension;
                    $pic3->saveAs($this->uploadPath . $filename3 . '.' . $ext);
                    $model->pic3 = $this->dbUploadPath . $filename3 . '.' . $ext;
                }
                if ($pic4) {
                    $filename4 = time() . rand(1000, 9999);
                    $ext = $pic4->extension;
                    $pic4->saveAs($this->uploadPath . $filename4 . '.' . $ext);
                    $model->pic4 = $this->dbUploadPath . $filename4 . '.' . $ext;
                }

                if ($pic5) {
                    $filename5 = time() . rand(1000, 9999);
                    $ext = $pic5->extension;
                    $pic5->saveAs($this->uploadPath . $filename5 . '.' . $ext);
                    $model->pic5 = $this->dbUploadPath . $filename5 . '.' . $ext;
                }
            } else {


                return $this->render('create', [
                    'model' => $model,
                ]);
            }


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

                    //上传照片

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

        $pic1_old = $model->pic1;
        $pic2_old = $model->pic2;
        $pic3_old = $model->pic3;
        $pic4_old = $model->pic4;
        $pic5_old = $model->pic5;

        if ($model->load(Yii::$app->request->post())) {
            $gallery_id = \Yii::$app->request->post()['ExhibitionHall']['gallery_id'];
            $model->gallery_name = Gallery::findOne(['id'=>$gallery_id])['name'];
            $model->updated_at = date('Y-m-d H:i:s',time());


            $pic1 = UploadedFile::getInstance($model, 'pic1');
            $pic2 = UploadedFile::getInstance($model, 'pic2');
            $pic3 = UploadedFile::getInstance($model, 'pic3');
            $pic4 = UploadedFile::getInstance($model, 'pic4');
            $pic5 = UploadedFile::getInstance($model, 'pic5');

            if($pic1&&!UploadForm::uploadSizeCheck($pic1->size)){
                $model->addError('pic1',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic2&&!UploadForm::uploadSizeCheck($pic2->size)){
                $model->addError('pic2',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic3&&!UploadForm::uploadSizeCheck($pic3->size)){
                $model->addError('pic3',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic4&&!UploadForm::uploadSizeCheck($pic4->size)){
                $model->addError('pic4',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($pic5&&!UploadForm::uploadSizeCheck($pic5->size)){
                $model->addError('pic5',Yii::t('app-gallery','File size must less than one MB'));
            }

            if($model->errors){
                return $this->render('update', [
                    'model' => $model,
                ]);
            }

            if ($model->validate()) {

                if ($pic1) {
                    $filename1 = time() . rand(1000, 9999);
                    $ext = $pic1->extension;
                    $pic1->saveAs($this->uploadPath . $filename1 . '.' . $ext);
                    $model->pic1 = $this->dbUploadPath . $filename1 . '.' . $ext;
                    $this->deleteOldPic($pic1_old);
                }else{
                    $model->pic1 = $pic1_old;
                }
                if ($pic2) {
                    $filename2 = time() . rand(1000, 9999);
                    $ext = $pic2->extension;
                    $pic2->saveAs($this->uploadPath . $filename2 . '.' . $ext);
                    $model->pic2 = $this->dbUploadPath . $filename2 . '.' . $ext;
                    $this->deleteOldPic($pic2_old);
                }else{
                    $model->pic2 = $pic2_old;
                }
                if ($pic3) {
                    $filename3 = time() . rand(1000, 9999);
                    $ext = $pic3->extension;
                    $pic3->saveAs($this->uploadPath . $filename3 . '.' . $ext);
                    $model->pic3 = $this->dbUploadPath . $filename3 . '.' . $ext;
                    $this->deleteOldPic($pic3_old);
                }else{
                    $model->pic3 = $pic3_old;
                }
                if ($pic4) {
                    $filename4 = time() . rand(1000, 9999);
                    $ext = $pic4->extension;
                    $pic4->saveAs($this->uploadPath . $filename4 . '.' . $ext);
                    $model->pic4 = $this->dbUploadPath . $filename4 . '.' . $ext;
                    $this->deleteOldPic($pic4_old);
                }else{
                    $model->pic4 = $pic4_old;
                }

                if ($pic5) {
                    $filename5 = time() . rand(1000, 9999);
                    $ext = $pic5->extension;
                    $pic5->saveAs($this->uploadPath . $filename5 . '.' . $ext);
                    $model->pic5 = $this->dbUploadPath . $filename5 . '.' . $ext;
                    $this->deleteOldPic($pic5_old);
                }else{
                    $model->pic5 = $pic5_old;
                }
            }


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

    protected function deleteOldPic($picPath){
        $old_logo = $this->uploadPath.basename($picPath);
        if(is_file($old_logo)){
            unlink($old_logo);
        }
    }

}
