<?php
    if(!defined("OxionUserCP")) exit;
    
    class sqlsrv
    {
        var $connection;
		
        function sqlsrv(){

			global $Config;
			$this->Config = $Config;
			
            $connection_array = array( "Database"=>$this->Config['DB'], "UID"=>$this->Config['USER'], "PWD"=>$this->Config['PASS']);
            $this->connection = sqlsrv_connect($this->Config['HOST'], $connection_array);

            if(!$this->connection){
                die( print_r( sqlsrv_errors(), true));
            }
        }
        
        function ValidateCredentials($username, $password){

            $sql = "SELECT * FROM tAccounts WHERE sUsername = ? AND sUserPass = ?";
            $param = array($username, $password);
            $options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
            $stmt = sqlsrv_query($this->connection, $sql, $param, $options);

            return $row_count = sqlsrv_num_rows($stmt);
        }
        
        function Credentials($username, $column){
            $sql = "SELECT * FROM tAccounts WHERE sUsername = ?";
            $param = array($username);
            $stmt = sqlsrv_query($this->connection, $sql, $param);

            $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            return $row[$column];
        }

		function Staff(){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT * FROM tCharacter WHERE bDeleted = ? AND nAdminlevel > 1 AND sID != 'HueHueHue'";
			$param = array(0);
			$characters = sqlsrv_query($testcon, $sql, $param);
			$rank = 0;

			?>

			 <table align="center">
			 	<tr class="column">
				    <td>#</td>
					<td>Name</td>
					<td>Level</td>
				</tr>

			<?php
			
			while($character = sqlsrv_fetch_array($characters, SQLSRV_FETCH_ASSOC)){
				$rank = $rank + 1;
				$nCharNo = $character['nCharNo'];
				$name = $character['sID'];
				$level = $character['nLevel'];
				
				$query = sqlsrv_query($testcon, "SELECT * FROM tCharacterShape WHERE nCharNo = ?", array($nCharNo));
				

				while($shape = sqlsrv_fetch_array($query)){
					$class = $shape['nClass'];
				}
				?>

				<?php

		echo "<tr>";
		echo "<td>" . $rank . "</td>";
		echo "<td>" . $name . "</td>";
		echo "<td>" . $level . "</td>";
		echo "</tr>";

				?>
                <?php
			}

			?>

            </table>

			<?php
		}  
		
		function Top10P(){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT TOP 10 * FROM tCharacter WHERE bDeleted = ? AND nAdminlevel = ? ORDER BY nLevel DESC";
			$param = array(0, 0);
			$characters = sqlsrv_query($testcon, $sql, $param);
			$rank = 0;

			?>

			 <table>

			<?php
			
			while($character = sqlsrv_fetch_array($characters, SQLSRV_FETCH_ASSOC)){
				$rank = $rank + 1;
				$nCharNo = $character['nCharNo'];
				$name = $character['sID'];
				$level = $character['nLevel'];
				$playTime = $character['nPlayMin'];
				
				$query = sqlsrv_query($testcon, "SELECT * FROM tCharacterShape WHERE nCharNo = ?", array($nCharNo));
				

				while($shape = sqlsrv_fetch_array($query)){
					$class = $shape['nClass'];
				}
				?>

				<?php
				echo "<tr>";
				if ($rank < 4) {
					echo "<td class='PlayerName Rank" . $rank . "'>" . $name . "</td>";
					echo "<td class='PlayerLevel Rank" . $rank . "'>" . $level . "</td>";
					echo "<td class='PlayTime Rank" . $rank . "'>" . $playTime . "</td>";
					echo "</tr>";
				} else {
					echo "<td class='PlayerName'>" . $name . "</td>";
					echo "<td class='PlayerLevel'>" . $level . "</td>";
					echo "<td class='PlayTime'>" . $playTime . "</td>";
					echo "</tr>";
				}
				?>
                <?php
			}

			?>

            </table>

			<?php
		}

		function Top100P(){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT TOP 100 * FROM tCharacter WHERE bDeleted = ? AND nAdminlevel = ? ORDER BY nPlayMin DESC";
			$param = array(0, 0);
			$characters = sqlsrv_query($testcon, $sql, $param);
			$rank = 0;

			?>

			 <table align="center">
			 	<tr class="column">
				    <td>#</td>
					<td>Name</td>
					<td>Level</td>
					<td>Play Time</td>
				</tr>

			<?php
			
			while($character = sqlsrv_fetch_array($characters, SQLSRV_FETCH_ASSOC)){
				$rank = $rank + 1;
				$nCharNo = $character['nCharNo'];
				$name = $character['sID'];
				$level = $character['nLevel'];
				$playTime = $character['nPlayMin'];
				
				$query = sqlsrv_query($testcon, "SELECT * FROM tCharacterShape WHERE nCharNo = ?", array($nCharNo));
				

				while($shape = sqlsrv_fetch_array($query)){
					$class = $shape['nClass'];
				}
				?>

				<?php

		echo "<tr>";
		echo "<td>" . $rank . "</td>";
		echo "<td>" . $name . "</td>";
		echo "<td>" . $level . "</td>";
		echo "<td>" . $playTime . "</td>";
		echo "</tr>";

				?>
                <?php
			}

			?>

            </table>

			<?php
		}  

		function Top100G(){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT TOP 100 * FROM tGuild ORDER BY nWarWinCount DESC";
			$param = array(0, 0);
			$characters = sqlsrv_query($testcon, $sql, $param);
			$rank = 0;

			?>

			 <table align="center">
			 	<tr class="column">
				    <td>#</td>
					<td>Name</td>
					<td>Win</td>
					<td>Lose</td>
					<td>Draw</td>
				</tr>

			<?php

			while($guild = sqlsrv_fetch_array($characters, SQLSRV_FETCH_ASSOC)){
				$rank = $rank + 1;
				$name = $guild['sName'];
				$win = $guild['nWarWinCount'];
				$lose = $guild['nWarLoseCount'];
				$draw = $guild['nWarDrawCount'];

				?>

				<?php

		echo "<tr>";
		echo "<td>" . $rank . "</td>";
		echo "<td>" . $name . "</td>";
		echo "<td>" . $win . "</td>";
		echo "<td>" . $lose . "</td>";
		echo "<td>" . $draw . "</td>";
		echo "</tr>";

				?>
                <?php
			}

			?>

            </table>

			<?php
		}  

		function DisplayRaffle() {
			$connection_array = array( "Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT RaffleID FROM Raffle";
			$param = array(0, 0);
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$users = sqlsrv_query($testcon, $sql, $param, $options);
			$date1 = new DateTime("1 hour ago");
			$date2 = new DateTime("tomorrow midnight");

			$interval = $date2->diff($date1);
			?>
			<div id="RaffleContainer">
	  		<p class="PrizePool">0 IM</p>
	  		<p class="TimeRemaining"><?php echo $interval->format("%h:%i:%s") ?></p>

			<?php
			$hasRows = sqlsrv_has_rows($users);
		
			if ($hasRows === true) {
				$row_count = sqlsrv_num_rows($users);
			   
			if ($row_count === false) {
			   	$Entries = 0;
			} else
			   	$Entries = $row_count;
			} else {
				$Entries = 0;
			}

			echo '<p class="TotalEntries">' . $Entries . '</p>';
			echo '<p>Raffle is currently disabled until further notice.</p>';
			?>
			<br />
			<div class="JoinRaffle" onclick="EnterRaffle(); return false;"></div>
			</div>
			<?php
		}

		function EnterRaffle() {
			// TODO: Check the main db to make sure the acount exists
			// Check if the user exists
			$param = array($_SESSION['sUsername'], 0);
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

			$UserExists = false;
			$UserEntered = true;

			$conn_Array_Test = array("Database"=>"Account", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
			$conn_Test = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_Array_Test);
			$sql_Test = "SELECT sUsername FROM tAccounts WHERE sUsername = ?";
			$users = sqlsrv_query($conn_Test, $sql_Test, $param, $options);

			// Check if the user exists
			if ($users) {
				$rows = sqlsrv_has_rows($users);
				if ($rows === true) { 
					$UserExists = true;
				} else {
					$UserExists = false;
					echo "User doesn't exist";
				}
			} else {
				echo "Couldn't connect to the userDB";
			}

			// If the user exists then check if they are in the raffle
			if ($UserExists === true) {
				$connection_array = array( "Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
	            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
				$sql = "SELECT * FROM Raffle WHERE sUsername = ?";
				$entries = sqlsrv_query($testcon, $sql, $param, $options);
				
				if ($entries) {
				    $rows = sqlsrv_has_rows( $entries );
				    if ($rows === true) {
				    	$UserEntered = true;
				      	echo "You can only enter the raffle once.";
				    } else if ($rows === false) {
				    	$UserEntered = false;
					}
				} else {
					echo "Couldn't connect to the RaffleDB";
				}
			}

			// If the user exists and hasnt entered, then add them to the raffle
			if ($UserExists && $UserEntered === false) {
				echo "Entering Raffle.";
	    		$newconnection_array = array( "Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
	            $newtestcon = sqlsrv_connect("NS514002\SQLEXPRESS", $newconnection_array);
				$newsql = "INSERT INTO Raffle VALUES(?)";
				$entries = sqlsrv_query($newtestcon, $newsql, $param);
			}
		}
		
		function ChangePassword($username, $oldPassword, $newPassword){
			
			$compare = $this->Credentials($username, "sUserPass");
			
			if($compare != $oldPassword){
				return 1;	
			}
			else{
				
				$sql = "UPDATE tAccounts SET sUserPass = ? WHERE sUsername = ? AND sUserPass = ?";
				$param = array($newPassword, $username, $oldPassword);
				$stmt = sqlsrv_query($this->connection, $sql, $param);
				
				if($stmt){
					return 2;
				}
				else{
					return 3;	
				}
			}
		}
		
		function ComparePassword($username, $oldPassword){
			$compare = $this->Credentials($username, "sUserPass");
			
			if($compare == $oldPassword){
				return true;
			}
			else{
				return false;	
			}
		}
		
		function ChangeEmail($username, $email){
			$sql = "UPDATE tAccounts SET sEmail = ? WHERE sUsername = ?";
			$param = array($email, $username);
			$stmt = sqlsrv_query($this->connection, $sql, $param);
			
			if($stmt){
				return true;	
			}
			else{
				return false;
			}
		}

		function GetCoins($username, $required){
			$sql = "SELECT * FROM tAccounts WHERE nAGPoints >= ? AND sUsername = ?";
			$param = array($required, $username);
			$stmt = sqlsrv_query($this->connection, $sql, $param);

			return sqlsrv_has_rows( $stmt );
		}

		function SendCoins($username, $sendto, $amount){
			$sql = "UPDATE tAccounts SET nAGPoints = (nAGPoints + ?) WHERE sUsername = ?";
			$param = array($amount, $sendto);
			$stmt = sqlsrv_query($this->connection, $sql, $param);

			if($stmt){
				return true;	
			}
			else{
				return false;
			}
		}

		function RemoveCoins($username, $amount){
			$sql = "UPDATE tAccounts SET nAGPoints = (nAGPoints - ?) WHERE sUsername = ?";
			$param = array($amount, $username);
			$stmt = sqlsrv_query($this->connection, $sql, $param);
			
			if($stmt){
				return true;	
			}
			else{
				return false;
			}
		}

		function fetchCharacter($UserNo){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
            $testcon = sqlsrv_connect("NS514002\SQLEXPRESS", $connection_array);
			$sql = "SELECT * FROM tCharacter WHERE nUserNo = ? AND bDeleted = ?";
			$param = array($UserNo, 0);
			$characters = sqlsrv_query($testcon, $sql, $param);
			
			while($character = sqlsrv_fetch_array($characters, SQLSRV_FETCH_ASSOC)){
				
				$nCharNo = $character['nCharNo'];
				$name = $character['sID'];
				$level = $character['nLevel'];
				$pk = $character['nPKCount'];
				
				$query = sqlsrv_query($testcon, "SELECT * FROM tCharacterShape WHERE nCharNo = ?", array($nCharNo));
				
				while($shape = sqlsrv_fetch_array($query)){
					$class = $shape['nClass'];
				}
				?>
                	<div id="character">
                    	<div id="image">
                        	<img src="bootstrap/img/<?php echo Functions::ClassImage($class); ?>" />
                        </div>
                        <div id="data">
                          <p><strong>Character Name:</strong> <?php echo $name; ?></p>
                          <p><strong>Level:</strong> <?php echo $level; ?></p>
                          <p><strong>Class:</strong> <?php echo Functions::NumToName($class); ?></p>
                          <p><strong>PK Count:</strong> <?php echo $pk;?></p>
                        </div>
                    </div>
                <?php
			}
		}  
    }
?>