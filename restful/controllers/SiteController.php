<?php
namespace restful\controllers;

use Yii;
use common\models\LoginForm;
use restful\models\PasswordResetRequestForm;
use restful\models\ResetPasswordForm;
use restful\models\SignupForm;
use restful\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\mongodb\Query;

use yii\data\ActiveDataProvider;
use restful\models\Customer;

/**
 * Site controller
 */
class SiteController extends Controller
{
    const TOKEN = '123456';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup','reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
        return $this->render('say',['msg'=>\Yii::t('app-index','test1'),'name'=>$msg,'data'=>$models]);
    }

    public function actionIndex($lang='zh-CN')
    {
        \Yii::$app->language = isset($lang)?$lang:'zh-CN';
        $i = \Yii::t('app','test1');

        return $this->render('index');
    }

    public function actionWechat(){
        if(isset($GLOBALS["HTTP_RAW_POST_DATA"])){
            $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
            if (!empty($postStr)){
                // Log::record($postStr);
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $type = $postObj->MsgType;
                $this->openid = (string) $postObj->FromUserName;

                if($type=='event'){

                    if('subscribe'==$postObj->Event){

                        $r = new stdClass();
                        $r->tit = '【抢红包】点击进入，速领现金';
                        $r->des = '【抢红包】点击进入，速领现金';
                        $r->pic = '/data/resource/examples/red_envelope.jpg';
                        $r->ourl = 'http://mp.weixin.qq.com/s?__biz=MzA4Mjk1MjY5MA==&mid=207612090&idx=1&sn=c66dd84e273cbd484750460748ef3114#rd';

                        $r1 = new stdClass();
                        $r1->tit = '【颜值高】你的朋友圈一定有这些人';
                        $r1->des = '【颜值高】你的朋友圈一定有这些人';
                        $r1->pic = '/data/resource/examples/see_story.jpg';
                        $r1->ourl = 'http://m.70c.com/w/SYCWQA';

                        $r2 = new stdClass();
                        $r2->tit = '【吃货入】带你开启最梦幻的舌尖之旅';
                        $r2->des = '【吃货入】带你开启最梦幻的舌尖之旅';
                        $r2->pic = '/data/resource/examples/eat_in.jpg';
                        $r2->ourl = 'http://www.pbyaj.com/wap/index.html?_a=share&_f=index&uid=' . $share_id;

                        $r3 = new stdClass();
                        $r3->tit = '【手别抖】免单的机会在此，根本停不下来！';
                        $r3->des = '【手别抖】免单的机会在此，根本停不下来！';
                        $r3->pic = '/data/resource/examples/play_game.jpg';
                        $r3->ourl = 'http://www.pbyaj.com/wap/tmpl/activity/zl';

                        $res = [$r,$r1,$r2,$r3];

                        $this->response_morearts($res, 1, $postObj);

                    }
                }

            }
        }else{
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            file_put_contents('./test.log',$signature);
            if($this->valid()){
            } else {
                $echoStr = $_GET["echostr"];
                echo $echoStr;die();
            }
        }
    }

    //回复多图文
    private function response_morearts($res,$rid,$postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $textTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<ArticleCount>%s</ArticleCount>
		<Articles>
		ITEM
		</Articles>
		</xml>";
        $resstr =  sprintf($textTpl, $fromUsername, $toUsername, time(), "news", count($res));
        $item = '';
        $subitem = "<item>
		<Title><![CDATA[%s]]></Title>
		<PicUrl><![CDATA[%s]]></PicUrl>
		<Url><![CDATA[%s]]></Url>
		</item>";
        foreach ($res as $r){
            $addpos = '?';
            if(stripos($r->ourl, '?')!==false){
                $addpos = '&';
            }
            $r->ourl = $r->ourl.$addpos.'wxid='.$fromUsername;
            if (stripos($r->ourl, 'wid=')==false) $r->ourl .= '&wid='.$this->wid;
            if (stripos($r->ourl, 'rid=')==false) $r->ourl .= '&rid='.$rid;
            //$r->ourl = $r->ourl.'#mp.weixin.qq.com';
            $item.=sprintf($subitem, $r->tit, 'http://www.pbyaj.com'.$r->pic, $r->ourl);
        }
        $resstr = str_replace('ITEM', $item, $resstr);
        echo $resstr;
    }


    private function valid(){
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            echo $echoStr;
            return true;
        }
        return false;
    }

    private function checkSignature(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = self::TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
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
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
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
