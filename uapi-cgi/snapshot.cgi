<?php 
$systemid = 0x000f6085; // System ID for the shared memory segment 
$shmid = shmop_open($systemid, "a", 0, 0); 

flush();
header("Content-Type: image/jpeg");

// $read_data = shmop_read($shmid, 0, 200);
// for ($i=0; $i<200; $i++) {  print (ord($read_data[$i]).",");}

$read_data = shmop_read($shmid, 0, 4);
$sz = ord($read_data[0]) | ord($read_data[1]) <<8 | ord($read_data[2]) <<16 | ord($read_data[3])<<24;
if (!$sz) {
    $sz = 300000;
}
// print ($sz);
// // string shmop_read ( int shmid, int start, int count)

$img = shmop_read($shmid, 4, $sz);
echo $img;
// $img_b64 = base64_encode($img);
// print '<img id="img" src="data:image/jpg;base64,'.$img_b64.'" width="640" height="320"></img>';

shmop_close($shmid);
?>

