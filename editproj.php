<?php
	session_start();
	$UID = $_SESSION['UID'];	//retrieve UID
	$UNAME = $_SESSION['UNAME'];	//retrieve USERNAME
	$PID = $_SESSION['PID'];
	$PNAME = $_SESSION['PNAME'];
	$panelMsg = "";
	
	if($UNAME == NULL){
		header("Location: login.php");
		die();
	}
  	// Connect to the database. 
    include 'db.php';
	$db = init_db();	

	if (isset($_POST['submit'])) {	

		if ($_POST[editProjName] <> NULL) {
		$sqlEditProjName = "UPDATE projectsownership SET projectname = '$_POST[editProjName]' WHERE ownername = '$PNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditProjName);
		echo "$editProjNameResult";
		}

		if ($_POST[editProjDesc] <> NULL) {
		$sqlEditProjDesc = "UPDATE projectsownership SET projectdescription = '$_POST[editProjDesc]' WHERE ownername = '$PNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditProjDesc);
		}

		if ($_POST[editEndDate] <> NULL) {
		$sqlEditEndDate = "UPDATE projectsownership SET enddate = '$_POST[editEndDate]' WHERE ownername = '$PNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditEndDate);
		}

		if ($_POST[editTargetAmt] <> NULL) {
		$sqlEditTargetAmt = "UPDATE projectsownership SET targetamount = '$_POST[editTargetAmt]' WHERE ownername = '$PNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditTargetAmt);
		}

		if ($_POST[editCat] <> NULL) {
		$sqlEditCat = "UPDATE projectsownership SET category = '$_POST[editCat]' WHERE ownername = '$PNAME' AND projectid = '$PID'";
		$editProjNameResult = pg_query($db, $sqlEditCat);
		}
		
		$panelMsg = "Project successfully updated";
	}
	
	//Display selected project based on $PID and $PNAME
	$result = pg_query($db, "SELECT * FROM projectsOwnership WHERE ownername = '$PNAME' AND projectid = '$PID'");
	$rows = pg_fetch_assoc($result);

	if (!$result) {
		$panelMsg = "error getting proj from db";
	}
	$projects = pg_fetch_all($result);

	foreach ($projects as $project){
		$row = array_values($project);
		$name = $row[0];
		$description = $row[1];
		$startDate = $row[2];
		$endDate = $row[3];
		$id = $row[4];
		$ownerName = $row[5];
		$amount = $row[6];
		$progress = $row[7];
		$category = $row[8];
	}
?> 

<!DOCTYPE html>  
<html>
<head>
  <title>Edit Project</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Import CSS Files -->
  <link rel="stylesheet" href="css/w3.css">
  
</head>

<body>
<!-- Nagivation Bar -->
<?php
if($UNAME == NULL){
	$menu = file_get_contents('menu.html');
	echo $menu;
}
else{
	if($_SESSION['ADMIN'] == "true"){
		$menu = file_get_contents('menu-admin.html');
	} else {
		$menu = file_get_contents('menu-loggedin.html');
	}
	echo $menu;
}
//Display message pannel
if($panelMsg != ""){
	echo "<div class='w3-panel w3-yellow'><p>" . $panelMsg . "</p></div>";
}
?>

<!-- Slide Show
<div class="w3-content w3-section" style="max-height:500px">
  <img class="mySlides" src="img/water.jpg" style="width:100%">
  <img class="mySlides" src="img/castle.jpg" style="width:100%">
  <img class="mySlides" src="img/road.jpg" style="width:100%">
</div>
-->
<div class="w3-card w3-margin">
	<header class="w3-container w3-brown">
		<h1>Edit Project Form</h1>
	</header>
	<div class="w3-sand">
<!-- Main Body -->
<?php
if($UNAME == $ownerName){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Project Name</b></label></p>
	<p><input class='w3-input w3-border' name='editProjName' value='" . $name. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Project Description</b></label></p>
	<p><input class='w3-input w3-border' name='editProjDesc' value='" . $description . "' type='text'></p>

	<p>
	<label class='w3-text-brown'><b>Start Date (Cannot be changed): </b></label>
	<label class='w3-text-black'>$startDate</label></p>

	<p><label class='w3-text-brown'><b>End Date (YYYY-MM-DD)</b></label></p>
	<p><input class='w3-input w3-border' name='editEndDate' value='" . $endDate . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Target Amount</b></label></p>
	<p><input class='w3-input w3-border' name='editTargetAmt' value='" . $amount . "' type='text'></p>

	<p>
	<label class='w3-text-brown'><b>Progress (Cannot be changed): </b></label>
	<label class='w3-text-black'>$progress</label></p>

	<p><label class='w3-text-brown'><b>Category</b></label></p>     
	<p><input class='w3-input w3-border' name='editCat' value='" . $category . "' type='text'></p>
	
    <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit Project Information'></button></p>
	</form>";
}

else if($_SESSION['ADMIN'] == TRUE){
	echo "
	<form class='w3-container' method='POST'>
    <p><label class='w3-text-brown'><b>Project Name</b></label></p>
	<p><input class='w3-input w3-border' name='editProjName' value='" . $name. "' type='text'></p>

    <p><label class='w3-text-brown'><b>Project Description</b></label></p>
	<p><input class='w3-input w3-border' name='editProjDesc' value='" . $description . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Start Date (Cannot be changed)</b></label></p>
	<p><label class='w3-text-black'>$startDate</label></p>

	<p><label class='w3-text-brown'><b>End Date (YYYY-MM-DD)</b></label></p>
	<p><input class='w3-input w3-border' name='editEndDate' value='" . $endDate . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Target Amount</b></label></p>
	<p><input class='w3-input w3-border' name='editTargetAmt' value='" . $amount . "' type='text'></p>

	<p><label class='w3-text-brown'><b>Progress (Cannot be changed)</b></label></p>
	<p><label class='w3-text-black'>$projprogress</label></p>

	<p><label class='w3-text-brown'><b>Category</b></label></p>     
	<p><input class='w3-input w3-border' name='editCat' value='" . $category . "' type='text'></p>
	
    <input class='w3-btn w3-brown' type='submit' name='submit' value='Edit Project Information'></button></p>
	</form>";
}
?>
	</div>
</div>

<!-- Import Javascript Files -->
<script src="js/scripts.js"></script>
</body>
</html>
