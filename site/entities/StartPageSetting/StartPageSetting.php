<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.02.18
 * Time: 16:22
 */

namespace site\entities\StartPageSetting;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * StartPageSetting model
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $icon
 * @property integer $created_at
 * @property integer $updated_at
 *
 */

class StartPageSetting extends ActiveRecord
{
    public function attributeLabels()
    {
        return self::labels();
    }

    public static function labels($name=null)
    {
        $labelsArray = array(
            'id' => 'ID',
            'name' => 'Имя раздела',
            'url' => 'URL',
            'icon' => 'Иконка',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        );
        if(!is_null($name)){
            if(ArrayHelper::keyExists($name, $labelsArray)){
                return $labelsArray[$name];
            }
            return null;
        }
        return $labelsArray;
    }

    public static function create(
        string $name,
        string $url,
        string $icon
    ):self
    {
        $setting = new StartPageSetting();
        $setting->name = $name;
        $setting->url = $url;
        $setting->icon = $icon;
        return $setting;
    }


    public function edit(
        string $name,
        string $url,
        string $icon
    ):void
    {
        $this->name = $name;
        $this->url = $url;
        $this->icon = $icon;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%first_page_settings}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}