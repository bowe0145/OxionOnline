<?php
	#Security
	if( ! defined( 'IN_MALL' ) ) exit;
	
	class mssql
	{
		public $conn = NULL;
		
		private $query = NULL;
		
		private $sql_resource = NULL;
		
		public $query_count = 0;
		
		private $query_parameters = array();
		
		private $Config = NULL;


		//Construct
		public function mssql($start = false ) 
		{
			global $Config;
			
			$this->Config = $Config;
			
			if( ! function_exists('sqlsrv_connect') )
			{
				die('You need the sqlsrv extension');
			}
			
			if( $start === true ) $this->Connect();
		}

		public function Connect()
		{
			//Build the connection array
			$conn_array = array( "UID" => $this->Config['MSSQL_USER'] , "PWD" => $this->Config['MSSQL_PASS'] , "Database" => $this->Config['MSSQL_DB'] );
			
			//Connect or die
			$this->conn = sqlsrv_connect( $this->Config['MSSQL_HOST'] , $conn_array ) or $this->OnDBError();
		}
		
		public function OnDBError()
		{
			//if( $this->Config['DEBUG'] )
			//{
				$k = (array) sqlsrv_errors();
				foreach( $k as $error => $message )
				{
					echo "[$error] " . $message[2] . "<br>" ;
				}
			//}
		}
		
		public function query( $sql , $type = 0 )
		{
			if( $type == 0 )
			{
				$type = array( "Scrollable" => 'forward' );
			}
			elseif( $type == 1 )
			{
				$type = array( "Scrollable" => 'static' );
			}
			elseif( $type == 2 )
			{
				$type = array( "Scrollable" => 'dynamic' );
			}
			elseif( $type == 3 )
			{
				$type = array( "Scrollable" => 'keyset' );
			}   
			elseif( $type == 4 )
			{
				$type = array( "Scrollable" => 'buffered' );
			}               
			
			$this->query = $sql;
			
			$this->sql_resource = sqlsrv_query( $this->conn , $this->query  , array() , $type );
			
			if( ! $this->sql_resource )
			{
				$this->OnDbError();
			}
	   
			$this->query_count++;
		}	
		
		public function fetchResult()
		{
			if( $this->sql_resource )
			{
				sqlsrv_fetch( $this->sql_resource );
				$k = sqlsrv_get_field( $this->sql_resource , 0 );
				$this->Free();
				return $k;
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is nothing to fetch or there was an error with your query. - " , __FUNCTION__ ;
				}
			}
			
			$this->sql_resource = NULL;
		}
		
		public function fetchAssoc()
		{
			if( $this->sql_resource )
			{
				$r = Array();
				$count = 0;
				$stop = false;
				/*$k = sqlsrv_fetch_array( $this->sql_resource );
				$this->Free();
				return $k;*/
				
				while (!$stop)
				{
					$row = sqlsrv_fetch_array($this->sql_resource);
					if ($row === false) die("?");
					$stop = !$row;
					if (!$stop) $r[$count] = $row;
					$count++;
				}
				return $r;
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is nothing to fetch or there was an error with your query. - " , __FUNCTION__ ;
				}
			}
			
			$this->sql_resource = NULL;
		}

		public function fetchObject($silent = false)
		{
			if( $this->sql_resource )
			{
				$k = sqlsrv_fetch_object( $this->sql_resource );
				$this->Free();
				return $k;
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					if (!$silent)
						echo "There is nothing to fetch or an error with your query. - " , __FUNCTION__;
				}
			}
			
			$this->sql_resource = NULL;        
		}
		
		public function prepare( $sql , array $parameters )
		{
			$this->query = $sql;
			
			$this->query_parameters = $parameters;
			
			$arr = array();
			
			foreach( $this->query_parameters as $key => $value )
			{
				
				$arr[$key] = &$this->query_parameters[$key];
			}

			$this->sql_resource = sqlsrv_prepare( $this->conn , $this->query , $arr );
			
			$this->query_count++;
			
			if( ! $this->sql_resource )
			{
				if( $this->Config['DEBUG'] )
				{
					echo "Prepared statement failed, check your query.";
				}
			}
		}	

		public function execute()
		{
			if( $this->sql_resource )
			{
				return sqlsrv_execute( $this->sql_resource );
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is nothing to execute or an error with your prepared statement.";
				}
			}
		}
		
		public function prepareAndFetch( $sql , array $parameters , $type = 0 )
		{
			$this->prepare( $sql , $parameters );
			
			$this->execute();
			
			if( $type == 0 )
			{
				return $this->fetchAssoc();
			}
			elseif( $type == 1 )
			{
				return $this->fetchResult();
			}
			elseif( $type == 2 )
			{
				return $this->fetchObject();
			}
		}
		
		public function prepareAndExecute( $sql , array $parameters , $type = 0 )
		{
			$this->prepare( $sql , $parameters );
			
			$this->execute();
		}	
		
		public function queryAndFetch( $sql , $type = 0 , $pquery = false , $parameters = NULL )
		{
			if( $pquery == false )
			{
				$this->query( $sql );
			}
			else
			{
				$this->pquery( $sql , $parameters );
			}
			
			if( $type == 0 )
			{
				return $this->fetchAssoc();
			}
			elseif( $type == 1 )
			{
				return $this->fetchResult();
			}
			elseif( $type == 2 )
			{
				return $this->fetchObject();
			}
		}
		
		public function NumRows()
		{
			if( $this->sql_resource )
			{
				return sqlsrv_num_rows( $this->sql_resource );
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is no query set or an error with your query. - " , __FUNCTION__;
				}
			}
		}
		
		public function pquery( $sql , array $parameters , $type = 0 )
		{
			if( $type == 1 )
			{
				$type = array( "Scrollable" => 'forward' );
			}
			elseif( $type == 2 )
			{
				$type = array( "Scrollable" => 'static' );
			}
			elseif( $type == 3 )
			{
				$type = array( "Scrollable" => 'dynamic' );
			}
			elseif( $type == 4 )
			{
				$type = array( "Scrollable" => 'keyset' );
			}   
			elseif( $type == 5 )
			{
				$type = array( "Scrollable" => 'buffered' );
			}
			else
			{
				unset( $type );
			}
			
			$this->query = $sql;
			
			if( isset( $type ) )
			{
				$this->sql_resource = sqlsrv_query( $this->conn , $this->query , $parameters , $type );
			}
			else
			{
				$this->sql_resource = sqlsrv_query( $this->conn , $this->query , $parameters );
			}
			
			if( ! $this->sql_resource )
			{
				if( $this->Config['DEBUG'] )
				{
					echo "Query Failed";
				}
			}
			
			$this->query_count++;
		}
		
		public function HasRows()
		{
			if( $this->sql_resource )
			{
				return sqlsrv_has_rows( $this->sql_resource );
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is no query set or an error with your query. - " , __FUNCTION__;
				}
			}       
		}
		
		public function RowsAffected()
		{
			if( $this->sql_resource )
			{
				return sqlsrv_rows_affected( $this->sql_resource );
			}
			else
			{
				if( $this->Config['DEBUG'] )
				{
					echo "There is no query set or an error with your query.";
				}
			}       
		}
		
	  
		public function Free()
		{
			$this->query = NULL;
			
			$this->query_parameters = array();
			
			if( $this->sql_resource )
			{
			   sqlsrv_free_stmt( $this->sql_resource ); 
			}
		}
		
		public function Disconnect()
		{
			( $this->conn == NULL ) ? NULL : sqlsrv_close( $this->conn ); 
		}
		
		public function Escape( $str )
		{
			$str = str_replace( "'", "''", $str );
			return trim( $str );
		}	
	}
?>