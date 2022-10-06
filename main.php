<!DOCTYPE html lang="en">
<?php
include ("inc/common.php");
echo $header;

require_once $_SERVER['DOCUMENT_ROOT']."/inc/json.php";
$json = new Services_JSON();
$json_str = file_get_contents($_SERVER['DOCUMENT_ROOT']."/inc/menu.json");
$objmenu = $json->decode($json_str);
// print_r($objmenu);

$top_left_menu= '';
foreach(($objmenu->top_left_menu) as $menu ){
    if ($menu->flag =='n') {
        continue;
    }
    $disabled =  $menu->id == "live" ? "disabled" : "";
    $top_left_menu.= '<button class="btn btn-white" onClick="location.href=(\''.$menu->href.'\')" style="padding:10px 0px 10px 0px; text-align:center;" '.$disabled.'>'.$menu->display.'</button>';
}
$top_left_menu = '<div id="topmenu" class="btn-group btn-group text-center mt-3 pl-2 pr-2" role="group">'.$top_left_menu.'</div>';


$stream = ["First Stream", "Second Stream", "Snapshot", "Audio"];
?>
<style>
.box{
    max-width:1024px;
    font-family:verdana,sans-serif !important;
    font-size:11px !important;
    margin: 0px 0px 10px 0px;
    border: #222222 1px;
}

.box .box-body {margin:0px; padding:2px 0px 0px 0px}
.btn-white{
    background-color:#eee;
    width:160px;
}
/* body {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
} */
</style>

<body>
    <div id="wrapper" >
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <?=$top_left_menu?>
            <div class="tab-content mt-2">
                <div class="tab-pane active" id="tab-1" role="tabpanel">
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>Stream</h6></div>
                        <div id="streamSector">
                            <select id="transmission" class="form-control form-control-sm col-sm-12" >
                                <option value="first">First stream</option>
                                <option value="second">Second stream</option>
                                <option value="snapshot">Snapshot</option>
                            </select>
                            <div class="form-group form-inline mt-2 mb-0 mt-1 mb-1">
                                <label class="form-check">
                                    <input type="checkbox" id="videoStreamEnableCheckBox" class="form-check-input"/>
                                    <span class="form-check-label">Video</span>
                                </label>
                                <label class="form-check ml-3">
                                    <input type="checkbox" id="audioStreamEnableCheckBox" class="form-check-input"/>
                                    <span class="form-check-label">Audio</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>Size</h6></div>
                        <div id="sizeSector">
                            <select id="screen_size"  class="form-control form-control-sm col-sm-12" >
                                <option value="0" selected>Fit</option>
                                <option value="0.25">25%</option>
                                <option value="0.5">50%</option>
                                <option value="0.75">75%</option>
                                <option value="1">100%</option>
                                <option value="1.5">150%</option>
                            </select>
                        </div>
                    </div>
                    <div  id="trigAlarmContents" class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>Trigger-Alarm(DO)</h6></div>
                        <div id="triggerSector">
                            <select id="doChannel"  class="form-control form-control-sm col-sm-12">
                                <option value="0">Channel1</option>
                            </select>
                            <div class="form-group form-inline mt-2 mb-0">
                                <label class="form-check">
                                    <input type="radio" name="formMainTrigger" id="trig_on" value="on" class="form-check-input" />
                                    <span class="form-check-label">On</span>
                                </label>
                                <label class="form-check">
                                    <input type="radio" name="formMainTrigger" id="trig_off" value="off" class="form-check-input ml-3" />
                                    <span class="form-check-label">Off</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div  id="audioContents" class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>Audio</h6></div>
                        <div id="audioSector">
                            <label class="form-check">
                                <input type="checkbox" id="audioSpeaker" class="form-check-input" />
                                <span class="form-check-label">Speaker</span>
                            </label>
                            <input type="range" id="audioSpeakerVolumeSlider" class="slider col-md-12" />
                            <label class="form-check">
                                <input type="checkbox" id="audioMicrophone" class="form-check-input" />
                                <span class="form-check-label">Microphone</span>
                            </label>
                        </div>
                    </div>
                    <div id="recordContents" class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>Video Control</h6></div>
                        <div id="controlSector">
                            <button id="recording" class="btn btn-sm btn-outline-primary text-white">Record</button>
                            <button id="snapshot" class="btn btn-sm btn-outline-primary text-white">Snapshot</button>
                            <button id="pause" class="btn btn-sm btn-outline-primary text-white">Pause</button>
                            <button id="controlSetting" class="btn btn-sm btn-outline-primary text-white">Setting</button>
                        </div>
                    </div>
                </div>
              
                <div class="tab-pane" id="tab-2" role="tabpanel">
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>System</h6></div>
                        <div>
                            <span>CPU</span>:<label id="status_CpuUsed" class="ml-1 mr-1">90</label>%
                            <span>Memory</span>:<label id="status_MemUsed" class="ml-1 mr-1">98</label>%
                        </div>
                    </div>
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="slider-card-title"><h6>Time</h6></div>
                        <div>
                            <span>Uptime</span>:<label id="status_TimeUptime">-</label>
                        </div>
                    </div>
