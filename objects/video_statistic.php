<?php

if (empty($global['systemRootPath'])) {
    $global['systemRootPath'] = "../";
}
require_once $global['systemRootPath'] . 'videos/configuration.php';
require_once $global['systemRootPath'] . 'objects/bootGrid.php';
require_once $global['systemRootPath'] . 'objects/user.php';
require_once $global['systemRootPath'] . 'objects/functions.php';


class VideoStatistic {

    private $id;
    private $when;
    private $ip;
    private $users_id;
    private $videos_id;

    static function save($videos_id) {
        global $global;
        /**
         * Dont crash if is an old version
         */
        $result = $global['mysqli']->query("SHOW TABLES LIKE 'videos_statistics'");
        if (empty($result->num_rows)) {
            echo "<div class='alert alert-danger'>You need to <a href='{$global['webSiteRootURL']}update'>update your system</a></div>";
            return false;
        }
        
        if (empty($videos_id)) {
            die(__("You need a video to generate statistics"));
        }

        $userId = empty($_SESSION["user"]["id"]) ? "NULL" : $_SESSION["user"]["id"];

        $sql = "INSERT INTO videos_statistics "
                . "(`when`,ip, users_id, videos_id) values "
                . "(now(),'".getRealIpAddr()."',{$userId}, '{$videos_id}')";
        $insert_row = $global['mysqli']->query($sql);

        if ($insert_row) {
           return $global['mysqli']->insert_id;;
        } else {
            die($sql . ' Save Video Statistics Error : (' . $global['mysqli']->errno . ') ' . $global['mysqli']->error);
        }
    }


}
