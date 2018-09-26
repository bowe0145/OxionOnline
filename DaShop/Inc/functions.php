<?php
	#Direct Access
	if( ! defined( 'IN_MALL' ) ) exit;
	
	class Functions
	{
		public static function LoggedOut()
		{
			echo <<< EOL
            <div id="login" class="well well-small">
			<form method="post" action="#" onsubmit="Login(); return false;" id="form">
				<label>Username</label><br />
				<input type="text" id="username "name="username" autocomplete="off" class="linput" /><br />
				<label>Password</label><br />
				<input type="password" id="password" name="password" class="linput" /><br />
				<button class="btn">Log in</button/>
			</form>
            </div>
EOL;
		}
		
		public static function LoginValidate( $Username , $Password )
		{
			global $Database;
			
			return $Database->prepareAndFetch( "SELECT * FROM tAccounts WHERE sUserName = ? AND sUserPass = ?" , array( $Username , $Password ) );
		}
		
		public static function MakePw( $Username , $Password )
		{
			/*$Salt = self::GetUserSalt( $Username );
			
			if( $Salt == null )
			{
				return null;
			}*/
		
			return $Password;
		}
		
		public static function SetLogin( $Results )
		{		
			$_SESSION['nEMID'] = $Results['nEMID'];
			
			$_SESSION['userName'] = $Results['sUsername'];
						
			$_SESSION['logIP'] = self::GetIp();
		}
		
		public static function GetUserSalt( $Username )
		{
			global $Database;
		
			return $Database->prepareAndFetch( "SELECT sUserPassSalt FROM tAccounts WHERE sUserName = ?" , array( $Username ) );
		}
		
		public static function LogOut()
		{
			session_destroy();
		}
		
		public static function Redirect( $Url )
		{
			header( 'Location:' . $Url );
		}
		
		public static function GetItemInfo( $Id )
		{
			global $Database;
	
			return $Database->prepareAndFetch( "SELECT * FROM ItemMall.dbo.tItems WHERE nGoodsNo = ? AND nEnabled = 1" , array( $Id ) );
		}
		
		public static function GetUserPoints( $Id )
		{
			global $Database;
	
			return $Database->prepareAndFetch( "SELECT nAGPoints FROM tAccounts WHERE nEMID = ?" , array( $Id ) );	
		}
		
		public static function SubtractPoints( $Id , $Amount )
		{
			global $Database;
	
			$Database->prepareAndExecute( "UPDATE tAccounts SET nAGPoints = ( nAGPoints - ? ) WHERE nEMID = ?" , array( $Amount , $Id ) );			
		}

		public static function AddPoints( $Id , $Amount )
		{
			global $Database;
	
			$Database->prepareAndExecute( "UPDATE tAccounts SET nAGPoints = ( nAGPoints + ? ) WHERE nEMID = ?" , array( $Amount , $Id ) );			
		}

		public static function AddLog( $Id , $Email, $Trans, $Amount, $Reward )
		{
			global $Database;
	
			$Database->prepareAndExecute( "INSERT INTO ItemMall.dbo.tLog(sUsername, sEmail, sTrans, sAmount, sReward) VALUES((SELECT TOP 1 sUsername FROM tAccounts WHERE nEMID = ?), ?, ?, ?, ?)" , array( $Id, $Email, $Trans, $Amount, $Reward ) );
		}
		
		public static function AddItem( $UserId , $ItemInfo )
		{
			global $Database;
			
			$Sql = "INSERT INTO tPurchases([nAGID],[nPrice],[nGoodsNo],[nQuantity],[nUsed],[sIP], [nIsGift],[nStatus] )
					VALUES(? , ?,?,1,0,?,0,0)";
					
			$Params = array( $UserId , $ItemInfo['nPrice'] , $ItemInfo['nGoodsNo'] , self::GetIp() );
			
			$Database->prepareAndExecute( $Sql , $Params );
		}

		public static function AddTotal( $ItemInfo )
		{
			global $Database;

			$Database->prepareAndExecute( "UPDATE ItemMall.dbo.tItems SET nTotal = ( nTotal + 1 ) WHERE nGoodsNo = ?" , array( $ItemInfo['nGoodsNo'] ) );
		}
		
		public static function GetIp()
		{
			return $_SERVER['REMOTE_ADDR'];
		}
		
		public static function Error( $Message , $Div = false )
		{
			if( $Div === true )
			{
				echo <<< EOL
				<div class="alert alert-error">
					{$Message}<!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
				</div>
EOL;
				exit;
			}
		
			echo <<< EOL
			{$Message}
EOL;
			exit;
		}
		
		public static function PrintCategories()
		{
			global $Database;
			
			$i = 0;
			
			$Results = $Database->queryAndFetch("SELECT * FROM ItemMall.dbo.tCats WHERE nEnabled = 1");
			
			foreach( $Results as $Key => $Info )
			{
				$Info = (object) $Info;
			
				echo <<< EOL
				<li id="lbl_{$Info->nCat}"><a href="#" onclick="loadCat({$Info->nCat}); return false;">{$Info->sName}</a></li>
EOL;
				$i++;
			}

			return $i;
		}
		
		public static function GetCat( $Id )
		{
			global $Database;
			
			return $Database->prepareAndFetch("SELECT nCat FROM ItemMall.dbo.tCats WHERE nEnabled = 1 AND nCat = ?" , array( $Id ) );
		}
		
		public static function GetItemsByCat( $Id )
		{
			global $Database;
			
			return $Database->prepareAndFetch( "SELECT * FROM ItemMall.dbo.tItems WHERE nCat = ? AND nEnabled = 1" , array( $Id ) );
		}
		
		public static function PrintItem( $Info )
		{
			$Unique = md5( $Info->nID );

						echo <<< EOL
  <li>
    <div class="thumbnail" style="width:166px; background-color:white; text-align:center;">
      <img src="./Template/img/{$Info->sImg}" alt="{$Info->sDescript}">
	  <h4>{$Info->sName}</h4>
	  <button onclick="buyItem({$Info->nGoodsNo})" class="btn btn-primary">Buy</button>
	  <button class="btn" title="{$Info->sDescript}" onclick="displayDesc('{$Unique}');">Details</button>
    </div>
	<div id="{$Unique}" class="desc well well-small">
		<span class="desc_lbl">Total Bought:</span> {$Info->nTotal}<br />	
		<span class="desc_lbl">Permanent:</span> {$Info->sPerm}<br />	
		<span class="desc_lbl">Price:</span> {$Info->nPrice}<br />
		<span class="desc_lbl">Class:</span> {$Info->sClass}<br />
		<span class="desc_lbl">Details:</span> {$Info->sDescript}
	  </div>
  </li>
EOL;
		
		}
		
		public static function BanUser( $Id )
		{
			global $Database;
			
			$Database->prepareAndExecute("UPDATE tAccounts SET sUserPass = ? WHERE nEMID = ?" , array( 'BannedForChargeback' , $Id ) );
		}
		
		public static function AddDonationLog( $User , $Amount , $Type , $Comment = null )
		{	
			global $Database;
		
			switch( $Comment )
			{
				case 1:
					$Comment = 'Chargeback';
				break;
				
				case 2:
					$Comment = 'Credit Card fraud';
				break;
				
				case 3:
					$Comment = 'Order fraud';
				break;

				case 4:
					$Comment = 'Bad data entry';
				break;

				case 5:
					$Comment = 'Fake / proxy user';
				break;

				case 6:
					$Comment = 'Rejected by advertiser';
				break;

				case 7:
					$Comment = 'Duplicate conversions';
				break;

				case 8:
					$Comment = 'Goodwill credit taken back';
				break;	

				case 9:
					$Comment = 'Cancelled order';
				break;

				case 10:
					$Comment = 'Partially reversed transaction';
				break;				
			}	
			
			$Query = "INSERT INTO ItemMall.dbo.donations([type],[user],[amount],[comment],[date]) VALUES(?,?,?,?, CURRENT_TIMESTAMP);";
			
			$Params = array( $Type , $User , $Amount , $Comment );
			
			$Database->prepareAndExecute( $Query , $Params );
		}	
	}
?>