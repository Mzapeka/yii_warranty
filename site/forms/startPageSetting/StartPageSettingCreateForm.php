<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\startPageSetting;


use yii\base\Model;


class StartPageSettingCreateForm extends Model
{

    public $name;
    public $url;
    public $icon;

    public function rules(): array
    {
        return [
            [['name', 'url', 'icon'], 'required'],
            [['name'], 'string', 'max' => 32],
            [['icon'], 'string'],
            [['url'], 'url', 'defaultScheme' => 'http'],
        ];
    }

}