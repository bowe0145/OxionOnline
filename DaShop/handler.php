<?php

	#Security
	define( 'IN_MALL' , 0 );

	error_reporting(0);

	#Include config
	require_once( './config.php' );

	#Include bootstrap
	require_once( './bootstrap.php' );

	#TEST
	if(isset ( $_GET['qsrv'] ) )
	{

	}

	#Logged In
	if( isset( $_SESSION['userName'] ) )
	{
		#Lel
		if( $_SESSION['logIP'] != $_SERVER['REMOTE_ADDR'] )
		{
			session_destroy();

			exit;
		}

		#Trying to buy
		if( isset( $_POST['buy'] ) )
		{
			$Item = mysql_escape_string($_POST['buy']);

			#Numbers only
			if( preg_match( '/^[0-9][0-9]*$/' , $Item ) == 1 )
			{
				#Get Info
				$ItemInfo = Functions::GetItemInfo( $Item );

				#Item doesn't exist
				if( count( $ItemInfo ) == 0 )
				{
					Functions::Error( 'Invalid item' );
				}

				#Fucking nest
				$ItemInfo = $ItemInfo[0];

				#Get user points
				$Points = Functions::GetUserPoints( mysql_escape_string($_SESSION['nEMID']) );

				#Failed to get user points
				if( count( $Points ) == 0 )
				{
					Functions::Error( 'Server error' );
				}

				#Fucking nest
				$Points = $Points[0]['nAGPoints'];

				#Enough points?
				if( $ItemInfo['nPrice'] > $Points )
				{
					Functions::Error( 'You do not have enough points' );
				}

				#Deduct points
				Functions::SubtractPoints( mysql_escape_string($_SESSION['nEMID']) , $ItemInfo['nPrice'] );

				#Give item
				Functions::AddItem( mysql_escape_string($_SESSION['nEMID']) , $ItemInfo );
				Functions::AddTotal( $ItemInfo );
				Functions::Error( 'Item has been bought, it can be found in your purchased inventory, this is the second present box.' );
			}
			else
			{
				Functions::Error( "You selected an invalid item." );
			}

		}
		#Coins
		else if( isset( $_GET['coins'] ) )
		{
			$Coins = functions::GetUserPoints( mysql_escape_string($_SESSION['nEMID']) );

			$Coins = $Coins[0]['nAGPoints'];

			echo $Coins;
		}
		#Specific category
		else if( isset( $_GET['cat'] ) )
		{
			$Cat = mysql_escape_string($_GET['cat']);

			#Valid sub-category?
			#Sub-Cats are number indexed
			if( preg_match( '/^[0-9][0-9]*$/' , $Cat ) == 1 )
			{
				$Results = Functions::GetCat( $Cat );

				#Category is real
				if( count( $Results ) > 0 )
				{
					$Results = $Results[0]['nCat'];

					$Items = Functions::GetItemsByCat( $Results );

					#No items in category
					if( count( $Items ) > 0 )
					{
						echo '<ul class="thumbnails">';

						foreach( $Items as $Key => $Info )
						{
							$Info = (object) $Info;

							functions::PrintItem( $Info );
						}

						echo '</ul>';
					}
					else
					{
						Functions::Error( 'Category has not been filled yet :(.' , true );
					}
				}
				else
				{
					Functions::Error( 'It seems there was a error. You will be redirected to the main page.' , true );

					Functions::Redirect( 'index.php' );
				}
			}
			else if( $Cat == -1 )
			{

				$id = htmlentities( $_SESSION['nEMID'] );
echo '</div>';
			}
			else
			{
				Functions::Error( "Invalid category" , true );
			}
		}
		#Tried to log out?
		else if( isset( $_GET['logout'] ) )
		{
			Functions::LogOut();

			Functions::Redirect( 'index.php' );
		}
		#Default
		else
		{
			$Coins = functions::GetUserPoints( $_SESSION['nEMID'] );

			$Coins = $Coins[0]['nAGPoints'];

			echo '<div class="navbar">
					<div class="navbar-inner">
						<ul class="nav">';

			$i = Functions::PrintCategories();

			echo '<li><a id="coins_lbl" href="#" onclick="updateCoins(); return false;">' . sprintf( "Oxion Credit:<b style=\"color:red;\">%s</b>" , htmlentities( $Coins ) ) . '</a></li>';

			echo '</ul><div class="btn-group" style="float:right;">
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				Options
				<span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu">
			  <li><a href="#">' . sprintf( "Logged in as, <b style=\"color:blue;\">%s</b>" , htmlentities( $_SESSION['userName'] ) ) . '</a></li>
			  <li id="lbl_-1"><a href="http://buy.evictionstudios.com"><img src="./Template/img/dollar.png" alt="" /> Buy Points</a></li>
                          <li><a href="#" href="#" onclick="Logout(); return false;">' . sprintf( "<b style=\"color:red;\">Logout</b>" ) . '</a></li>
			  <s/ul>
			</div>';

			echo '</div></div>';

			if( $i == 0 )
			{
				Functions::Error( "There are no mall items yet!" , true );
			}
			else
			{
				echo '<script>$("#main").html(\'<div class="alert alert-info">Welcome to the Oxion Online store!<button type="button" class="close" data-dismiss="alert">&times;</button></div>\');</script>';
			}
		}
	}
	#Not logged in
	else
	{
		#Tried to log in?
		if( isset( $_POST['username'] ) && isset( $_POST['password'] ) )
		{
			$Username = mysql_escape_string($_POST['username']);

			$Password = mysql_escape_string($_POST['password']);

			#Validate input
			if( strlen( $Username ) < 3 || strlen( $Username ) > 15 || preg_match( '/[^a-zA-Z0-9]/' , $Username ) > 0 )
			{
				Functions::Error( '3' );
			}
			elseif( strlen( $Password ) < 5 || strlen( $Password ) > 20 )
			{
				Functions::Error( '2' );
			}

			#Hash password
			$Password = Functions::MakePw( $Username , $Password );

			#User didn't exist
			if( $Password == null )
			{
				Functions::Error( '1' );
			}

			#Validate login
			$Results = Functions::LoginValidate( $Username , $Password );

			if( count( $Results ) > 0 )
			{
				$Results = $Results[0];

				Functions::SetLogin( $Results );

				Functions::Error( '4' );
			}
			#Invalid
			else
			{
				Functions::Error( '1' );
			}
		}
		#Nada
		else
		{
			Functions::LoggedOut();
		}
	}
?>
