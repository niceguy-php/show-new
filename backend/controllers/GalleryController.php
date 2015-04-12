<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use backend\models\Gallery;
use backend\models\GallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
    public $uploadPath = '../web/uploads/gallery_logo/';
    public $dbUploadPath = '/uploads/gallery_logo/';
    public $defaultLogo = 'default.png';

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
     * Lists all Gallery models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GallerySearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Gallery model.
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
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery();

        if ($model->load(Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'logo');
            if ( $model->validate()) {
                $filename = time().rand(1000,9999);

                if($logo){
                    $ext = $logo->extension;
                    $logo->saveAs($this->uploadPath . $filename . '.' . $ext);
                    $model->logo = $this->dbUploadPath . $filename . '.' . $ext;
                }else{
                    $model->logo = $this->dbUploadPath . $this->defaultLogo;
                }
            }
            if(!User::isAdmin()){
                $model->user_id = User::loginUser()['id'];
                $model->user_name = User::loginUser()['username'];
            }
            $model->user_id = intval($model->user_id);
            $model->user_name = User::findOne(['id'=>$model->user_id])['username'];
            $model->created_at = date('Y-m-d H:i:s',time());
            if($model->save()){
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
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $logoPath = $model->logo;

        //var_dump(Yii::$app->request->post());return;
        if ($model->load( Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'logo');
            if ( $model->validate()) {
                $filename = time().rand(1000,9999);
                if($logo){
                    $ext = $logo->extension;
                    $logo->saveAs($this->uploadPath . $filename . '.' . $ext);
                    $model->logo = $this->dbUploadPath . $filename . '.' . $ext;

                    $full_name = $this->uploadPath.basename($logoPath);
                    if(is_file($full_name)){
                        unlink($full_name);
                    }

                }else{
                    $model->logo = $logoPath;
                }
            }
            if(!User::isAdmin()){
                $model->user_id = User::loginUser()['id'];
                $model->user_name = User::loginUser()['username'];
            }
            $model->user_id = intval($model->user_id);
            $model->user_name = User::findOne(['id'=>$model->user_id])['username'];
            //var_dump($model);return;
            $model->updated_at = date('Y-m-d H:i:s',time());
            if($model->save()){
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
     * Deletes an existing Gallery model.
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
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
