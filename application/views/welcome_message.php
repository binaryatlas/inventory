<!DOCTYPE html>
<html>
<head>

        <title>DMS - Inventory Administration</title>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">

        <meta name="keywords" content="" />

        <!-- Core CSS - Include with every page -->
        <link href="http://www.atu.edu/ois/dms/inventory/css/bootstrap.css" rel="stylesheet">
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">

        <!-- Page-Level Plugin CSS - Dashboard -->
        <link href="http://www.atu.edu/ois/dms/inventory/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
        <link href="http://www.atu.edu/ois/dms/inventory/css/plugins/timeline/timeline.css" rel="stylesheet">
        <!-- Mint Admin CSS - Include with every page -->
        <link href="http://www.atu.edu/ois/dms/inventory/css/mint-admin.css" rel="stylesheet">
 <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
 <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="http://www.atu.edu/ois/dms/inventory/js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="http://www.atu.edu/ois/dms/inventory/js/plugins/dataTables/jquery.dataTables.js"></script>
<link href="http://www.atu.edu/ois/dms/inventory/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
<script>
function load_forms()
{
	$.get( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/add_inventory", function( data ) {
$( "#page-wrapper" ).html( data );

$( "#datepickerPur" ).datepicker();
$( "#datepickerIns" ).datepicker();
//alert( "Load was performed." );
});
}
function load_roomforms()
{
	$.get( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/add_rooms", function( data ) {
$( "#page-wrapper" ).html( data );
//alert( "Load was performed." );
});
}
function load_rooms(){
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/build_rooms", { building: $( "#buildings" ).val()})
.done(function( data ) {
//alert( "Data Loaded: " + data );
$( "#budrooms" ).html( data );

});
}

function additem(){
	//alert( "started");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/additem", $( "form" ).serialize() )
  .done(function( data ) {
	$('html, body').animate({ scrollTop: 0 }, 'slow');
	var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		$( "#insertform" )[0].reset();
		
		setTimeout("$('#notifications').remove()",2000);
   
	} else {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
	
  });
	
}

function load_formBuildings()
{
	$.get( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/draw_bdforms", function( data ) {
$( "#page-wrapper" ).html( data );
//alert( "Load was performed." );
});
}

function addbuild(){
	//alert( "started");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/addbuild", $( "#buildingadd" ).serialize() )
  .done(function( data ) {
	//$('html, body').animate({ scrollTop: 0 }, 'slow');
	var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		$("#buildingname").val("");
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();load_formBuildings();",2000);
	} else {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
	
  });
	
}

function roomenable(bulid,bulname){
	$("#rmaddbtn").removeClass("disabled");
	$("#tegenabled").prop('disabled', false);
	$("#poleenabled").prop('disabled', false);
	$("#roomname").prop('disabled', false);
	$("#roomaddfoot").html("Inserting Room for "+bulname+"<p>Current Rooms</p>");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/getroomcsv", { building: bulid})
.done(function( data ) {
//alert( "Data Loaded: " + data );
$("#roomaddfoot").append("<p>"+data+"</p>");
$("#buildingid").val(bulid);

});
}

function addroom(){
	//alert( "started");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/addroom", $( "#roominsert" ).serialize() )
  .done(function( data ) {
	//$('html, body').animate({ scrollTop: 0 }, 'slow');
	var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		$("#buildingname").val("");
		$("#roomname").val("");
		$('#tegenabled').prop('checked', false);
		$('#poleenabled').prop('checked', false);
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();load_formBuildings();",2000);
	} else {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
	
  });
}

function load_formLamps()
{
	$.get( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/draw_lamp", function( data ) {
$( "#page-wrapper" ).html( data );
//alert( "Load was performed." );
});
}

function addnewlamp() {
	//alert( "started");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/addlamp", $( "#lampadd" ).serialize() )
  .done(function( data ) {
	//$('html, body').animate({ scrollTop: 0 }, 'slow');
	var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		$("#lampmodelname").val("");
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();load_formLamps();",2000);
	} else {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
	
  });
}

function lampedit(lmpid,lmpname){
	$("#lmpupbtn").removeClass("disabled");
	$("#lampmodelupname").prop('disabled', false);
	$("#lampmodelupname").val(lmpname);
	$("#lampqt").prop('disabled', false);
	$("#lampaddfoot").html("Updating "+lmpname);
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/getlampqty", { lampid: lmpid})
.done(function( data ) {
//alert( "Data Loaded: " + data );
$("#lampqt").val(data);
$("#lampid").val(lmpid);

});
}

function updatelamp(){
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/updatelamp", $( "#lampupdate" ).serialize())
.done(function( data ) {
//alert( "Data Loaded: " + data );
var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		$("#lampmodelname").val("");
		$("#lampqt").val("");
$("#lampid").val("");
$("#lmpupbtn").addClass("disabled");
$("#lampmodelupname").prop('disabled', true);
$("#lampqt").prop('disabled', true);
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();load_formLamps();",2000);
	} else {
		$( "#page-wrapper" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
});
}
<?php 
$table = str_replace('"',"'",$this->table->generate()); 
$output = str_replace(array("\r\n", "\r"), "\n", $table);
$lines = explode("\n", $output);
$new_lines = array();

foreach ($lines as $i => $line) {
    if(!empty($line))
        $new_lines[] = trim($line);
}
$finaltable = implode($new_lines);
?>
function load_inventory(){
	$.get( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/drawinv", function( data ) {
$( "#page-wrapper" ).html( data );
$("#dataTables-example").dataTable();
//alert( "Load was performed." );
});
	
}

