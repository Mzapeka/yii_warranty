<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 03.12.17
 * Time: 16:13
 */

use kartik\sidenav\SideNav;
use yii\helpers\Url;

?>
<div class="col-xs-8 col-sm-2 sidebar-offcanvas" id="sidebar">
    <?php
 try{
     echo SideNav::widget([
          'items' => [
              [
                  'url' => Url::to('customers'),
                  'label' => 'Клиенты',
                  'icon' => 'home',
                  'active' => $this->context->id == 'customers',
              ],          [
                  'url' => Url::to('warranties'),
                  'label' => 'Гарантии',
                  'icon' => 'home',
                  'active' => $this->context->id == 'warranties',
              ],          [
                  'url' => Url::to('manuals'),
                  'label' => 'Инструкции',
                  'icon' => 'home',
                  'active' => $this->context->id == 'manuals',
              ],
              [
                  'url' => ['/site/about'],
                  'label' => 'About',
                  'icon' => 'info-sign',
                  'items' => [
                       ['url' => '#', 'label' => 'Item 1'],
                       ['url' => '#', 'label' => 'Item 2'],
                  ],
              ],
          ],
      ]);
 }catch (Exception $e){
        Yii::$app->session->setFlash('error', 'Ошибка вывода информации: '.$e->getMessage());
 }?>
</div>

