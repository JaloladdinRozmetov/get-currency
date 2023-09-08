<?php

namespace common\models;

use yii\db\ActiveRecord;

class Items extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%items}}'; // Имя таблицы в базе данных
    }

    public function rules()
    {
        return [
            [['name', 'category', 'price', 'currency'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['category', 'price'], 'integer'],
            [['currency'], 'in', 'range' => ['EUR', 'USD']],
        ];
    }
}