<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US" prefix="og: http://ogp.me/ns#">
    <head>
        <meta name="viewport" content="width=device-width">
            <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../Assets/css/style.css">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
        <title>Oxion Online - Home Page</title>
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
            <?php
            include_once 'MainPage.php';
            ?>
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
        
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../Assets/js/Script.js"></script>
</body>
</html>