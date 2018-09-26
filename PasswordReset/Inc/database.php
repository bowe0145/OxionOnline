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
        
        function ValidateCredentials($username, $email){

            $sql = "SELECT * FROM tAccounts WHERE sUsername = ? AND sEmail = ?";
            $param = array($username, $email);
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
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"sRulfJGoQHqpbx0eQFNC");
            $testcon = sqlsrv_connect("NS505048\OXION", $connection_array);
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
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"sRulfJGoQHqpbx0eQFNC");
            $testcon = sqlsrv_connect("NS505048\OXION", $connection_array);
			$sql = "SELECT TOP 10 * FROM tCharacter WHERE bDeleted = ? AND nAdminlevel = ? ORDER BY nPlayMin DESC";
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

		function Top100P(){
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"sRulfJGoQHqpbx0eQFNC");
            $testcon = sqlsrv_connect("NS505048\OXION", $connection_array);
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
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"sRulfJGoQHqpbx0eQFNC");
            $testcon = sqlsrv_connect("NS505048\OXION", $connection_array);
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

		function ChangePassword($username, $oldPassword, $newPassword){
			
			$compare = $this->Credentials($username, "sUserPass");
			
			if($compare != $oldPassword) {
				return 1;	
			}
			else {
				
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
            $connection_array = array( "Database"=>"W0_Character", "UID"=>"sa", "PWD"=>"sRulfJGoQHqpbx0eQFNC");
            $testcon = sqlsrv_connect("NS505048\OXION", $connection_array);
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