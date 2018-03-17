<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php 

	if(isset($_POST['Submit'])){
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$addr_line1 = $_POST['address_line1'];
		$addr_line2 = $_POST['address_line2'];
		$addr_line3 = $_POST['address_line3'];
		$home_phone = $_POST['home_phone'];
		$mobile_phone = $_POST['mobile_phone'];
		$nic = $_POST['nic'];
		$email = $_POST['email'];
		$tax_number = $_POST['tax_number'];
		$deed_number = $_POST['deed_number'];
		$current = $_POST['current'];
		$purpose = $_POST['purpose'];
		$meter_ID = $_POST['meter_ID'];
		$is_delete = 0;

		$address = $addr_line1 ." " .$addr_line2 ." " .$addr_line3;

		//client table
		$query = "INSERT INTO client_tb (first_name,last_name,address,home_phone,mobile_phone,NIC,email,tax_number,deed_no,current,purpose,meter_id,is_delete) VALUES ('{$first_name}','{$last_name}','{$address}','{$home_phone}','{$mobile_phone}','{$nic}','{$email}','{$tax_number}','{$deed_number}','{$current}','{$purpose}',{$meter_ID},{$is_delete})";

		$result = mysqli_query($connection,$query);

		if($result){

			//get client_id
			$queryNew = "SELECT * FROM client_tb WHERE meter_id = {$meter_ID} ";

			$result = mysqli_query($connection,$queryNew);

			//$new_meter = array();		
			$meter_id = "";
			$client_id = "";
			$password = "";

			while($row = mysqli_fetch_assoc($result)){

			/*	$new_meter[] = array(
					'meter_id' => $row["meter_id"],
					'client_id' => $row["client_id"],
					'password' => "Gihan123"
				);*/
				$meter_id = $row["meter_id"];
				$client_id = $row["client_id"];
				$password = "gundu";

				//add to meter table
				$queryToMeter = "INSERT INTO meter_tb(meter_id,client_id,password,meter_type) VALUES ('".$row["meter_id"]."','".$row["client_id"]."','$password','".$row["purpose"]."')";
				mysqli_query($connection,$queryToMeter);

			}
			header("Location: http://localhost/MyphpActivities/elec_meter/provincialReq/getnewMeters.php?meter_id=$meter_id&client_id=$client_id&password=$password");
			//header("Location:../Admin_search/admin_search.php");
			//echo "successfully added";
		}else{
			echo "Error";
		}

	}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add client</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">

	<script type="text/javascript">
	function validation(arg){
		var fName = arg.first_name.value;
		var lName = arg.last_name.value;
		var addrline1 = arg.address_line1.value;
		var addrline2 = arg.address_line2.value;
		var addrline3 = arg.address_line3.value;
		var homePhone = arg.home_phone.value;
		var mobilePhone = arg.mobile_phone.value;
		var taxNo = arg.tax_number.value;
		var deedNo = arg.deed_number.value;
		var meterID = arg.meter_ID.value;
		var nic = arg.nic.value;
		var email = arg.email.value;
		var current = arg.current.value;
		var purpose = arg.purpose.value;

		var ePat = /^[a-z-._0-9]+@[a-z0-9]+\.[a-z.]{2,5}$/;
		var namePatDt = /\./;
		var namePatDgt = /\d/;
		var nicPat1 = /^[0-9]+V/;
		var nicPat2 = /^[0-9]+X/;
		var nicPat3 = /^[0-9]+v/;
		var nicPat4 = /^[0-9]+x/;
		var err = "";
		var errNum = 0;


		if(fName == ""){
	        errNum++;
	        err += errNum + ". First name cannot be empty.\n";
        }else if(fName.length< 2 || namePatDt.test(fName) || namePatDgt.test(fName)){
        	errNum++;
	        err += errNum + ". Invalid first name.\n";
        }

        if(lName == ""){
	        errNum++;
	        err += errNum + ". Last name cannot be empty.\n";
        }else if(lName.length< 2 || namePatDt.test(lName) || namePatDgt.test(lName)){
        	errNum++;
	        err += errNum + ". Invalid last name.\n";
        }

        if(addrline1 == ""){
	        errNum++;
	        err += errNum + ". Address line 1 cannot be empty.\n";
        }

        if(addrline2 == ""){
	        errNum++;
	        err += errNum + ". Address line 2 cannot be empty.\n";
        }else if(addrline2.length< 2){
        	errNum++;
	        err += errNum + ". Invalid address line 2.\n";
        }

        if(addrline3 == ""){
	        errNum++;
	        err += errNum + ". Address line 3 cannot be empty.\n";
        }else if(addrline3.length< 2){
        	errNum++;
	        err += errNum + ". Invalid address line 3.\n";
        }

        if ( (homePhone != "") && (homePhone.length!= 10 || isNaN(homePhone)) ) {
	        errNum++;
	        err += errNum + ". Invalid home phone number.\n";
        }

        if (mobilePhone == "") {
	        errNum++;
	        err += errNum + ". Mobile phone number cannot be empty.\n";
        }else if(mobilePhone.length!= 10 || isNaN(mobilePhone)){
        	errNum++;
	        err += errNum + ". Invalid mobile phone number.\n";
        }

        if(taxNo!=""){
	        if (taxNo.length> 10 || isNaN(taxNo)) {
		        errNum++;
		        err += errNum + ". Invalid tax number.\n";
	        }
	    }

        if (deedNo == "") {
	        errNum++;
	        err += errNum + ". Deed number cannot be empty.\n";
        }else if(deedNo.length> 10 || isNaN(deedNo)){
        	errNum++;
	        err += errNum + ". Invalid deed number.\n";
        }

        if (meterID == "") {
	        errNum++;
	        err += errNum + ". Meter ID cannot be empty.\n";
        }else if(meterID.length> 10 || isNaN(meterID)){
        	errNum++;
	        err += errNum + ". Invalid meter ID.\n";
        }

        if (nic == "") {
	        errNum++;
	        err += errNum + ". NIC cannot be empty.\n";
        }else if(nic.length!= 10 || !(nicPat1.test(nic) || nicPat2.test(nic) || nicPat3.test(nic) || nicPat4.test(nic))){
        	errNum++;
	        err += errNum + ". Invalid NIC\n";
        }

        if(email!=""){
	        if(!ePat.test(email)){
	            errNum++;
	            err += errNum + ". Invalid Email.\n";   
	        }
	    }

        if (!arg.current[0].checked && !arg.current[1].checked && !arg.current[2].checked) {
            errNum++;
            err += errNum + ". Select Current.\n";
        }
        if (!arg.purpose[0].checked && !arg.purpose[1].checked && !arg.purpose[2].checked && !arg.purpose[3].checked) {
            errNum++;
            err += errNum + ". Select purpose.\n";
        }

        if (errNum>0) {
            alert(err);
            return false;
        }else{
            alert('done');
            return true;
        }
   
	}
