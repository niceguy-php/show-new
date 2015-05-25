<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;




/**
 * @var yii\web\View $this
 * @var backend\models\Work $model
 */

$this->title = $model->name;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app-gallery', 'Works'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-view">
    <div class="page-header hide">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <div style="text-align: center;margin: auto auto;">
    <a style="width:100%;" href="http://goolya.com"><img width="100%" src="http://goolya.com/images/h.jpg"></a>
    <div>

    <?= DetailView::widget([
            'model' => $model,
            'condensed'=>false,
            'hover'=>true,
            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
            'panel'=>[
            'heading'=>$this->title,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'name',
            'description',
            ['attribute'=>'image','value'=>'http://goolya.com'.$model->image,'format' => ['image',['width'=>'200','height'=>'200']]],
            'year',
            ['attribute'=>'width','value'=>$model->width.' cm'],
            ['attribute'=>'height','value'=>$model->height.' cm'],
            'material',
            //'gallery_name',
            //'hall_name',
            'author_name',
            'author_profile',
            //'user_name',
            [
                'attribute'=>'auction_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            [
                'attribute'=>'auction_end_time',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            ['attribute'=>'auction_price','value'=>$model->auction_price.' ￥'],
            ['attribute'=>'work_status',
                'value'=>$model->work_status==\backend\models\Work::VISIBLE?\Yii::t('app-gallery','Visible'):\Yii::t('app-gallery','Invisible')],
            ['attribute'=>'on_sale',
                'value'=>$model->on_sale==\backend\models\Work::ONSELL?\Yii::t('app-gallery','Onsell'):\Yii::t('app-gallery','SaleStop')],
            //'show_room_name',
            //'qrcode_image',
            ['attribute'=>'qrcode_image','format' => 'raw','value'=>'<div id="qrcode_image"></div>'],
            //'mark_count',
            //'gallery_id',
            //'user_id',
            //'hall_id',
            //'show_room_id',
            [
                'attribute'=>'created_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],
            /*[
                'attribute'=>'updated_at',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],
                'type'=>DetailView::INPUT_WIDGET,
                'widgetOptions'=> [
                    'class'=>DateControl::classname(),
                    'type'=>DateControl::FORMAT_DATETIME
                ]
            ],*/
        ],
        'deleteOptions'=>[
        'url'=>['delete', 'id' => $model->id],
        'data'=>[
        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),
        'method'=>'post',
        ],
        ],
        'enableEditMode'=>false,
    ]) ?>

<?php

\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/jquery.qrcode-0.11.0.min.js',['position'=>\yii\web\View::POS_END,'depends'=>[yii\web\JqueryAsset::className()]]) ;
//$this->registerJsFile('@web/js/create_qrcode.js',\yii\web\View::POS_END) ;
$this->beginBlock('QR_JS');
echo <<<JS
(function(){
var utf16to8 = function(str) {
            var out, i, len, c;
            out = "";
            len = str.length;
            for (i = 0; i < len; i++) {
                c = str.charCodeAt(i);
                if ((c >= 0x0001) && (c <= 0x007F)) {
                    out += str.charAt(i);
                } else if (c > 0x07FF) {
                    out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
                    out += String.fromCharCode(0x80 | ((c >> 6) & 0x3F));
                    out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
                } else {
                    out += String.fromCharCode(0xC0 | ((c >> 6) & 0x1F));
                    out += String.fromCharCode(0x80 | ((c >> 0) & 0x3F));
                }
            }
            return out;
        };
    $ = jQuery;
    var work_name = "{$model->name}";
    work_name = utf16to8(work_name);
    $(document).ready(function(){
        $('#qrcode_image').qrcode({
            "render": "div",
            "width": 100,
            "height": 100,
            "color": "#3a3",
            "text": "http://app.goolya.com/work-web/view?id={$model->id}&img={$model->image}&name="+work_name
        });
    });
})();
JS;
$this->endBlock();

$this->registerJs($this->blocks['QR_JS'],\yii\web\View::POS_END);

$this->beginBlock("CSS");
echo 'td{white-space: normal !important;}';
$this->endBlock();
$this->registerCss($this->blocks['CSS']);
?>

</div>
