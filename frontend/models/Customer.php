<?php
/**
 * Created by PhpStorm.
 * User: qiumeilin
 * Date: 2015/3/19
 * Time: 14:39
 */

namespace frontend\models;

use yii\mongodb\ActiveRecord;

class Customer extends ActiveRecord
{
    /**
     * @return string the name of the index associated with this ActiveRecord class.
     */
    public static function collectionName()
    {
        return 'users';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return ['_id', 'name', 'status'];
    }
}