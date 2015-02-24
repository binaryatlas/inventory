<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Querybase extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->authldap->is_authenticated()) {
		
		}
		else {
			$this->load->view('auth/login_form');
		}
	}
	function get_inventory_dash(){
		if($this->authldap->is_authenticated()) {
		$html = "";
			
		}
		else {
			$this->load->view('auth/login_form');
		}
	}
	function add_inventory(){
		if($this->authldap->is_authenticated()) {
			$html = "<form id='insertform' name='insertform'>";
			$html .= "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Building</label>
                                                <select class=\"form-control\" onchange='load_rooms();' id='buildings'><option></option>";								
			$query = $this->db->query("SELECT * FROM buildings ORDER BY name ASC");
			foreach ($query->result() as $row)
			{
			   $html .= "<option value='".$row->buildingID."'>" . $row->name . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Select Building to populate rooms</p></div>";
			$html .= "<div class='form-group' id='budrooms' name='budrooms'></div>";
			$html .= "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Device Type</label>
                                                <select class=\"form-control\" id='devicetype' name='devicetype'>";
		$query = $this->db->query("SELECT * FROM type");
		foreach ($query->result() as $row)
			{
			   $html .= "<option value='$row->typeID'>" . $row->name . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Select the type of device such as a projector or speaker</p></div>";
			$html .= "<div class=\"form-group\">
                                                <label>Make</label>
                                                <input class=\"form-control\" id='make' name='make'>
                                                <p class=\"help-block\">Put Brand Information Here</p>
                                            </div><div class=\"form-group\">
                                                <label>Model</label>
                                                <input class=\"form-control\" id='model' name='model'>
                                                <p class=\"help-block\">Put Brand Information Here</p>
                                            </div><div class='form-group'>
                                                <label>Date Purchased:</label>
                                                <input id='datepickerPur'name='datepickerPur' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Date Item Was Purchased</p>
                                            </div><div class='form-group'>
                                                <label>Date Installed:</label>
                                                <input id='datepickerIns' name='datepickerIns' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Date Item Was Installed</p>
                                            </div>";
			$html .= "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Lamp Model</label>
                                                <select class=\"form-control\" id='lampid' name='lampid'>";								
			$query = $this->db->query("SELECT * FROM lamps");
			foreach ($query->result() as $row)
			{
			   $html .= "<option value='$row->lampID'>" . $row->model . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Select the type of bulb</p></div>";
			
			$html .= "<div class='form-group'>
                                                <label>Serial</label>
                                                <input id='serial' name='serial' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Serial Number or Unique Identifier</p>
                                            </div>";
			$html .= "<div class='checkbox'>
                                                    <label>
                                                        <input value='1' type='checkbox' id='motorized' name='motorized'>Motorized
                                                    </label>
                                                </div><div class='form-group'>
                                                <label>Width</label>
                                                <input id='width' name='width' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Mostly used for Screens.</p>
                                            </div><div class='form-group'>
                                                <label>Height:</label>
                                                <input id='height' name='height' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Mostly used for screens</p>
                                            </div><div class='form-group'>
                                                <label>Service Tag:</label>
                                                <input id='servicetag' name='servicetag' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Mostly used on Computers</p>
                                            </div><div class='form-group'>
                                                <label>Green Tag:</label>
                                                <input id='greentag' name='greentag' type='text' class=\"form-control\"/>
                                                <p class='help-block'>Tech Inventory Tag - Its Green</p>
                                            </div>";
			
			//close html here
			$html .= "</div></div></form><button type='button' class='btn btn-primary btn-lg' onclick='additem();'>Add Item</button>";
		echo $html;	
		}
		else {
			$this->load->view('auth/login_form');
		}
	}

function build_rooms($roomid=0,$bid=0){
	$sql = "SELECT * from rooms WHERE buildingID = ?";
	if($roomid == 0){$bid = $this->input->post('building');}
	$query = $this->db->query($sql, array($bid));
	//echo $this->input->post('building');
	$html = "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Rooms</label>
                                                <select class=\"form-control\" id='buildingsroom' name='buildingsroom'>";
                                                $seltext = "";
	foreach ($query->result() as $row)
{
	if($roomid == $row->roomID){$seltext = "selected";}else{$seltext = "";};
	$html .= "<option value='".$row->roomID."' $seltext>" . $row->name . "</option>";   
}
$html .= "</select><p class=\"help-block\">Select Room</p></div></div></div>";
if($roomid == 0){echo $html;}else{return $html;}

}

function additem(){
	$data = array('typeID' => $this->input->post('devicetype'), 'make' => $this->input->post('make'), 'model' => $this->input->post('model'),'purchaseDate' => $this->input->post('datepickerPur'),'installDate' => $this->input->post('datepickerIns'),'greenTag' => $this->input->post('greentag'),'lampModelID' => $this->input->post('lampid'),'serial' => $this->input->post('serial'),'motorized' => $this->input->post('devicetype'),'width' => $this->input->post('width'),'height' => $this->input->post('height'),'serviceTag' => $this->input->post('servicetag'),'roomID' => $this->input->post('buildingsroom'));
	$str = $this->db->insert_string('inventory', $data);
	//echo $str;
	$this->db->query($str);
	
	if($this->db->affected_rows() == 1){
	unset ($_POST);
		echo "1:Item Inserted";
	}else{
		echo "0:$str";
	}
	//echo $this->input->post('devicetype');
}

function draw_bdforms(){
	$buildings = "";
	$query = $this->db->query("SELECT * FROM buildings");
			foreach ($query->result() as $row)
			{
			   $buildings .= "<button type='button' class='btn btn-info' onclick='roomenable(\"$row->buildingID\",\"$row->name\");'>$row->name</button>";
			}
	//$buildingout = rtrim($buildings, ", ");
	$html = "<div class='row' id='bildroom'><form id='buildingadd' name='buildingadd'>
                    <div class='col-lg-4'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Add Building
                            </div>
                            <div class='panel-body'>
                                <p><div class='form-group'>
                                                <label>Building Name</label>
                                                <input class='form-control' id='buildingname' name='buildingname'>
                                                <p class='help-block'>Check below to make sure this is a new building</p>
                                            </div>
				</p>
				<button type='button' class='btn btn-primary' onclick='addbuild();'>Add</button>
                            </div>
                            <div class='panel-footer' id='buildingfoot' name='buildingfoot'>
                                Current Buildings<p>$buildings</p>
                            </div>
                        </div>
                    </div>
		    </form>
                    
                    <!-- /.col-lg-4 -->
                    <!-- /.col-lg-4 -->
		    <form id='roominsert' name='roominsert'>
		    <input type=\"hidden\" name=\"buildingid\" value=\"\" id='buildingid'>
                    <div class='col-lg-4'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Add Room
                            </div>
                            <div class='panel-body'>
                                <p>To add a room please click a building under current buildings to the left.</p>
				<p id='Rooms'><label>Room Name/Number</label>
                                                <input class='form-control' id='roomname' name='roomname' disabled></p>
						<div class='checkbox'>
                                                    <label>
                                                        <input type='checkbox' value='1' id='tegenabled' name='tegenabled' disabled>Tegrity
                                                    </label>
                                                </div>
						<div class='checkbox'>
                                                    <label>
                                                        <input type='checkbox' value='1' id='poleenabled' name='poleenabled' disabled>Polevault
                                                    </label>
                                                </div>
						<button type='button' class='btn btn-primary disabled' onclick='addroom();' id='rmaddbtn'>Add</button>
                            </div>
                            <div class='panel-footer' id='roomaddfoot'>
                                
                            </div>
                        </div>
                    </div>
		    </form>
                </div>";
//$html = "hello";
		echo $html;
}

function addbuild(){
	$data = array('name' => $this->input->post('buildingname'));
	$str = $this->db->insert_string('buildings', $data);
	//echo $str;
	$this->db->query($str);
	
	if($this->db->affected_rows() == 1){
		echo "1:Item Inserted";
	}else{
		echo "0:$str";
	}
}

function getroomcsv(){
	$html = "";
	$sql = "SELECT * FROM rooms WHERE buildingID = ?";
	$query = $this->db->query($sql, array($this->input->post('building')));
			foreach ($query->result() as $row)
			{
			   $html .= $row->name . ", ";
			}
			$roomout = rtrim($html, ", ");
			echo $roomout;
}

function addroom(){
	
	$data = array('name' => $this->input->post('roomname'), 'tegrity' => $this->input->post('tegenabled'), 'buildingID' => $this->input->post('buildingid'),'polev' => $this->input->post('poleenabled'));
	$str = $this->db->insert_string('rooms', $data);
	//echo $str;
	$this->db->query($str);
	
	if($this->db->affected_rows() == 1){
		echo "1:Item Inserted";
	}else{
		echo "0:$str";
	}
	//echo $this->input->post('devicetype');

}

function draw_lamp(){
	$lamps = "";
	$query = $this->db->query("SELECT * FROM lamps");
			foreach ($query->result() as $row)
			{
			   $lamps .= "<button type='button' class='btn btn-info' onclick='lampedit(\"$row->lampID\",\"$row->model\");'>$row->model</button>";
			}
	$html = "<div class='row' id='bildroom'><form id='lampadd' name='lampadd'>
                    <div class='col-lg-4'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Add Lamp
                            </div>
                            <div class='panel-body'>
                                <p><div class='form-group'>
                                                <label>Lamp Model</label>
                                                <input class='form-control' id='lampmodelname' name='lampmodelname'>
                                                <p class='help-block'>Check below to make sure this is a new lamp</p>
                                            </div>
				</p>
				<button type='button' class='btn btn-primary' onclick='addnewlamp();'>Add</button>
                            </div>
                            <div class='panel-footer' id='buildingfoot' name='buildingfoot'>
                                Current Lamps<p>$lamps</p>
                            </div>
                        </div>
                    </div>
		    </form>
                    
                    <!-- /.col-lg-4 -->
                    <!-- /.col-lg-4 -->
		    <form id='lampupdate' name='lampupdate'>
		    <input type=\"hidden\" name=\"lampid\" value=\"\" id='lampid'>
                    <div class='col-lg-4'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Edit Lamp
                            </div>
                            <div class='panel-body'>
                                <p>To edit a lamp please click a lamp under current lamps to the left.</p>
				<p id='lamps'><label>Lamp Model</label>
                                                <input class='form-control' id='lampmodelupname' name='lampmodelupname' disabled>
						<label>Quantity</label>
						<input class='form-control' id='lampqt' name='lampqt' disabled>
						</p>
						<button type='button' class='btn btn-primary disabled' onclick='updatelamp();' id='lmpupbtn'>Update</button>
                            </div>
                            <div class='panel-footer' id='lampaddfoot'>
                            </div>
                        </div>
                    </div>
		    </form>
                </div>";
//$html = "hello";
		echo $html;
}

function addlamp(){
	$data = array('model' => $this->input->post('lampmodelname'));
	$str = $this->db->insert_string('lamps', $data);
	//echo $str;
	$this->db->query($str);
	
	if($this->db->affected_rows() == 1){
		echo "1:Item Inserted";
	}else{
		echo "0:$str";
	}
	//echo $this->input->post('devicetype');
}

function getlampqty(){
	$sql = "SELECT * FROM lamps WHERE lampID = ?";
	$query = $this->db->query($sql, array($this->input->post('lampid')));
			foreach ($query->result() as $row)
			{
			   echo $row->quantity;
			}
			
}

function updatelamp(){
	$data = array('model' => $this->input->post('lampmodelupname'), 'quantity' => $this->input->post('lampqt'));

$where = "lampID = " . $this->input->post('lampid'); 
$str = $this->db->update_string('lamps', $data, $where);
$this->db->query($str);
if($this->db->affected_rows() == 1){
		echo "1:Item Updated";
	}else{
		echo "0:$str";
	}
}

function drawinv(){
	$html = "";
	$query = $this->db->query("SELECT * FROM rooms");
$roomarray = array();
	foreach ($query->result() as $roomrow)
	{
	   $roomarray[$roomrow->roomID] = $roomrow->name;
	}
	$html .= "<div class='row'>
                    <div class='col-lg-12'>
                        <h3 class='page-header'>Tables</h3>
                    </div>
                    <!-- /.col-lg-12 -->
                </div><div class='row'>
                    <div class='col-lg-12'>
                        <div class='panel panel-default'>
                            <div class='panel-heading'>
                                Current Inventory
                            </div>
                            <!-- /.panel-heading -->
                            <div class='panel-body'>
                                <div class='table-responsive'>
                                <table class='table table-striped table-bordered table-hover dataTable' id='dataTables-example' aria-describedby='dataTables-example_info'>";
                                    $html .= "<thead>
                                            <tr role='row'>";

$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'></th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Type</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Make</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Model</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Green Tag</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Building</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Room</th>";
$html .= "<th class='sorting_asc' tabindex='0' aria-controls='dataTables-example' rowspan='1' colspan='1' aria-sort='ascending' aria-label='Rendering engine: activate to sort column ascending' style='width: 165px;'>Service Tag</th>";

$html .= "</tr></thead>";
$html .= "<tbody>";
$typeq = $this->db->query("SELECT * FROM type");
foreach ($typeq->result() as $row){
	$inv_type[$row->typeID] = $row->name;
}
$query = $this->db->query("SELECT id,typeID,make,model,roomID,serviceTag,greenTag FROM inventory");


foreach ($query->result() as $row)
{
$query2 = $this->db->query("SELECT buildingID from rooms where roomID = $row->roomID");

foreach ($query2->result() as $budselect){
	$query3 = $this->db->query("SELECT name from buildings where buildingID = " .$budselect->buildingID);
	foreach($query3->result() as $namerow){
		$budselectNAME = $namerow->name;
	}
	
}
$roomname = $roomarray[$row->roomID];
   $html .= "<tr class='gradeA odd'>
                                                <td class='sorting_1'><button class='btn btn-primary btn-lg' data-toggle='modal' data-target='#myModal' onClick='load_inv($row->id)'>
                                    More Information
                                </button></td>
                                                <td class=' '>".$inv_type[$row->typeID]."</td>
                                                <td class=' '>$row->make</td>
                                                <td class='center '>$row->model</td>
                                                <td class='center '>$row->greenTag</td>
                                                <td class='center '>$budselectNAME</td>
                                                <td class='center '>$roomname</td>
                                                <td class='center '>$row->serviceTag</td>
                                            </tr>";
}
$html .= "</tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                                
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>";
echo $html;                                          
}

function fillmodalinv(){
	if($this->authldap->is_authenticated()) {
	$html = "";
		$productid = $this->input->post("id");
		$query = $this->db->query("SELECT * FROM inventory WHERE id = $productid");
		foreach ($query->result() as $row)
		{
			$html = "<form id='updateinv' name='updateinv'>";
			$html .= "<input type='hidden' name='deviceid' id='deviceid' value='$productid'>";
			$html .= "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Building</label>
                                                <select class=\"form-control\" onchange='load_roomsinv();' id='buildings'><option></option>";								
			$query2 = $this->db->query("SELECT * FROM buildings ORDER BY name ASC");
			$seltext = "";
			foreach ($query2->result() as $buildingsrow)
			{
				$query3 = $this->db->query("SELECT buildingID FROM rooms WHERE roomID = ".$row->roomID);
				foreach ($query3->result() as $roomresult){
					if($roomresult->buildingID == $buildingsrow->buildingID){$seltext = "selected";}else{$seltext = "";}
				}			
			   $html .= "<option value='".$buildingsrow->buildingID."' $seltext>" . $buildingsrow->name . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Change Building Here</p></div>";
			
			//room numbers
			$html .= $this->build_rooms($row->roomID,$roomresult->buildingID);
			$html .= "<div class=\"form-group\">
                                                <label>Device Type</label>
                                                <select class=\"form-control\" id='devicetype' name='devicetype'>";
		$query4 = $this->db->query("SELECT * FROM type");
		$typesel = "";
		foreach ($query4->result() as $typerow)
			{
				if($row->typeID == $typerow->typeID){$typesel = "selected";}else{$typesel = "";}
			   $html .= "<option value='$typerow->typeID' $typesel>" . $typerow->name . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Select the type of device such as a projector or speaker</p></div>";
			$html .= "<div class=\"form-group\">
                                                <label>Make</label>
                                                <input class=\"form-control\" id='make' name='make' value='$row->make'>
                                                <p class=\"help-block\">Put Brand Information Here</p>
                                            </div><div class=\"form-group\">
                                                <label>Model</label>
                                                <input class=\"form-control\" id='model' name='model' value='$row->model'>
                                                <p class=\"help-block\">Put Brand Information Here</p>
                                            </div><div class='form-group'>
                                                <label>Date Purchased:</label>
                                                <input id='datepickerPur'name='datepickerPur' type='text' class=\"form-control\" value='$row->purchaseDate'/>
                                                <p class='help-block'>Date Item Was Purchased</p>
                                            </div><div class='form-group'>
                                                <label>Date Installed:</label>
                                                <input id='datepickerIns' name='datepickerIns' type='text' class=\"form-control\" value='$row->installDate'/>
                                                <p class='help-block'>Date Item Was Installed</p>
                                            </div>";
                                            
            //lamp
            $html .= "<div class=\"row\"><div class=\"col-lg-8\"><div class=\"form-group\">
                                                <label>Lamp Model</label>
                                                <select class=\"form-control\" id='lampid' name='lampid'>";								
			$query = $this->db->query("SELECT * FROM lamps");
			$seltext = "";
			foreach ($query->result() as $lamprow)
			{
				if($lamprow->lampID == $row->lampModelID){$seltext = "selected";}else{$seltext = "";}
			   $html .= "<option value='$lamprow->lampID' $seltext>" . $lamprow->model . "</option>";
			}
			$html .= "</select><p class=\"help-block\">Select the type of bulb</p></div>";
			$html .= "<div class='form-group'>
                                                <label>Serial</label>
                                                <input id='serial' name='serial' type='text' class=\"form-control\" value='$row->serial'/>
                                                <p class='help-block'>Serial Number or Unique Identifier</p>
                                            </div>";
                                            
            //motorized bit 0 or 1
            $checked = "";
            if($row->motorized == 1){$checked = "checked";}else{$checked = "";}
            $html .= "<div class='checkbox'>
                                                    <label>
                                                        <input value='1' type='checkbox' id='motorized' name='motorized' $checked>Motorized
                                                    </label>
                                                </div>";
                                                
            $html .= "<div class='form-group'>
                                                <label>Width</label>
                                                <input id='width' name='width' type='text' class='form-control' value='$row->width'>
                                                <p class='help-block'>Mostly used for Screens.</p>
                                            </div>
                                            <div class='form-group'>
                                                <label>Height:</label>
                                                <input id='height' name='height' type='text' class='form-control' value='$row->height'>
                                                <p class='help-block'>Mostly used for screens</p>
                                            </div>
                                            <div class='form-group'>
                                                <label>Service Tag:</label>
                                                <input id='servicetag' name='servicetag' type='text' class='form-control' value='$row->serviceTag'>
                                                <p class='help-block'>Mostly used on Computers</p>
                                            </div>
                                            <div class='form-group'>
                                                <label>Green Tag:</label>
                                                <input id='greentag' name='greentag' type='text' class='form-control' value='$row->greenTag'>
                                                <p class='help-block'>Tech Inventory Tag - Its Green</p>
                                            </div></form>";
		}
		echo $html;
		}
		else {
			$this->load->view('auth/login_form');
		}
}

function update_item(){

if($this->authldap->is_authenticated()) {
	$data = array('typeID' => $this->input->post('devicetype'), 'make' => $this->input->post('make'), 'model' => $this->input->post('model'),'purchaseDate' => $this->input->post('datepickerPur'),'installDate' => $this->input->post('datepickerIns'),'greenTag' => $this->input->post('greentag'),'lampModelID' => $this->input->post('lampid'),'serial' => $this->input->post('serial'),'motorized' => $this->input->post('devicetype'),'width' => $this->input->post('width'),'height' => $this->input->post('height'),'serviceTag' => $this->input->post('servicetag'),'roomID' => $this->input->post('buildingsroom'));
	$where = "id = ".$this->input->post('deviceid');
	$str = $this->db->update_string('inventory', $data,$where);
	//echo $str;
	$this->db->query($str);
	
	if($this->db->affected_rows() == 1){
		echo "1:Item Updated";
	}else{
		echo "0:$str";
	}
	//echo $this->input->post('devicetype');
	}else{$this->load->view('auth/login_form');}
}

function delete_item(){
if($this->authldap->is_authenticated()) {
	$this->db->delete('inventory', array('id' => $this->input->post('deviceid'))); 
	if($this->db->affected_rows() == 1){
		echo "1:Item Deleted";
	}else{
		echo "0:$str";
	}
	}else{$this->load->view('auth/login_form');}

// Produces:
// DELETE FROM mytable 
// WHERE id = $id
}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */