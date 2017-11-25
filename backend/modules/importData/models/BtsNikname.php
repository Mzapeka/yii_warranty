<?php

namespace app\modules\importData\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "bts_nikname".
 *
 * @property int $id
 * @property string $btsId
 */
class BtsNikname extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bts_nikname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['btsId'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'btsId' => 'Bts ID',
        ];
    }


    public static function getUserIdByNik(string $nik){
        $entity = BtsNikname::findOne(['btsId'=> $nik]);
        return $entity->id;
    }
}
