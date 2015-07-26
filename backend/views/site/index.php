<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = \Yii::t('app-gallery','GoolYa');
//var_dump(\Yii::$app->session->get('user'));
?>
<div class="site-index">

    <!--<?=phpinfo()?>-->
    <div class="jumbotron">
        <h1><?=\Yii::t('app-gallery','Welcome to GoolYa')?></h1>

        <p class="lead"><?=\Yii::t('app-gallery','GoolYa Description')?></p>
        <div class="row">
            <div class="col-md-6 col-xs-6">
                <div><!--http://goolya.com/site/download?app_type=android--><a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.goolya.weiyi"><b style="text-decoration: underline;">下载安卓版</b></a></div>
                <div><img width="100px" src="/images/android.png"></div>
            </div>
            <div class="col-md-6 col-xs-6">
                <div><!--<a href="http://goolya.com/site/download?app_type=ios">--><a href="https://itunes.apple.com/cn/app/gu-ya-wei-yi/id998760067?mt=8"><b style="text-decoration: underline;">下载IOS版
                </b></a></div>
                <div><img width="100px" src="/images/ios.png"></div>
            </div>
           <!-- <div  class="col-lg-4"><img width="200px" src="/images/ios.png"></div>-->
        </div>
    
        <?php if(!\common\models\User::loginUser()){?>
        <p><?= Html::a(\Yii::t('app-gallery','join us'), ['site/signup'],['class' => 'btn btn-lg btn-success']) ?>&nbsp;&nbsp;<?= Html::a(\Yii::t('app-gallery','Login Now'), ['site/login'],['class' => 'btn btn-lg btn-success']) ?></p>
        <?php } ?>
    </div>

    <div class="body-content hide">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading<?=\Yii::t('app-index','test1',['username'=>'zhang'])?></h2>
'
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
