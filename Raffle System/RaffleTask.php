<?php	
(isset($_SERVER['HTTP_USER_AGENT'])) && die('Error: You are not allowed to access this page.');

	function GetUser($PlayerID) {
		$sql = "SELECT sUsername FROM Raffle WHERE RaffleID = ?";
		$params = array($PlayerID, 0);
		$conn_array = array("Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_array);
		$result = sqlsrv_query($conn, $sql, $params);

		$userName = "";

		while($user = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			$userName = $user['sUsername'];
		}

		return $userName;
	}
	
	function GetRandomNumber() {
		if (GetRaffleEntriesCount() > 0) {
			return rand(1, GetRaffleEntriesCount());
		}
	}
	
	function TruncateRaffle() {
		$conn_array = array("Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_array);
		$sql = "TRUNCATE TABLE Raffle";
		$params = array(0, 0);
		$result = sqlsrv_query($conn, $sql, $params);
	}
	
	function DoesUserExist($user) {
		$conn_array = $conn_Array_Test = array("Database"=>"Account", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_Array_Test);
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$params = array($user, 0);
		$sql = "SELECT sUsername FROM tAccounts WHERE sUsername = ?";
		$result = sqlsrv_query($conn, $sql, $params);
		
		$hasRows = sqlsrv_has_rows($result);
		
		if ($hasRows === true) {
			return true;
		} else {
			return false;
		}
	}

	function GetRaffleEntriesCount() {
		$sql = "SELECT RaffleID FROM Raffle";
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$conn_array = array("Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_array);
		$result = sqlsrv_query($conn, $sql, $params, $options);
		
		$hasRows = sqlsrv_has_rows($result);
		
		if ($hasRows === true) {
			$row_count = sqlsrv_num_rows( $result );
			   
			if ($row_count === false)
			   return 0;
			else
			   return $row_count;
		} else {
			return 0;
		}
	}

	function GetUserIM($user) {
		$sql = "SELECT nAGPoints FROM tAccounts WHERE sUsername = ?";
		$params = array($user, 0);
		$conn_array = array("Database"=>"Account", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_array);
		$result = sqlsrv_query($conn, $sql, $params);

		$userIM = "";

		while($user = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
			$userIM = $user['nAGPoints'];
		}

		return $userIM;
	}
	
	function GetWinningUser() {
		return GetUser(GetRandomNumber());
	}
	
	function AddIMToWinningUser($IMPoints, $user) {
		$userIMPoints = GetUserIM($user);

		$conn_array = $conn_Array_Test = array("Database"=>"Account", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_Array_Test);
		$params = array($IMPoints + $userIMPoints, $user);
		$sql = "UPDATE tAccounts SET nAGPoints = ? WHERE sUsername = ?";
		$result = sqlsrv_query($conn, $sql, $params);
	}
	
	function AddWinnerToLog($user) {
		$conn_array = array("Database"=>"OxionSite", "UID"=>"sa", "PWD"=>"jg9744G9skwZKuy2WxKG");
		$conn = sqlsrv_connect("NS514002\SQLEXPRESS", $conn_array);
		$current_timestamp = date('Y-m-d H:i:s');
		$params = array($user, $current_timestamp);
		$sql = "INSERT INTO RaffleLog(Username, Date) values (?, ?)";
				
		$result = sqlsrv_query($conn, $sql, $params);
	}
	
	function Main() {
		$WinningUser = GetWinningUser();
		if (!empty($WinningUser)) {
			AddIMToWinningUser(0, $WinningUser);
			AddWinnerToLog($WinningUser);
			TruncateRaffle();
		}
	}
	
	Main();

	//"C:\Program Files (x86)\PHP\v5.3\php-cgi.exe" -f "C:\inetpub\wwwroot\Raffle System\RaffleTask.php"
?>