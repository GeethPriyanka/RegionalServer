<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php 
	
	if(isset($_POST['Submit'])){

		$user_name = $_POST['user_name'];
		$password = $_POST['password'];
		$operational_level = $_POST['opt_level'];
		$is_delete = 0;

		$hashed_password = sha1($password);

		$query = "INSERT INTO admin_tb(name,password,user_type,is_delete) VALUES('{$user_name}','{$hashed_password}','{$operational_level}',{$is_delete})";

		$result = mysqli_query($connection,$query);

		if($result){
			header("Location:../Admin_search/admin_search.php");
		}else{
			echo $query;
		}

	}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Add Admin</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">

	<script type="text/javascript">
		function validation(arg){
			var fName = arg.first_name.value;
			var lName = arg.last_name.value;
			var userName = arg.user_name.value;
			var password = arg.password.value;
			var password2 = arg.password2.value;
			var optLevel = arg.optLevel.value;

			var ePat = /^[a-z-._0-9]+@[a-z0-9]+\.[a-z.]{2,5}$/;
			var namePatDt = /\./;
			var namePatDgt = /\d/;
			var spaceCheck = /\s/;
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

	        if(userName == ""){
		        errNum++;
		        err += errNum + ". User name cannot be empty.\n";
	        }else if(userName.length< 2 || namePatDt.test(userName) || namePatDgt.test(userName) || spaceCheck.test(userName)){
	        	errNum++;
		        err += errNum + ". Invalid user name.\n";
	        }

	        if(password == ""){
		        errNum++;
		        err += errNum + ". Password cannot be empty.\n";
	        }

	        if(password2 == ""){
		        errNum++;
		        err += errNum + ". Password confirmation cannot be empty.\n";
	        }

	        if(password!="" && password2!=""){
	        	if(password!=password2){
	        		errNum++;
		        	err += errNum + ". Passwords do not match.\n";
	        	}
	        }

	        if (!arg.optLevel[0].checked && !arg.optLevel[1].checked && !arg.optLevel[2].checked && !arg.optLevel[3].checked) {
	            errNum++;
	            err += errNum + ". Select operation level.\n";
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

	<div class="container" style="margin-top: 153px; margin-bottom: 153px;">
		<form action="addAdmin.php" class="well form-horizontal" method="post" id="contact-form" onsubmit="return validation(this);">
			<fieldset>
				<legend><p class="text-center"><i class="glyphicon glyphicon-plus"></i>Add Admin</p></legend>

					<!--Full Name-->

					
					<br>

					<div id="col1" style="width :50%; height: 100%; float: left">
						
						<!--User Name-->

						<div class="form-group">
							<label class="col-md-4 col-xs-12 control_label"><p class="text-center"><mark>User Name</mark></p></label>
							<div class="col-md-8 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-flag"></i></span>
									<input type="text" name="user_name" placeholder="Enter your User Name here" class="form-control">
								</div>
							</div>
						</div>

						<!--Password-->

						<div class="form-group">
							
							<label class="col-md-4 col-xs-12 control_label"><p class="text-center">Enter Password</p></label>
							<div class="col-md-8 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="password" id="txtPassword" placeholder="Enter password here" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 col-xs-12 control_label"><p class="text-center">Re-Enter Password</p></label>
							<div class="col-md-8 inputGroupContainer">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
									<input type="password" name="password2" id="textConfirmPassword" placeholder="Re-Enter password here" class="form-control">
								</div>
							</div>
						</div>

					</div>		

					<div id="col2" style="width :50%; height: 100%; float: left">	
						<label class="col-md-4 col-md-offset-1 control_label"><p>Operational Level</p></label>
						<div class="form-group col-xs-10 col-xs-push-5">
							
							<label class="radio"><input type="radio" name="optLevel" value="Full">Full Access</label>
							<label class="radio"><input type="radio" name="optLevel" value="Half">Half Access</label>
							<label class="radio"><input type="radio" name="optLevel" value="Default">Default</label>
							<label class="radio"><input type="radio" name="optLevel" value="Guest">Guest</label>
						</div>
		
					<br>
						<!--Submit button-->

						<div class="form-group">
							<label class="col-sm-4 control_label"></label>
							<div class="col-md-4">
								<div class="input-group">
									<button name="Submit" id="btnSubmit" value="Submit" style="height:50px; width: 300px" type="Submit" class="btn btn-primary">Confirm & add Admin</button>
								</div>
							</div>
						</div>
					</div>


			</fieldset>
		</form>
	</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
	$(function () {
		$("#btnSubmit").click(function(){
			var password = $("#txtPassword").val();
			var confirmPassword = $("#textConfirmPassword").val();
			if(password != confirmPassword){
				alert("Passwords do not match");
				return false;
			}
			return true;
		});
	});
</script>
	<?php require_once('../footer.php'); ?>

</body>
</html>

<?php mysqli_close($connection); ?>