<?PHP for ($i=0; $i<3; $i++) { ?>
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6><?=$stream[$i]?></h6></div>
                        <div>
                            <span>Type</span>:<span id="status_streamType_<?=$i?>">-</span><br />
                            <span>Resolution</span>:<span id="status_streamResolution_<?=$i?>">-</span></br>
                            <span>Fps</span>:<span id="status_streamFps_<?=$i?>">-</span><br />
                            <span>Bitrate</span>:<span id="status_streamBitrate_<?=$i?>">-</span>
                        </div>
                    </div>
<?PHP  } ?>
                    <div class="sidebar-card ml-2 mr-2 mt-1 mb-1">
                        <div class="sidebar-card-title"><h6>RTSP Connect List</h6></div>
                        <div>
                            <span>Total</span>:<span id="status_ConnectNum">-</span>
                            <select size="6" id="formConnectList" class="form-control form-control-sm col-md-12">
                                <option>192.168.1.2</option>
                            </select>
                        </div>
                    </div>
                </div>
                

                <div class="tab-pane pl-1" id="tab-3" role="tabpanel">
                    <div class="ml-2 mt-5">
<?php
                        echo $PTZ_CONTROL_PAD;
?>
                    </div>

                </div>
            </div>
        </ul>
  
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow"><h3 class="ml-5">NiceHans</h3></nav>

                <div class="container-fluid">
                    <div class="tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab"><span class="text-primary">Option</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab"><span>Status</span></a></li>
                            <li class="nav-item"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab"><span>PTZ</span></a></li>
                        </ul>
                    </div>

                    <div id="screen" class="card col-xl-10 mt-3">
                        <div class="card-body  pl-0 pr-0 pt-2 pb-0">
							<canvas id="canvas" class="card-img-top"></canvas>
						</div>
                        <!-- <canvas height="600"></canvas> -->
                    </div>
                    <div id="screen_tools"></div>

                    


                    


                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
</body>
<?php
echo $footer;
?>
<script>
$(".slider").on("input", function () {
	xt = this.id.replace("slider","form");
 	$("#" + xt).val(this.value);
});
$("input[type=text]").on("change", function () {
	xt = this.id.replace("form", "slider");
 	$("#" + xt).val(this.value);
});


var canvas = document.getElementById("canvas");
canvas.width=720;
canvas.height = 360;
const ctx = canvas.getContext('2d');
var img =  new Image();

meta_url = "../uapi-cgi/metadata.cgi";
let n=0;

function drawbox(ctx, x0, y0, w, h){
    ctx.beginPath();
    ctx.lineWidth = "1";
    // ctx.strokeStyle = "red";
    ctx.rect(x0, y0, w, h);
    ctx.stroke();
}

function drawdot(ctx,x,y){
    ctx.beginPath();
    ctx.arc(x, y, 2, 0, 2 * Math.PI, false);
    // ctx.fillStyle = 'red';
    ctx.fill();
    ctx.lineWidth = 0;
    // ctx.strokeStyle = '#003300';
    ctx.stroke();    
}




function proc_metadata(response){
    let data = response['data'];
    
    ctx.fillStyle = 'blue';
    ctx.lineWidth = "1";
    ctx.fillText(response['datetime'], 10 ,10);
    
    data.forEach(function(item) {
        // console.log(item);
        x0 = canvas.width  * item['pos_lt'][0] / 0xFFFF;
        y0 = canvas.height * item['pos_lt'][1] / 0xFFFF;
        // y0 = canvas.height * item['pos_lt'][1] / 0xFFFF + ((320-240) * item['pos_lt'][1]/0xFFFF)*3/2;
        w = canvas.width  * item['width'] / 0xFFFF;
        h = canvas.height  * item['height'] / 0xFFFF;
        x_c = canvas.width  * item['pos_cen'][0] / 0xFFFF;
        y_c = canvas.height  * item['pos_cen'][1] / 0xFFFF;
        // drawbox(ctx, x0, y0, w, h);
        // drawdot(ctx,x_c, y_c );
        
        ctx.strokeStyle = "red";
        ctx.fillText(item['cat_item'] + " (" + item['score'] + ")", x0 ,y0-4);

        ctx.beginPath();
        ctx.rect(x0, y0, w, h);
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(x_c, y_c, 1, 0, 2 * Math.PI, false);
        ctx.stroke(); 
        
    });
}

img.src="../uapi-cgi/snapshot.cgi?n="+n;
img.addEventListener("load",()=>{
    ctx.drawImage(img, 0,0,canvas.width, canvas.height);
}); 

function render() {

    n++;
    img.src="../uapi-cgi/snapshot.cgi?n="+n;
 
    // img.addEventListener("load",()=>{
        // ctx.drawImage(img, 0,0,canvas.width, canvas.height);
    // }); 
    
    $.getJSON(meta_url, function(response) {
	// 	console.log(response);
        proc_metadata(response);
        // img.src="../uapi-cgi/snapshot.cgi?n="+n;
        // proc_metadata(response);

	});


    if (n>1000)  {
        n=0;
    }
    // cnsole.log(n);
}

function getMeta(){
    $.getJSON(meta_url, function(response) {
        // 	console.log(response);
            proc_metadata(response);

	});
}
// render();


setInterval(() => {
    render();
    // getMeta();
}, 100);

// ctx.drawImage(img, 0,0,canvas.width, canvas.height);
// function render(i){
// 	// img.src="../images/demo_screen.jpg";
//     img.src="../uapi-cgi/snapshot.cgi?n="+ i;
//     img.addEventListener("load",()=>{
//         ctx.drawImage(img, 0,0,720,360);
//     });  
// 	// ctx.drawImage(img, 0,0,720,360);
// }
// function main() {
// 	console.log(i);
//     i++;
//     render(i);
// 	requestAnimationFrame(main);
// }

// main();

</script>

<?php
exit();
?>

