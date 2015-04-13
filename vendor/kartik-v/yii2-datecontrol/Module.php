<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package yii2-datecontrol
 * @version 1.9.0
 */

namespace kartik\datecontrol;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;

/**
 * Date control module for Yii Framework 2.0
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class Module extends \yii\base\Module
{
    const FORMAT_DATE = 'date';
    const FORMAT_TIME = 'time';
    const FORMAT_DATETIME = 'datetime';

    /**
     * @var array the format settings for displaying each date attribute. An associative array that need to be setup as
     * $type => $format, where:
     * `$type`: string, one of the FORMAT constants, and
     * `$format`: string, the PHP date/time format.
     * If this is not set, will automatically use the settings from Yii::$app->formatter based on the type setting in the
     * DateControl widget.
     */
    public $displaySettings = [];

    /**
     * @var array the format settings for saving each date attribute.  An associative array that need to be setup as
     * $type => $format, where:
     * `$type`: string, one of the FORMAT constants, and
     * `$format`: string, the PHP date/time format. Set this to 'U' to save it in Unix timestamp.
     * @see `Module::initSettings()`
     */
    public $saveSettings = [];

    /**
     * @var string the timezone for the displayed date. If not set, no timezone
     * setting will be applied for formatting.
     * @see http://php.net/manual/en/timezones.php
     */
    public $displayTimezone;

    /**
     * @var string the timezone for the saved date. If not set, no timezone
     * setting will be applied for formatting.
     * @see http://php.net/manual/en/timezones.php
     */
    public $saveTimezone;
    
    /**
     * @var bool whether to automatically use \kartik\widgets based on `$type`. Will use these widgets:
     * - \kartik\date\DatePicker for Module::FORMAT_DATE
     * - \kartik\time\TimePicker for Module::FORMAT_TIME
     * - \kartik\datetime\DateTimePicker for Module::FORMAT_DATETIME
     * If this is `true`, the `widgetSettings` will be autogenerated.
     * @see `Module::initSettings()`
     */
    public $autoWidget = true;

    /**
     * @var array, the auto widget settings that will be used to render the date input when `autoWidget` is set to `true`.
     * An associative array that need to be setup as `$type` => `$settings`, where:
     * - `$type`: string is one of the FORMAT constants, and
     * - `$settings`: array, the widget settings for the kartik\widgets based on the type.
     * @see `Module::initSettings()`
     */
    public $autoWidgetSettings = [];

    /**
     * @var array the widget settings that will be used to render the date input. An associative array that need
     * to be setup as `$type` => `$settings`, where:
     * - `$type`: string is one of the FORMAT constants, and
     * - `$settings`: array which consists of these keys:
     *    - `class`: string, the widget class name for the input widget that will render the date input.
     *    - `options`: array, the HTML attributes for the input widget
     * If `autoWidget` is true, this will be autogenerated.
     * @see `Module::initSettings()`
     */
    public $widgetSettings = [];

    /**
     * @var string the route/action to convert the date as per the `saveFormat` in DateControl widget.
     */
    public $convertAction = '/datecontrol/parse/convert';

    /**
     * @var boolean, whether to use ajax based date conversion from display to save formats. If 
     * set to false, the plugin will use php-date-formatter.js to convert to the set formats using 
     * client side validation.
     *
     * @see https://github.com/kartik-v/php-date-formatter
     */
    public $ajaxConversion = true;
    
    /**
     * Initializes the module
     */
    public function init()
    {
        $this->initSettings();
        parent::init();
    }

    /**
     * Initializes module settings
     */
    public function initSettings()
    {
        $this->saveSettings += [
            self::FORMAT_DATE => 'Y-m-d',
            self::FORMAT_TIME => 'H:i:s',
            self::FORMAT_DATETIME => 'Y-m-d H:i:s',
        ];
        $this->initAutoWidget();
    }

    /**
     * Initializes the autowidget settings
     */
    protected function initAutoWidget()
    {
        $format = $this->getDisplayFormat(self::FORMAT_TIME);
        
        $settings = [
            self::FORMAT_DATE => [
                'convertFormat' => true,
            ],
            self::FORMAT_DATETIME => [
                'convertFormat' => true,
            ],
            self::FORMAT_TIME => [
                'pluginOptions' => [
                    'showSeconds' => (strpos($format, 's') > 0) ? true : false,
                    'showMeridian' => (strpos($format, 'a') > 0 || strpos($format, 'A') > 0) ? true : false
                ]
            ],
        ];
        $this->autoWidgetSettings = ArrayHelper::merge($settings, $this->autoWidgetSettings);
    }

    /**
     * Gets the display timezone
     * @return string 
     */
    public function getDisplayTimezone() {
        if (!empty(Yii::$app->params['dateControlDisplayTimezone'])) {
            return Yii::$app->params['dateControlDisplayTimezone'];
        } elseif (!empty($this->displayTimezone)) {
            return $this->displayTimezone;
        } else {
            return null;
        }
    }
    
    /**
     * Gets the save timezone
     * @return string
     */
    public function getSaveTimezone() {
        if (!empty(Yii::$app->params['dateControlSaveTimezone'])) {
            return Yii::$app->params['dateControlSaveTimezone'];
        } elseif (!empty($this->saveTimezone)) {
            return $this->saveTimezone;
        } else {
            return null;
        }
    }

    /**
     * Gets the display format for the date type. Derives the format based on the following validation sequence:
     * - if `dateControlDisplay` is set in `Yii::$app->params`, it will be first used
     * - else, the format as set in `displaySettings` will be used from this module
     * - else, the format as set in `Yii::$app->formatter` will be used
     *
     * @param string $type the attribute type whether date, datetime, or time
     * @return mixed|string
     */
    public function getDisplayFormat($type)
    {
        if (!empty(Yii::$app->params['dateControlDisplay'][$type])) {
            $value = Yii::$app->params['dateControlDisplay'][$type];
        } elseif (!empty($this->displaySettings[$type])) {
            $value = $this->displaySettings[$type];
        } else {
            $attrib = $type . 'Format';
            $value = isset(Yii::$app->formatter->$attrib) ? Yii::$app->formatter->$attrib : '';
        }
        return self::parseFormat($value, $type);
    }

    /**
     * Gets the save format for the date type. Derives the format based on the following validation sequence:
     * - if `dateControlSave` is set in `Yii::$app->params`, it will be first used
     * - else, the format as set in `displaySettings` will be used from this module
     * - else, the format as set in `Yii::$app->formatter` will be used
     *
     * @param string $type the attribute type whether date, datetime, or time
     * @return mixed|string
     */
    public function getSaveFormat($type)
    {
        if (!empty(Yii::$app->params['dateControlSave'][$type])) {
            $value = Yii::$app->params['dateControlSave'][$type];
        } elseif (!empty($this->saveSettings[$type])) {
            $value = $this->saveSettings[$type];
        } else {
            $attrib = $type . 'Format';
            $value = isset(Yii::$app->formatter->$attrib) ? Yii::$app->formatter->$attrib : '';
        }
        return self::parseFormat($value, $type);
    }
    
    /**
     * Parse and return format understood by PHP DateTime
     */
    public static function parseFormat($format, $type)
    {
        if (strncmp($format, 'php:', 4) === 0) {
            return substr($format, 4);
        } elseif ($format != '') {
            return FormatConverter::convertDateIcuToPhp($format, $type);
        } else {
           throw InvalidConfigException("Error parsing '{$type}' format.");
        }
    }
    
    /**
     * Gets the default options for the `\kartik\widgets` based on `type`
     *
     * @param string $type
     * @param string $format
     * @return array
     */
    public static function defaultWidgetOptions($type, $format)
    {
        $options = [];
        if (!empty($format) && $type !== self::FORMAT_TIME) {
            $options['convertFormat'] = true;
            $options['pluginOptions']['format'] = 'php:' . $format;
        } elseif (!empty($format) && $type === self::FORMAT_TIME) {
            $options['pluginOptions']['showSeconds'] = (strpos($format, 's') > 0) ? true : false;
            $options['pluginOptions']['showMeridian'] = (strpos($format, 'a') > 0 || strpos($format, 'A') > 0) ? true : false;
        }
        return $options;
    }
}