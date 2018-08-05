<?php
	class Zero {
		public $conn	= null;
		private $host	= HOST;
		private $user	= USER;
		private $pw		= PASSWORD;
		private $db		= DATABASE;

		public function startConn() {
			try {
				$this->conn = new PDO("mysql:host=". $this->host .";dbname=". $this->db, $this->user, $this->pw);
				return $this->conn;
			} catch (PDOException $ex){
				return $ex->getMessage();
			}
		}

		public function resultLists($sql_string='', $conditions='', $return_object=true) {
			$total = 0;
			$records = array();
			$error_msg = '';
			$result = null;

		   try {
				$query = $this->conn->prepare($sql_string);
			} catch( PDOException $e ) {
				echo 'Error prepare: '. $sql_string .', '. $e->getMessage();
			}

			if( empty( $conditions ) )
				$result = $query->execute();
			else
				$result = $query->execute( $conditions );

			if($result)
			{
				$total = $query->rowCount();
				if($total > 0)
				{
					if($return_object==true)
						$records = $query->fetchAll(PDO::FETCH_OBJ);
					else
						$records = $query->fetchAll(PDO::FETCH_ASSOC);
				}
			} else {
				$error_msg =  $query->errorInfo();
			}

			unset($query);
			return ['total'=>$total, 'records'=>$records, 'error_msg'=>$error_msg];
		}

		public function dbInsert($sql_string='', $conditions='') {
			$error_msg = '';
			$lastInsertId = 0;
			$result = null;

			try {
				$query = $this->conn->prepare($sql_string);
			} catch( PDOException $e ) {
				echo 'Error prepare: '. $sql_string .', '. $e->getMessage();
			}

			if( empty( $conditions ) )
				$result = $query->execute();
			else
				$result = $query->execute( $conditions );

			if( $result )
			{
				$total = $query->rowCount();
				$lastInsertId = $this->conn->lastInsertId();
			} else {
				$error_msg =  $query->errorInfo();
			}

			unset($query);
			return ['total'=>$total, 'lastInsertId'=>$lastInsertId, 'error_msg'=>$error_msg];
		}

		public function dbupdate($sql_string='', $conditions='') {
			$error_msg = '';
			$result = null;

			try {
				$query = $this->conn->prepare($sql_string);
			} catch( PDOException $e ) {
				echo 'Error prepare: '. $sql_string .', '. $e->getMessage();
			}

			if( empty( $conditions ) )
				$result = $query->execute();
			else
				$result = $query->execute( $conditions );
			
			if( $result )
				$total = $query->rowCount();
			else
				$error_msg = $query->errorInfo();

			unset($query);
			return ['total'=>$total, 'error_msg'=>$error_msg];
		}

		public function endConn() {
			if($this->conn != null)
			{
				$this->conn = null;
			}
		}
	}
?>