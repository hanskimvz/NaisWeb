<?php

$fname ="/mnt/db/param.db";
$db = new SQLite3($fname);


if ($_GET['page']=='users') {
    $sq = "select * from user_tbl";
    $level = array("Administrator", "Operator","Viewer");

    // $tag_userlist = '';
    // while ($row = $rs->fetchArray()) {
    //     // print_r($row);
    //     $user_info =  $row['id'].FillText($level[$row['level']], 30, "right");
    //     $tag_userlist .= '<option value="'.$row['prino'].'">'.$user_info.'</option>';
    // }
}

else if ($_GET['page'] == 'netloss'){
    $sq = "select * from param_tbl where group1='netloss'";
}
else if ($_GET['page'] == 'heartbeat'){
    $sq = "select * from param_tbl where group1='heartbeat'";
}
else if ($_GET['page'] == 'event_profile') {
    $sq = "select * from param_tbl where group1='eventprofile'";
}

$rs = $db->query($sq);

$arr_rs= array();
while ($row = $rs->fetchArray()) {
	// print_r($row);
	$arr_rs[$row['groupPath'].'.'.$row['entryName']] = $row['entryValue'];
}
$db->close();

require_once $_SERVER['DOCUMENT_ROOT']."/inc/json.php";
$json = new Services_JSON();
$json_str = $json->encode($arr_rs);
print($json_str);

?>

