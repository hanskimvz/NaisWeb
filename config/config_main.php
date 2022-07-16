<!DOCTYPE html>
<!-- origin: https://startbootstrap.com/previews/sb-admin-2 -->
<html lang="en">
<?php
include ("../inc/common.php");
echo $header;
$json = new Services_JSON();

$json_str = file_get_contents($_SERVER['DOCUMENT_ROOT']."/inc/menu.json");

$objmenu = $json->decode($json_str);

$leftMenu = '<li class="nav-item">';
foreach(($objmenu->config) as $grp => $obj){
	if (!isset($msg[$grp])) {
		$msg[$grp] = $grp;
	}
	$leftMenu .= '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#'.$grp.'" aria-expanded="false" aria-controls="'.$grp.'"><span>'.$msg[$grp].'</span></a>';
	$leftMenu .= '<div id="'.$grp.'" class="collapse" data-parent="#accordionSidebar"><div class="bg-white py-2 collapse-inner rounded">';

    foreach($obj as $page => $param){
        if ($param->lang_key == 'n'){
            continue;
        }
		if (!isset($msg[$param->lang_key])) {
			$msg[$param->lang_key] = $param->lang_key;
		}		
		$leftMenu .= '<a id="'.($param->lang_key).'" class="collapse-item" href="'.$param->href.'"  target="contentFrame">'.$msg[$param->lang_key].'</a>';
	}
	$leftMenu .= '</div></div>';
}
$leftMenu .= '</li>';

$href = 'users.html';

// print_r($_SERVER);

?>
<style>
.btn-white{
    background-color:#eee;
    width:160px;
}
</style>
<body>
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <div id="topmenu" class="btn-group btn-group text-center mt-3 pl-2 pr-2" role="group">
            <button class="btn btn-white" onClick="location.href=('/')">Live</button>    
            <button class="btn btn-white" onClick="location.href=('/config/')" disabled>Setup</button>
            <button class="btn btn-white" onClick="location.href=('/storage/')">Search</button>
        </div>
        <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
            <div class="sidebar-brand-text mx-3">LIVE</div>
        </a>             -->
            <?=$leftMenu?>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-2 static-top shadow"><h3 class="ml-5">NiceHans</h3></nav>

                <div class="container-fluid">
                    <iframe src="<?=$href?>" name="contentFrame" width="100%" height="1800px" scrolling="no" marginheight="1" marginwidth="2" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
</body>
<?php
// echo $footer
?>
<script src="/js/jquery-3.6.0.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script>

$("#basic").addClass("show");
$("#users").addClass("active");

$(".collapse-item").on("click", function () {
	console.log(this);
	$(".collapse-item").removeClass("active");
    $(this).addClass("active");
});

</script>
</html>