function load_inv(iivd){
$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/fillmodalinv", { id: iivd})
.done(function( data ) {
//alert( "Data Loaded: " + data );
$( "#modal-body" ).html( data );

});
}

function update_inv(){
//alert("got here");
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/update_item", $( "#updateinv" ).serialize())
.done(function( data ) {
//alert( "Data Loaded: " + data );
var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#modal-footer" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();",2000);
	} else {
		$( "#modal-footer" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
});
}

function delete_inv(){
	$.post( "http://www.atu.edu/ois/dms/inventory/index.php/querybase/delete_item", $( "#updateinv" ).serialize())
.done(function( data ) {
//alert( "Data Loaded: " + data );
var insertreturn = data.split(':');
	if (insertreturn[0] == 1) {
		$( "#modal-footer" ).prepend( "<div class='alert alert-success' id='notifications'>"+insertreturn[1]+"</div>" );
		
    //alert( "Data Loaded: " + data );
    setTimeout("$('#notifications').remove();",2000);
	} else {
		$( "#modal-footer" ).prepend( "<div class='alert alert-danger alert-dismissable' id='notifications' >"+insertreturn[1]+"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button></div>" );
		
	}
});
}
</script>
    </head>

    <body>

        <div id="wrapper">

            <nav class="navbar navbar-default navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img class="brand-logo" src="http://www.atu.edu/_resources/images/atu-logo.png" alt=""/>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    
                    <!-- /.dropdown -->
                    
                    <!-- /.dropdown -->
                    
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user  fa-2x fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="index.php/auth/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

            </nav>
            <!-- /.navbar-static-top -->

            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <div class="user-info-wrapper">	
                                <div class="user-info-profile-image">
                                    
                                </div>
                                <div class="user-info">
                                    <div class="user-welcome">Welcome</div>
                                    <div class="username"><?php echo $this->session->userdata('username'); ?></div>
                                    <div class="status">Status <span class="status-now"><i class="fa fa-circle text-emerald fa"></i> Online</span> </div>
                                </div>
                            </div>
                        </li>
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="http://www.atu.edu/ois/dms/inventory/"><i class="fa fa-dashboard fa-fw fa-3x"></i> Dashboard</a>
                        </li>
                        
                        
                        <li>
                            <a href="tables.html"><i class="fa fa-th fa-fw fa-3x"></i> Tables<span class="fa arrow"></span></a><ul class="nav nav-second-level">
                                <li>
                                    <a href="#" onclick="load_inventory();">View Inventory</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw fa-3x"></i> Forms<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#" onclick="load_forms();">Add Inventory</a>
                                </li>
				<li>
				<a href="#" onclick="load_formBuildings();">Add Buildings/Rooms</a>
				</li>
				<li>
				<a href="#" onclick="load_formLamps();">Add Lamps</a>
				</li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </nav>
            <!-- /.navbar-static-side -->

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header text-asbestos">Dashboard</h3>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-bar-chart-o fa-fw"></i> Number Of Items In Inventory
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Another action</a>
                                            </li>
                                            <li><a href="#">Something else here</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="morris-dashboard-chart"></div>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body asbestos">
                                <i class="fa fa-video-camera fa-3x"></i>
				
                                <h3><?php echo $this->db->count_all("projector_count");?></h3>
                            </div>
                            <div class="panel-footer">
                                <span class="panel-eyecandy-title">
                                    Projector Count
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-xs-6 col-md-3 -->
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body theme-color">
                                <i class="fa fa-square-o fa-3x"></i>
                                <h3><?php echo $this->db->count_all("smartboard_count");?></h3>
                            </div>
                            <div class="panel-footer">
                                <span class="panel-eyecandy-title">
                                    Smartboards
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-xs-6 col-md-3 -->
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body asbestos">
                                <i class="fa fa-film fa-3x"></i>
                                <h3><?php echo $this->db->count_all("tv_count");?> </h3>
                            </div>
                            <div class="panel-footer">
                                <span class="panel-eyecandy-title">
                                    TVs
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-xs-6 col-md-3 -->
                    <div class="col-xs-6 col-md-3">
                        <div class="panel panel-primary text-center panel-eyecandy">
                            <div class="panel-body theme-color">
                                <i class="fa fa-keyboard-o fa-3x"></i>
                                <h3><?php echo $this->db->count_all("computer_count");?> </h3>
                            </div>
                            <div class="panel-footer">
                                <span class="panel-eyecandy-title">
                                    Computers
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-xs-6 col-md-3 -->
                </div>


                <!-- /.row -->
                
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Item Details</h4>
                                            </div>
                                            <div class="modal-body" id="modal-body" name="modal-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                            <div class="modal-footer" id="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="update_inv()">Save changes</button><button type="button" class="btn btn-danger" onclick="delete_inv()">Delete</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
        <!-- Core Scripts - Include with every page -->
       
        <script src="http://www.atu.edu/ois/dms/inventory/js/bootstrap.min.js"></script>
        <script src="http://www.atu.edu/ois/dms/inventory/js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- Page-Level Plugin Scripts - Dashboard -->
        <!--<script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
        <script src="js/plugins/morris/morris.js"></script>-->

        <!-- Mint Admin Scripts - Include with every page -->
        <script src="http://www.atu.edu/ois/dms/inventory/js/mint-admin.js"></script>

        <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
        <script src="http://www.atu.edu/ois/dms/inventory/js/demo/dashboard-demo.js"></script>

    </body>
</html>