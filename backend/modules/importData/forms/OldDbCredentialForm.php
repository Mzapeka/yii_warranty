<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 23.11.17
 * Time: 23:01
 */

namespace app\modules\importData\forms;


use yii\base\Model;

class OldDbCredentialForm extends Model
{
    public $path;
    public $dbName;
    public $userName;
    public $pass;

    public function rules()
    {
        return [
            [['path', 'dbName', 'userName'], 'required'],
            ['pass', 'default'],
        ];
    }

    public function loadFromParams()
    {
        $this->path = \Yii::$app->params['host'];
        $this->dbName = \Yii::$app->params['dbName'];
        $this->userName = \Yii::$app->params['userName'];
        $this->pass = \Yii::$app->params['pass'];
    }

}