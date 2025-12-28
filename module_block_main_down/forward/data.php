<?php

use app\modules\module_block_main_down\ext\Down;

$down = new Down($Db, $General, $Translate, $Modules, $Router, $Notifications);

$blocks = $down->getBlocks();
if(isset($_SESSION['user_admin'])){
    if(isset($_POST['title']) && !isset($_POST['editBlock'])){
        exit(json_encode($down->addBlock($_POST), true));
    } elseif(isset($_POST['editBlock'])){
        exit(json_encode($down->updateBlock($_POST['editBlock'],$_POST), true));
    } elseif(isset($_POST['del_block'])){
        exit(json_encode($down->deleteBlock($_POST['id_del']), true));
    } elseif(isset($_POST['sortBlocks'])){
        exit(json_encode($down->sortBlocks($_POST['order']), true));
    }
}