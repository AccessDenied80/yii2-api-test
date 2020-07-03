<?php
declare(strict_types=1);

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ApiData extends ActiveRecord
{
    static function tableName()
    {
        return 'api_data';
    }

    public function batchSave(array $items) : void
    {
        if (empty($items))
            return;

        $keys = array_keys($items[0]);
        $values = array_values($items);

        Yii::$app->db->createCommand()
            ->batchInsert(self::tableName(), $keys, $values)
            ->execute();

    }

    public function clearData() : void
    {
        Yii::$app->db->createCommand()
            ->truncateTable(self::tableName())
            ->execute();
    }

}