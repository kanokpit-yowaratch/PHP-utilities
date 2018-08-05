<?php
	session_start();
	require_once('libs/config.inc');
	require_once('libs/connect.inc');

	//------- start connection -------//
	require_once('libs/start.php');
	//------- start connection -------//

	$mode = isset($_POST['mode'])? $_POST['mode'] : 'add';
	if($mode=='add')
	{
		$cus_first_name = isset($_POST['cus_first_name'])? $_POST['cus_first_name'] : '';
		$cus_last_name = isset($_POST['cus_last_name'])? $_POST['cus_last_name'] : '';
		$cus_email = isset($_POST['cus_email'])? $_POST['cus_email'] : '';
		$cus_department = isset($_POST['cus_department'])? $_POST['cus_department'] : '';
		$cus_status = isset($_POST['cus_status'])? $_POST['cus_status'] : 1;

		// insert
		$conditions = [':cus_first_name'=>trim($cus_first_name)
						,':cus_last_name'=>trim($cus_last_name)
						,':cus_email'=>trim($cus_email)
						,':cus_department'=>trim($cus_department)
						,':cus_status'=>(int)$cus_status
					];
		$sql_string = "INSERT INTO customers ";
		$sql_string .= " (cus_first_name,cus_last_name,cus_email,cus_department,cus_status) ";
		$sql_string .= " VALUES ";
		$sql_string .= " (:cus_first_name,:cus_last_name,:cus_email,:cus_department,:cus_status) ";
		$results = $zr->dbInsert($sql_string,$conditions); // ['total'=>$total, 'lastInsertId'=>$lastInsertId, 'error_msg'=>$error_msg]
		$lastInsertId = $results['lastInsertId'];
		echo json_encode(['total'=>$results['total'],'last_id'=>$lastInsertId]);
	}
	else if($mode=='edit')
	{
		$cus_id = isset($_POST['cus_id'])? $_POST['cus_id'] : 0;
		$cus_first_name = isset($_POST['cus_first_name'])? $_POST['cus_first_name'] : '';
		$cus_last_name = isset($_POST['cus_last_name'])? $_POST['cus_last_name'] : '';
		$cus_email = isset($_POST['cus_email'])? $_POST['cus_email'] : '';
		$cus_department = isset($_POST['cus_department'])? $_POST['cus_department'] : '';
		$cus_status = isset($_POST['cus_status'])? $_POST['cus_status'] : 1;

		// update
		$conditions = [':cus_first_name'=>trim($cus_first_name)
						,':cus_last_name'=>trim($cus_last_name)
						,':cus_email'=>trim($cus_email)
						,':cus_department'=>trim($cus_department)
						,':cus_status'=>(int)$cus_status
						,':cus_id'=>(int)$cus_id
					];
		$sql_string = "UPDATE customers ";
		$sql_string .= " SET cus_first_name=:cus_first_name ";
		$sql_string .= 		",cus_last_name=:cus_last_name ";
		$sql_string .= 		",cus_email=:cus_email ";
		$sql_string .= 		",cus_department=:cus_department ";
		$sql_string .= 		",cus_status=:cus_status ";
		$sql_string .= " WHERE cus_id=:cus_id ";
		$results = $zr->dbupdate($sql_string,$conditions); // ['total'=>$total, 'error_msg'=>$error_msg]
		echo json_encode(['total'=>$results['total']]);
	}
	else if($mode=='delete')
	{
		$cus_id = isset($_POST['cus_id'])? $_POST['cus_id'] : 0;
		$curr_status = isset($_POST['cus_status'])? (int)$_POST['cus_status'] : 0;
		$cus_status = ($curr_status==0)? 1 : 0;

		// change status
		$conditions = [':cus_status'=>$cus_status,':cus_id'=>(int)$cus_id];
		$sql_string = "UPDATE customers ";
		$sql_string .= " SET cus_status=:cus_status ";
		$sql_string .= " WHERE cus_id=:cus_id ";
		$results = $zr->dbupdate($sql_string,$conditions); // ['total'=>$total, 'error_msg'=>$error_msg]
		echo json_encode(['ret_status'=>$results['total']]);
	}

	$zr->endConn();
	exit;
?>