<?php
namespace backend\controllers;

use backend\models\Gallery;
use backend\models\ShowRoom;
use Yii;
use common\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use backend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\Query;

use yii\data\ActiveDataProvider;
use frontend\models\Customer;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','reset-password','download'],
                'rules' => [
                    [
                        'actions' => ['signup','reset-password','download'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','download','signup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionSay($msg='yangyanxiang')
    {
        /*$collection = Yii::$app->mongodb->getCollection('users');
        $collection->insert(['name' => 'John Smith', 'status' => 1]);
        $query = new Query;
        // compose the query
        $query->select(['name', 'status'])
            ->from('users')
            ->limit(10);
        // execute the query
        $rows = $query->all();

        $provider = new ActiveDataProvider([
            'query' => Customer::find(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        $models = $provider->getModels();*/
        $models = null;
        return $this->render('say',['msg'=>\Yii::t('app-index','test1'),'data'=>$models]);
    }

    public function actionDownload($app_type){
        $app_type = $_GET['app_type'];
        if($app_type=='android'){
            $file = '../../weiyi.apk';
        }else{
            $file = '../../weiyi.ipa';
        }
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

    }

    public function actionIndex($lang='zh-CN')
    {
        \Yii::$app->language = isset($lang)?$lang:'zh-CN';
        $i = \Yii::t('app','test1');

        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $session = \Yii::$app->session;
            if(!$session->isActive){
                $session->open();
            }
            $session->set('user',$model->getUser());
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    $session = \Yii::$app->session;
                    if(!$session->isActive){
                        $session->open();
                    }
                    $session->set('user',$user);

                    $gallery = new Gallery();
                    $showroom = new ShowRoom();
                    $gallery->addDefaultGallery();
                    $showroom->addDefaultShowRoom();
                    //var_dump($gallery->errors);
                    //var_dump($showroom->errors);

                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
        //var_dump($model->errors);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
