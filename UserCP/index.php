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
        <div id="content">
			 <div id="login" class="well well-small">
                <div id="msg"></div>
                <form method="post" action="#" onsubmit="Login(); return false;" id="form">
                    <label>Username</label>
                    <input type="text" id="username "name="username" autocomplete="off" class="input" /><br />
                    <label>Password</label>
                    <input type="password" id="password" name="password" class="input" /><br />
                    <button class="btn">Log in</button/>
                </form>
            </div>
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

        

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
        <script src="bootstrap/js/bootstrap-alert.js"></script>
        
        <script>

            function Login() {
                $.post("handler.php", $("#form").serialize()).done(function (data) {
                    console.log(data);
                    if (data == 0) {
                        msg("info", "Enter a vaild username");
                    }
                    else if (data == 1) {
                        msg("info", "Enter a vaild password");
                    }
                    else if (data == 2) {
                        window.location = "Account.php";
                    }
                    else if (data == 3) {
                        msg("error", "Invaild username or password");
                    }
                    else {
                        msg("error", data);
                    }
                });
            }

            function msg(type, message) {
                var alert = document.getElementById('msg');
                alert.setAttribute('class', 'alert alert-' + type);
                alert.innerHTML = message;
                alert.style.display = 'block';
            }
        </script>
    </body>
</html>