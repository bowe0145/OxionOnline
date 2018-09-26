<?php
	session_start();

$ip = $_SERVER['REMOTE_HOST'];

	if(!isset($_SESSION['sUsername']))
	{
		header("Location: index.php");
		exit;
	}
	else
	{
		
	}
?>

<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Oxion UserCP</title> 
<meta name="description" content="Oxion UserCP">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="bootstrap/css/test.css" rel="stylesheet">
<?php
include_once '../Assets/includes/head.php';
?>
</head>
<body>
<div id="wrap">

<?php
include_once '../Assets/includes/nav.php';
?>

<?php
include_once '../Assets/includes/header.php';
?>

<!-- PAGE CONTENT
====================================================== -->	
<div class="pagebody">
    <div class="container">
		<div id="mainPageBody">

        <div class="MainElement">
        <?php
        include_once 'MainPage.php';
        ?>
        </div>
    </div>

        <div id="mainPageSide">
        <?php
        include_once '../Assets/includes/SidePage.php';
        ?>
        </div>

        <?php
        include_once '../Assets/includes/footer.php';
        ?>

      </div>
    </div>
</div>
</div>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script src="bootstrap/js/bootstrap-dropdown.js"></script>
<script src="bootstrap/js/bootstrap-alert.js"></script>

<script>

function ChangeEmail(){
	$.post('handler.php', $('#ChangeEmail').serialize()).done(function(data){
		console.log(data);
		if(data == 0){
			msg("error", "Enter a vaild email address");	
		}
		else if(data == 1){
			msg("success", "Email successfully changed");
		}
		else if(data == 2){
			msg("error", "Query failed");	
		}
	});
}

function EnterRaffle() {
	$.get('handler.php?EnterRaffle', function(data) {
		alert(data);
		loadContent('handler.php?DisplayRaffle');
	});
}

function ChangePassword(){
	$.post('handler.php', $('#ChangePassword').serialize()).done(function(data){
		console.log(data);
		if(data == 0){
			msg("info", "Enter a correct password old");	
		}
		else if(data == 1){
			msg("info", "Enter a correct password new");
		}
		else if(data == 2){
			msg("info", "Enter a correct password confirm");
		}
		else if(data == 3){
			msg("info", "Passwords does not match");
		}
		else if(data == 4){
			msg("error", "Wrong password");
		}
		else if(data == 5){
			msg("success", "Password successfully changed");	
		}
		else if(data == 6){
			msg("error", "Query execeution failed");	
		}
	});
}

function SendCoins(){
	$.post('handler.php', $('#SendCoins').serialize()).done(function(data){
		console.log(data);
		if(data == 0){
			msg("info", "Invalid Username.");	
		}
		else if(data == 1){
			msg("info", "Invalid amount entered.");
		}
		else if(data == 2){
			msg("info", "Not enough coins.");
		}
		else if(data == 3){
			msg("info", "Query execeution failed.");
		}
		else if(data == 4){
			msg("info", "Credits have been sent successfully.");
		}
	});
}

$(document).ready(function () {
	loadContent('../UserCP/handler.php?account');
	$('#UserCPNav > li').click(function (e) {
		e.preventDefault();
		$('#UserCPNav > li').removeClass('active');
		$(this).addClass('active');                
	});            
});

function msg(type, message) {
	var alert = document.getElementById('msg');
	alert.setAttribute('class', 'alert alert-' + type);
	alert.innerHTML = message;
	alert.style.display = 'block';
}

function loadContent(page)
{
	$("#content").load(page);
}

function Logout(){
	window.location = "handler.php?logout";
}
</script>
<script type="text/javascript" src="../Assets/js/Script.js"></script>
</body>
</html> 
    