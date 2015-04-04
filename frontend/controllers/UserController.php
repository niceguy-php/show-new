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

    public function actionLoginapp()
    {

        $request = \Yii::$app->request;
        $user = User::findByUsername($request->get('username'));
        if( $user->password == $request->get('password') ){
            $this->result['data'] = $user;
            //$result['sess'] = \Yii::$app->session;
            return $this->result;
        }
        return $this->result;
    }

    public function actionSignup()
    {
        $post = \Yii::$app->request->post();
        $model = new User();
        $model->attributes = $post;

        if ($model->validate()) {
            $model->username = $post['username'];
            $model->password = $post['password'];
            $model->email = $post['email'];
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
    }

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
    public function actionResetPass()
    {

    }


}