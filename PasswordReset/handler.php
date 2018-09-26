<?php
    
	#Security direct access
    define("OxionUserCP", 0);
   
    require_once("config.php");    
    require_once("init.php");
	
	#Database
	global $db;
	
	#Login user
	if(isset($_POST['username']) && isset($_POST['password']))
	{

		$username = $_POST['username'];
		$password = $_POST['password'];
		
		#Username and password too long or too short?
		if(strlen($username) < 3 || strlen($username) > 15 || preg_match('/[^a-zA-Z0-9]/', $username) > 0){
			Functions::Error('0');
		}
		elseif (strlen($password) < 3 || strlen($password) > 20) {
			Functions::Error('1');
		}
		
		#Username exists?
		$result = $db->ValidateCredentials($username, $password);
		
		#If user exists then set session
		if($result > 0){
			Functions::SetSession($db->Credentials($username, "nEMID"), $username);
			Functions::Error('2');
		}
		else{
			Functions::Error('3');	
		}
	}
	
	#Change Password
	if(isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword']))
	{
		$oldPassword = $_POST['oldPassword'];
		$newPassword = $_POST['newPassword'];
		$confirmPassword = $_POST['confirmPassword'];
		
		#Password too long or too short?
		if(strlen($oldPassword) < 3 || strlen($oldPassword) > 20){
			Functions::Error('0');
		}
		elseif(strlen($newPassword) < 3 || strlen($newPassword) > 20){
			Functions::Error('1');	
		}
		elseif(strlen($confirmPassword) < 3 || strlen($confirmPassword) > 20){
			Functions::Error('2');	
		}
		#Passwords match each other?
		elseif($newPassword != $confirmPassword){
			Functions::Error('3');	
		}
		elseif(!$db->ComparePassword($_SESSION['sUsername'], $oldPassword)){
			Functions::Error('4');	
		}
		
		#Insert the new password
		if($db->ChangePassword($_SESSION['sUsername'], $oldPassword, $newPassword)){
			Functions::Error('5');	
		}
		else{
			Functions::Error('6');	
		}
	}

	if(isset($_POST['email'])){
		$email = $_POST['email'];
		
		#Vaild email address?
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			Functions::Error('0');	
		}
		else
		{
			#If vaild, Insert into database
			if($db->ChangeEmail($_SESSION['sUsername'], $email)){
				Functions::Error('1');	
			}
			else{
				Functions::Error('2');	
			}	
		}	
	}

	#Change Email
	if(isset($_POST['AName']) && isset($_POST['CAmount'])){
		$sendto = $_POST['AName'];
		$amount = $_POST['CAmount'];
		
		#Vaild email address?
		if(strlen($sendto) < 3 || strlen($sendto) > 15 || preg_match('/[^a-zA-Z0-9]/', $sendto) > 0){
			Functions::Error('0');
		}
		elseif($db->GetCoins($_SESSION['sUsername'], $amount) == false)
		{
			Functions::Error('1');
		}
		else
		{
			if($db->RemoveCoins($_SESSION['sUsername'], $amount) && $db->SendCoins($_SESSION['sUsername'], $sendto, $amount)){
				Functions::Error('4');	
			}
			else{
				Functions::Error('3');	
			}	
		}	
	}
	
	#Load account content
	if(isset($_GET['account'])){
		?>
		<div id='MyAccount'>
        	<div id="AccountInfo">
            	<h3>Your Account:</h3>
                <p><strong>Username:</strong> <?php echo $_SESSION['sUsername']; ?></p>
                <p><strong>Password:</strong> ********* <button class="btn btn-small" onclick="loadContent('handler.php?ChangePassword'); return false;">Change</button></p>
                <p><strong>E-Mail:</strong> <?php echo $db->Credentials($_SESSION['sUsername'], "sEmail"); ?> <button class="btn btn-small" onclick="loadContent('handler.php?ChangeEmail'); return false;">Change</button></p>
                <p><strong>Oxion Credits:</strong> <?php echo $db->Credentials($_SESSION['sUsername'], "nAGPoints"); ?></p>
                <br/>
                <h3>Your Characters:</h3>
                <div id="MyCharacters">
                	<?php $db->fetchCharacter($_SESSION['nEMID']);?>
                </div>
            </div>
        </div>
        <?php
	}
	elseif(isset($_GET['top100p'])){
		?>
			<?php $db->Top100P();?>
        <?php
	}
	elseif(isset($_GET['top10p'])){
		?>
			<?php $db->Top10P();?>
		<?php
	}
	elseif(isset($_GET['top100g'])){
		?>
			<?php $db->Top100G();?>
        <?php
	}
	elseif(isset($_GET['staff'])){
		?>
			<?php $db->Staff();?>
        <?php
	}
	#Load change password form
	elseif(isset($_GET['ChangePassword'])){
		?>
        	<div id='MyAccount'>
            	<div id="PasswordForm">
                  <div id="msg"></div>
                  <h3>Change Password:</h3>
                  <p>If you haven't changed it yet, your pass is: ChangedAllPass4Good</p>
                  <form method="post" action="#" onsubmit="ChangePassword(); reset(); return false;" id="ChangePassword">
                  <label>Current password</label>
                  <input type="password" name="oldPassword" id="input" />
                  <label>New password</label>
                  <input type="password" name="newPassword" id="input" />
                  <label>Confirm password</label>
                  <input type="password" name="confirmPassword" id="input" />
                  <br/>
                  <button class="btn btn-small">Change</button>
                  </form>
                </div>
            </div>
        <?php
	}
	#Load change email form
	elseif(isset($_GET['ChangeEmail'])){
		?>
          <div id='MyAccount'>
              <div id="AccountInfo">
              	<div id="msg"></div>
                  <h3>Change Email:</h3>
                  <form method="post" action="#" onsubmit="ChangeEmail(); reset(); return false;" id="ChangeEmail">
                  <label>New Email:</label>
                  <input type="text" name="email" id="input" />
                  <br/>
                  <button class="btn btn-small">Change</button>
                  </form>
              </div>
          </div>
        <?php
	}
	elseif(isset($_GET['SendCoins'])){
		?>
        	<div id='MyAccount'>
            	<div id="CoinForm">
                  <div id="msg"></div>
                  <h3>Send Coins:</h3>
                  <form method="post" action="#" onsubmit="SendCoins(); reset(); return false;" id="SendCoins">
                  <label>Send To:</label>
                  <input type="text" name="AName" id="input" />
                  <label>Amount:</label>
                  <input type="text" name="CAmount" id="input" />
                  <br/>
                  <button class="btn btn-small">Send</button>
                  </form>
                </div>
            </div>
        <?php
	}
	#Logout, redirect
	elseif(isset($_GET['logout'])){
	  	Functions::LogOut();
	  	Functions::Redirect("/Main/");
	}
?>