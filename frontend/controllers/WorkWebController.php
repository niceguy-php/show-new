<?php

namespace frontend\controllers;

use Yii;
use backend\models\Work;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\Controller;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class WorkWebController extends Controller
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        //$behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;

        return $behaviors;

    }


    public function actionView($id)
    {
        //$model = $this->findModel($id);
        $model = $this->findModelForView($id);
        return $this->render('view', ['model' => $model]);
    }

    protected function findModelForView($id)
    {

        if (($model = Work::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
