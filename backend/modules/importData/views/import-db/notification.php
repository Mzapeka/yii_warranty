<?php
/**
 * Created by PhpStorm.
 * User: mzapeka
 * Date: 25.11.17
 * Time: 16:01
 */

/* @var $notification string */
/* @var $connectionStatus bool */

$status = $connectionStatus ? 'alert-success' : 'alert-danger';

?>

<div class="alert <?=$status?> alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= $notification ?>
</div>
