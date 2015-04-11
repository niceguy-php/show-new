<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' =>  \Yii::t('app-gallery','My Company'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => \Yii::t('app-gallery','Home'), 'url' => ['/site/index']],
            ];
            $loginUser = \Yii::$app->session->get('user');

            if(!Yii::$app->user->isGuest){
                if($loginUser['role'] == \common\models\User::ROLE_GALLERY_ADMIN) {
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Personal Info Setting'), 'url' => ['/user/index']];

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Subscriptions'), 'url' => ['/subscription/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Notify Messages'), 'url' => ['/notify-message/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Articles'), 'url' => ['/article/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Works'), 'url' => ['/work/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Recommend Applies'), 'url' => ['/recommend-apply/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Exhibition Halls'), 'url' => ['/exhibition-hall/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Show Rooms'), 'url' => ['/show-room/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','My Galleries'), 'url' => ['/gallery/index']];
                }else if($loginUser['role'] == \common\models\User::ROLE_ADMIN){

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Users'), 'url' => ['/user/index']];

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Comments'), 'url' => ['/comment/index']];

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Subscriptions'), 'url' => ['/subscription/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Notify Messages'), 'url' => ['/notify-message/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Articles'), 'url' => ['/article/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Works'), 'url' => ['/work/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Recommend Applies'), 'url' => ['/recommend-apply/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Exhibition Halls'), 'url' => ['/exhibition-hall/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Show Rooms'), 'url' => ['/show-room/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Galleries'), 'url' => ['/gallery/index']];
                }else if($loginUser['role'] == \common\models\User::ROLE_ARTIST) {

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Personal Info Setting'), 'url' => ['/user/index']];

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Subscriptions'), 'url' => ['/subscription/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Notify Messages'), 'url' => ['/notify-message/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','My Works'), 'url' => ['/work/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Recommend Applies'), 'url' => ['/recommend-apply/index']];

                }else if($loginUser['role'] == \common\models\User::ROLE_USER) {

                    $menuItems[] = ['label' => \Yii::t('app-gallery','Personal Info Setting'), 'url' => ['/user/index']];


                    $menuItems[] = ['label' => \Yii::t('app-gallery','Notify Messages'), 'url' => ['/notify-message/index']];
                    $menuItems[] = ['label' => \Yii::t('app-gallery','Subscriptions'), 'url' => ['/subscription/index']];
                    //$menuItems[] = ['label' => \Yii::t('app-gallery','Recommend Applies'), 'url' => ['/recommend-apply/index']];

                }

            }
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => \Yii::t('app-gallery','Login'), 'url' => ['/site/login']];
                $menuItems[] = ['label' => \Yii::t('app-gallery','Signup'), 'url' => ['/site/signup']];
            } else {
                $menuItems[] = [
                    'label' =>\Yii::t('app-gallery','Logout'). ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];

            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
