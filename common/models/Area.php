<?php
/**
 * Created by PhpStorm.
 * User: qiumeilin
 * Date: 2015/4/2
 * Time: 22:06
 */

namespace common\models;


use yii\db\ActiveRecord;
use \yii\helpers\ArrayHelper;


class Area extends ActiveRecord{
    public static function tableName()
    {
        return 'area';
    }

    public static function oneLevel()
    {
        $addresses = (new \yii\db\Query())->select('area_id,name,full_name')->from('area')->where('LENGTH(area_id)=2 ')->all();
        $listData=ArrayHelper::map($addresses,'area_id','name');
        return $listData;
    }

    public static function twoLevel($area_id)
    {


        if(isset($area_id)){
            //echo $area_id;
            $addresses = (new \yii\db\Query())->select('area_id,name,full_name')->from('area')
                ->where("area_id like "."'".$area_id."%'")->andWhere('LENGTH(area_id)=LENGTH(:area_id)+2',[':area_id'=>$area_id])
                ->all();
            $listData=ArrayHelper::map($addresses,'area_id','name');
            return $listData;
        }
        return [];

    }

    public static function threeLevel($area_id)
    {

    }

    public static function fourLevel($area_id)
    {

    }
}