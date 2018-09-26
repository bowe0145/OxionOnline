<!doctype html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<title>&nbsp;</title>
    <link href="./Template/css/main.css" rel="stylesheet" type="text/css" />
    <link href="./Template/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="./Template/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/js/Script.js"></script>
<script>
var title = "Oxion Store";

$(document).ready(function()
{
	loadReset();
	
	document.title = title;
});

function loadReset()
{
	$("#content").load('handler.php');
	
	$("#main").html('');
}

function buyItem( id )
{
	var conf = confirm("Are you sure you want to buy this item?" );
	
	if( conf == true )
	{
		$.post("handler.php", {buy: id}).done(function(data){
			alert(data);
			
			updateCoins();
		});
	}
	else
	{
		return false;
	}
}

function loadCat( id )
{
	$.get("handler.php?cat=" + id , function(data)
	{
		$("#main").html(data);
		
		$('li').removeClass('active')
		
		$("#lbl_" + id ).addClass("active");
		
		document.title = title + " - " + $("#lbl_" + id ).text();
	});
}

function Login()
{
    var user = document.getElementById("username");
    
    var pass = document.getElementById("password");
    
    $.post("handler.php", $("#form").serialize() ).done(function(data){
        if( data == 1 )
        {
            alert("Invalid login credentials");
        }
        else if( data == 2 )
        {
            alert("Enter a correct password");
        }
        else if( data == 3 )
        {
            alert("Enter a correct username");
        }		
        else if( data == 4 )
        {
           loadReset();
		   
		   $("#main").html('<div class="alert alert-info">Click on a category to get shopping!<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
        }	
		else
		{
			alert("server error");
		}
    });
}

function Logout()
{
	$.get('handler.php?logout').done(function(){
		loadReset();
		
		document.title = title;
	});
}

function displayDesc( id )
{
	$("#" + id ).toggle("swing");
}

function updateCoins()
{
	$.get('handler.php?coins').done(function(data){
		$("#coins_lbl").html("Oxion Credit:<b style=\"color:red;\">" + data + "</b>");
	});
}
</script>
</body>
</html>