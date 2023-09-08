<?php

namespace common\models;

use yii\db\ActiveRecord;

class Currency extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%currency}}'; // Имя таблицы в базе данных
    }

    public function rules()
    {
        return [
            [['date', 'currency', 'value'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['currency'], 'in', 'range' => ['EUR', 'USD']],
            [['value'], 'number', 'min' => 10, 'max' => 100],
        ];
    }
}