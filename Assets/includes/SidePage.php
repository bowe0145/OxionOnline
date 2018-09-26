<?php
function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr<br>";
  echo "Ending Script";
  die();
}

set_error_handler("customError");
?>

<div class="MainElement">
  <a href="http://topofgames.com/index.php?do=votes&id=75601"><img src="../Assets/img/Vote.png"></img></a>
</div>

<div class="MainElement">
  <div id="msg"></div>
  <div id="LoginBox">
<?php
      if(isset($_SESSION['sUsername']))
      {
        echo "<p style='padding-top: 50px; padding-left: 10px; padding-right: 10px; color: white;'>Logged in as " . $_SESSION['sUsername'] . "</p>";
      }
      else
      {
        echo "<form method='post' action='#' onsubmit='Login(); return false;' id='form'>";
        echo "  <label>Username</label>";
        echo "    <input type='text' id='username 'name='username' autocomplete='off' class='input' /><br />";
        echo "    <label>Password</label>";
        echo "    <input type='password' id='password' name='password' class='input' /><br />";
        echo "    <button class='btn' style='margin-top: 2px; color: black;''>Log in</button/>";
        echo "</form>";
      }
?>
  </div>
</div>

<div class="MainElement">
  <div id="ServerStatus">
    <h2 class="online"></h2>
  </div>
</div>

<div class="MainElement">

<div id="TopPlayers">

</div>

</div>

<div class="MainElement">

<div id="Trailer">
<iframe width="297" height="264" src="https://www.youtube.com/embed/uSOwhXx6ngk" frameborder="0" allowfullscreen></iframe>
</div>

</div>

<script>
function Login() {
                $.post("../UserCP/handler.php", $("#form").serialize()).done(function (data) {
                    console.log(data);
                    if (data == 0) {
                        msg("info", "Enter a vaild username");
                    }
                    else if (data == 1) {
                        msg("info", "Enter a vaild password");
                    }
                    else if (data == 2) {
                        window.location = "../UserCP/Account.php";
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