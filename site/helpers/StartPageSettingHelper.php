<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.02.18
 * Time: 17:14
 */

namespace site\helpers;


use site\entities\StartPageSetting\IconContainer;
use Symfony\Component\Yaml\Yaml;
use Yii;
use yii\helpers\ArrayHelper;

class StartPageSettingHelper
{
    /**
     * @return array|null
     */
    public static function getAllIcon() :? array
    {
        $data = static::getIconData();
        $result = [];
        /**
         * @var IconContainer $result[$category]
        */

        foreach ($data['icons'] as $icon){
            foreach ($icon['categories'] as $category){
                if(!ArrayHelper::keyExists($category, $result)){
                    $result[$category] = new IconContainer();
                }
                $result[$category]->setId = $icon['id'];
                $result[$category]->setName = $icon['name'];
                $result[$category]->setCategory = $category;
                $result[$category]->add();
            }
        }
        return $result;
    }

    public static function getIconNames()
    {
        $data = static::getIconData();
        $result = [];
        foreach ($data['icons'] as $icon){
            foreach ($icon['categories'] as $category){
                $result[] = $icon['id'];
            }
        }
        return $result;
    }

    private static function getIconData()
    {
        $pathToYamlWithIcons = Yii::getAlias('@vendor').'/fortawesome/font-awesome/src/icons.yml';
        try{
            return Yaml::parse(file_get_contents($pathToYamlWithIcons));
        } catch (\Exception $e){
            throw  new \RuntimeException('Icons not readed from '.$pathToYamlWithIcons);
        }
    }
}