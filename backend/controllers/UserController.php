<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $uploadPath = '../web/uploads/user_logo/';
    public $dbUploadPath = '/uploads/user_logo/';
    public $defaultMaleLogo = 'default_male.png';
    public $defaultFemaleLogo = 'default_female.png';
    public $userRole;
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User;

        $this->userRole = \Yii::$app->session->get('user')['role'];
        if($this->userRole == \common\models\User::ROLE_ADMIN) {
            $model = new User();

            if ($model->load(Yii::$app->request->post())) {
                $logo = UploadedFile::getInstance($model, 'avatar');
                if ($model->validate()) {

                    $filename = time() . rand(1000, 9999);

                    if ($logo) {
                        $ext = $logo->extension;
                        $logo->saveAs($this->uploadPath . $filename . '.' . $ext);
                        $model->avatar = $this->dbUploadPath . $filename . '.' . $ext;
                    } else {

                        $model->avatar = ($model->sex==\common\models\User::SEX_MAN)
                            ? $this->dbUploadPath . $this->defaultMaleLogo:
                            $this->dbUploadPath . $this->defaultFemaleLogo;
                    }
                } else {
                    var_dump($model->errors);
                }

                $model->created_at = time();
                if ($model->save()) {
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

    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->userRole = \Yii::$app->session->get('user')['role'];
        $model = $this->findModel($id);

        $logoPath = $model->avatar;
        if ($model->load(Yii::$app->request->post())) {
            $logo = UploadedFile::getInstance($model, 'avatar');
            if ( $model->validate()) {
                $filename = time().rand(1000,9999);
                if($logo){
                    $ext = $logo->extension;
                    $logo->saveAs($this->uploadPath . $filename . '.' . $ext);
                    $model->avatar = $this->dbUploadPath . $filename . '.' . $ext;
                    if(basename($logoPath)!=$this->defaultFemaleLogo && basename($logoPath)!=$this->defaultMaleLogo){
                        $old_logo = $this->uploadPath.basename($logoPath);
                        if(is_file($old_logo)){
                            unlink($old_logo);
                        }

                    }
                }else{
                    $model->avatar = $logoPath;
                }
            }

            $model->updated_at = time();;

            //不为admin的时候删除无权操作的字段，在进行保存
            if($this->userRole != \common\models\User::ROLE_ADMIN) {
                unset($model->id_verify_status);
                unset($model->status);
                unset($model->role);
                unset($model->username);
            }

            if(isset($model->password) && $model != '!@#********!@#'){
                //$user = new User();
                //$user->resetPassword($model->id,$model->password);
                $model->password = md5($model->password);
            }
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
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