</script>



</head>
<body>


    <?php require_once('../header.php'); ?>
	
	<div class="container" style="overflow-y: scroll; min-height: 680px; max-height: 680px;">
		<form action="addClient.php" class="well form-horizontal" method="post" id="contact-form" onsubmit="return validation(this);">
			<fieldset>
				<legend><p class="text-center"><i class="glyphicon glyphicon-plus"></i>Add Client</p></legend>

					<!--First Name-->

					<div class="form-group">
						<label class="col-sm-2 control_label"><p class="text-center"><mark>Full Name</mark></p></label>

						<label class="col-sm-2 col-xs-12 control_label"><p>First Name</p></label>
						<div class="col-sm-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" name="first_name" placeholder="Enter First Name here" class="form-control">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control_label"><p class="text-center"></p></label>
						
						<label class="col-sm-2 col-xs-12 control_label"><p>Last Name</p></label>
						<div class="col-sm-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" name="last_name" placeholder="Enter Last Name here" class="form-control">
							</div>
						</div>
					</div>
					

					<br>

					<!--Address-->

					<div class="form-group">
						<label class="col-sm-2 control_label"><p class="text-center"><mark>Address</mark></p></label>
						<label class="col-sm-2 col-xs-12 control_label"><p>line 1</p></label>
						<div class="col-sm-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input type="text" name="address_line1" placeholder="Address line 1 here" class="form-control">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control_label"><p class="text-center"></p></label>
						<label class="col-sm-2 col-xs-12 control_label"><p>line 2</p></label>
						<div class="col-sm-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input type="text" name="address_line2" placeholder="Address line 2 here" class="form-control">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control_label"><p class="text-center"></p></label>
						<label class="col-sm-2 col-xs-12 control_label"><p>line 3</p></label>
						<div class="col-sm-8 inputGroupContainer">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
								<input type="text" name="address_line3" placeholder="Address line 3 here" class="form-control">
							</div>
						</div>
					</div>

					<br>
					
					<!--Phone Numbers-->
					
					<div id="col1" style="width :50%; height: 100%; float: left">

						<div class="form-group">
							<label class="col-sm-2 col-xs-12 control_label"><p>Home</p></label>
							<div class="col-sm-9 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
									<input type="text" name="home_phone" placeholder="Home phone number" class="form-control">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 col-xs-12 control_label"><p>Mobile</p></label>
							<div class="col-sm-9 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
									<input type="text" name="mobile_phone" placeholder="Mobile phone number" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 col-xs-12 control_label"><p>Tax No:</p></label>
							<div class="col-sm-9 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
									<input type="text" name="tax_number" placeholder="TAX number" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 col-xs-12 control_label"><p>Deed No:</p></label>
							<div class="col-sm-9 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
									<input type="text" name="deed_number" placeholder="Deed number" class="form-control">
								</div>
							</div>
						</div>

						<br>

						<div class="form-group">
							
							<label class="col-sm-2 col-xs-12 control_label"><p>Meter ID</p></label>
							<div class="col-sm-9 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
									<input type="text" name="meter_ID" placeholder="Enter Meter ID here" class="form-control">
								</div>
							</div>
						</div>
											

					</div>

					<div id="col2" style="width :50%; height: 100%; float: left">

						<div class="form-group">
							
							<label class="col-sm-2 col-xs-12 control_label"><p>NIC</p></label>
							<div class="col-sm-10 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-asterisk"></i></span>
									<input type="text" name="nic" placeholder="National Identity Card Number" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							
							<label class="col-sm-2 col-xs-12 control_label"><p>Email</p></label>
							<div class="col-sm-10 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-send"></i></span>
									<input type="text" name="email" placeholder="Email" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							
							<label class="col-sm-4 col-xs-12 control_label"><p>Current</p></label>
							<label class="radio-inline"><input type="radio" name="current" value="15">15 A</label>
							<label class="radio-inline"><input type="radio" name="current" value="30">30 A</label>
							<label class="radio-inline"><input type="radio" name="current" value="60">60 A</label>
						</div>


						<div class="form-group">
							
							<label class="col-sm-4 col-xs-12 control_label"><p>Purpose</p></label>
							<label class="radio-inline"><input type="radio" name="purpose" value="Domestic">Domestic</label>
							<label class="radio-inline"><input type="radio" name="purpose" value="Merchant">Merchant</label>
							<label class="radio-inline"><input type="radio" name="purpose" value="Industry">Industry</label>
							<label class="radio-inline"><input type="radio" name="purpose" value="Other">Other</label>
						</div>

						
					<br>

					<!--Submit button-->
					
					<div class="form-group">
						<label class="col-md-2 control_label"></label>
						<div class="col-sm-12 col-sm-offset-2">
							<div class="input-group">
								<button name="Submit" style="height:50px; width: 300px" type="Submit" class="btn btn-primary">Confirm & add client</button>
							</div>
						</div>
					</div>
				

			</fieldset>
		</form>
	</div>


    <?php require_once('../footer.php'); ?>

</body>
</html>

<?php mysqli_close($connection); ?>