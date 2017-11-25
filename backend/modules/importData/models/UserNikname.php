<?php

namespace app\modules\importData\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_nikname".
 *
 * @property int $id
 * @property string $userId
 */
class UserNikname extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_nikname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['userId'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
        ];
    }
}
