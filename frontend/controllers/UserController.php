<?php
/**
 * Created by PhpStorm.
 * User: qiumeilin
 * Date: 2015/3/21
 * Time: 19:34
 */

namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\web\Response;
use frontend\models\PasswordResetRequestForm;
use yii\filters\auth\HttpBasicAuth;
use backend\models\SignupForm;
use common\models\LoginForm;

use common\models\User;


class UserController extends ActiveController{
    public $modelClass = 'common\models\User';
    public $result = ['data'=>[],'code'=>0];
    public function init()
    {
        parent::init();
        //\Yii::$app->user->enableSession = false;
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // 检查用户能否访问 $action 和 $model
        // 访问被拒绝应抛出ForbiddenHttpException
    }

    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        /*$behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];*/
        return $behaviors;
    }

    public function  actionTest()
    {
        return User::findOne(9);
    }

    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            $session = \Yii::$app->session;
            if(!$session->isActive){
                $session->open();
            }
            $session->set('user',$model->getUser());
            $this->result['data'] = $model->getUser();
        } else {
            $errors = $model->errors;
            if($errors){
                $this->result['data'] = $errors;
                $this->result['code'] = -1;
            }
        }
        return $this->result;
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if ( \Yii::$app->getUser()->login($user)) {
                    $session = \Yii::$app->session;
                    if(!$session->isActive){
                        $session->open();
                    }
                    $session->set('user',$model->getUser());
                    $this->result['data'] = $user;
                }
            }
        }

        $errors = $model->errors;
        if($errors){
            $this->result['data'] = $errors;
            $this->result['code'] = -1;
        }

        return $this->result;
    }

    public function actionUpdateField(){

        $post = \Yii::$app->request->post();
        if($post){
            $loginUser = User::loginUser();
            \Yii::$app->db->createCommand()->update('user',$post,['id'=>$loginUser['id']])->execute();
            $userUpdated = User::findOne(['id'=>$loginUser['id']]);
            \Yii::$app->session->set('user',User::findOne(['id'=>$loginUser['id']]));
            $this->result['data']=$userUpdated;

        }else{
            $this->result['code'] = -1;
        }

        return $this->result;

    }

    /*public function actionLoginapp()
    {

        $request = \Yii::$app->request;
        $user = User::findByUsername($request->get('username'));
        if( $user->password == md5($request->get('password')) ){
            $this->result['data'] = $user;
            //$result['sess'] = \Yii::$app->session;
            return $this->result;
        }
        return $this->result;
    }*/

    /*public function actionSignup()
    {
        $post = \Yii::$app->request->post();
        $model = new User();
        $model->attributes = $post;

        if ($model->validate()) {
            $model->username = $post['username'];
            $model->password = $post['password'];
            $model->email = $post['email'];
            $model->role = $post['role'];
            $model->created_at = time();
            $model->status = 10;
            $model->save();
            // 若所有输入都是有效的
        } else {
            // 有效性验证失败：$errors 属性就是存储错误信息的数组
            $errors = $model->errors;
            $this->result['data'] = $errors;
            $this->result['code'] = -1;
            //var_dump($errors);
        }
        return $this->result;
    }*/

    /*public function actionFindpassword()
    {

        $post = \Yii::$app->request->post();
        $email = $post['email'];
        $mail = \Yii::$app->mailer->compose();
        $mail->setTo($email)
            ->setSubject('Message subject')
            ->setTextBody('Plain text content')
            ->setHtmlBody('<b>HTML content</b>');

        if( !$mail->send()){
            $this->result['code'] = -1;
        }
        return $this->result;

    }*/

    public function actionSendemail()
    {
        $model = new PasswordResetRequestForm();
        //格式为PasswordResetRequestForm[email才能被正确load
       // $model->load(\Yii::$app->request->post());
        $model->email = \Yii::$app->request->post('email');
        if ( $model->validate()) {
            if ($model->sendEmail()) {
                return $this->result;
            } else {
                $this->result['data']['email'] = '发送失败';
                $this->result['code'] = -1;
            }
        }else{
            $errors = $model->errors;
            $this->result['data'] = $errors;
            $this->result['code'] = -1;
        }
        //$this->result['data'] = \Yii::$app->request->post();
        return $this->result;
    }

    public function actionGetArtist(){
        $limit = isset($_POST['limit'])? $_POST['limit']:10;

        $offset = 0;
        if(isset($_POST['pull'])&&$session_offset = \Yii::$app->session->get('artist_offset')){//区分上下滑动时异步请求和正常请求
            $offset = $session_offset;

        }

if($_POST && isset($_POST['name'])){
    $this->result['data'] = User::find()->where(['role'=>User::ROLE_ARTIST])->andFilterWhere(['like', 'realname',$_POST['name']])->orderBy(['created_at'=>SORT_DESC])
            ->offset($offset)->limit($limit)->asArray()->all();
}else{
    $this->result['data'] = User::find()->where(['role'=>User::ROLE_ARTIST])->orderBy(['created_at'=>SORT_DESC])
            ->offset($offset)->limit($limit)->asArray()->all();
}

        
        $count = count($this->result['data']);
        if($count>0){//上下滑动屏幕时的请求
            \Yii::$app->session->set('artist_offset',$count+$offset);
        }

        return $this->result;
    }


}