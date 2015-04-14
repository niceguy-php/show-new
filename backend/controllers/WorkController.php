<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use backend\models\Work;
use backend\models\WorkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * WorkController implements the CRUD actions for Work model.
 */
class WorkController extends Controller
{
    public $uploadPath = '../web/uploads/work_images/';
    public $dbUploadPath = '/uploads/work_images/';
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
     * Lists all Work models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Work model.
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
     * Creates a new Work model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $this->ifNotVerified();

        $model = new Work;
        $loginUser = User::loginUser();

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');
            if ($image && $model->validate() ) {

                $filename = time() . rand(1000, 9999);
                $ext = $image->extension;
                $image->saveAs($this->uploadPath . $filename . '.' . $ext);
                $model->image = $this->dbUploadPath . $filename . '.' . $ext;

                $model->created_at = date('Y-m-d H:i:s', time());

                $model->user_id = $loginUser['id'];
                $model->user_name = $loginUser['username'].'('.$loginUser['realname'].')';
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }else{
                if(!$image){
                    $model->addError('image','请上传作品图片');
                }
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
     * Updates an existing Work model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $this->ifNotVerified();

        $model = $this->findModel($id);

        $old_image = $model->image;
        if ($model->load(Yii::$app->request->post()) ) {

            $image = UploadedFile::getInstance($model, 'image');
            if ($model->validate() ) {

                $filename = time() . rand(1000, 9999);
                if( $image ){
                    $ext = $image->extension;
                    $image->saveAs($this->uploadPath . $filename . '.' . $ext);
                    $model->image = $this->dbUploadPath . $filename . '.' . $ext;
                }else{
                    $model->image = $old_image;
                }
                $model->updated_at = date('Y-m-d H:i:s',time());
                if($model->save()){
                    $old_image_filename = $this->uploadPath.basename($old_image);
                    if(is_file($old_image_filename)){
                        unlink($old_image_filename);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Work model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->ifNotVerified();

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Work model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Work the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if(User::isAdmin()){
            $condition = $id;
        }else{
            $condition = ['id'=>$id,'user_id'=>User::loginUser()['id']];
        }
        if (($model = Work::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function ifNotVerified(){
        if(!User::loginUserVerified()||!User::galleryVerified()){
            $this->redirect(['index']);
        }
    }
}
