<?php

use app\modules\module_block_main_head\ext\Head;

$head = new Head($Db, $General, $Translate, $Modules, $Router, $Notifications);

$banners = $head->getBanners();
if(isset($_SESSION['user_admin'])){
    if(isset($_POST['title']) && !isset($_POST['editBanner'])){
        exit(json_encode($head->addBanner($_POST), true));
    } elseif(isset($_POST['editBanner'])){
        exit(json_encode($head->updateBanner($_POST['editBanner'],$_POST), true));
    } elseif(isset($_POST['del_banner'])){
        exit(json_encode($head->deleteBanner($_POST['id_del']), true));
    } elseif(isset($_POST['sortBanners'])){
        exit(json_encode($head->sortBanners($_POST['order']), true));
    }
}