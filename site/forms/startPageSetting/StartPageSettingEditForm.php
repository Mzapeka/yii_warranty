<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 05.10.17
 * Time: 0:16
 */

namespace site\forms\startPageSetting;


use site\entities\StartPageSetting\StartPageSetting;
use yii\base\Model;

class StartPageSettingEditForm extends Model
{

    public $name;
    public $url;
    public $icon;

    public function __construct(StartPageSetting $startPageSetting, array $config = [])
    {
        $this->name = $startPageSetting->name;
        $this->url = $startPageSetting->url;
        $this->icon = $startPageSetting->icon;
        parent::__construct($config);
    }

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