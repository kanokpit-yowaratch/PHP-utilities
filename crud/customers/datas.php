<?php
	error_reporting(E_ALL);
	ini_set('display_errors','On');
	session_start();

	if(!empty($_SESSION['login_username']))
	{
		require_once('../../libs/config.inc');
		require_once('../../libs/connect.inc');
		include_once('../../libs/common-functions.php');
		include_once('functions.php');

		//------- start connection -------//
		require_once('../../libs/start.php');
		//------- start connection -------//

		// ----- set environment ----- //
		$table = 'stocks';
		$primaryKey = 'stock_id';
		$columns = ['stock_id','stock_date','truck_id','cab1','cab2','cab3','cab4','cab5','cab6','stock_status','options'];

		// ----- start query ----- //
		$order = " ORDER BY stock_date DESC ";
		$limit = ' LIMIT 0, 10 ';
		$where = " WHERE stock_type=1 ";

		$where .= " AND stock_status<>2 ";

		$stock_date = isset($_POST['stock_date'])? trim($_POST['stock_date']) : '';
		$truck_id = isset($_POST['truck_id'])? (int)$_POST['truck_id'] : 0;

		if($stock_date)
		{
			$date_query = formToSqlDate(convertDateFormat($stock_date,'-'));
			$where .= " AND ". $columns[1] ."='". $date_query ."' ";
		}
		if((int)$truck_id!=0)
		{
			$where .= " AND ". $columns[3] ."='". (int)$truck_id ."' ";
		}
		if( isset($_POST['order']) && count($_POST['order']) )
			$order = ' ORDER BY '. $columns[$_POST['order'][0]['column']] .' '. $_POST['order'][0]['dir'];
		if(isset($_POST['start']) && $_POST['length'] != -1 )
			$limit = "LIMIT ". (int)$_POST['start'] .", ". (int)$_POST['length'];

		$order .= ' , created_at DESC ';

		$sql_string = "SELECT `stock_id`,`stock_date`,`truck_id`,`created_at`,`stock_status`,`stock_status` ";
		$sql_string .= " FROM `$table` ";
		$sql_string .= " $where $order ";
		$sql_limit = " $limit ";
		$result_tt = $zr->resultLists($sql_string,'',true);
		$recordsTotal = $result_tt['total'];

		$results = $zr->resultLists($sql_string . $sql_limit,'',false);
		$ret_data = [];
		for($i=0,$ien=$results['total'];$i<$ien;$i++){
			$row = array();
			for($j=0,$jen=count($columns);$j<$jen;$j++){
				$column = $columns[$j];
				$stock_id = $results['records'][$i]['stock_id'];
				$oil_cab = oilCabinet($zr,$stock_id);
				$val = '';
				if($column=='stock_id')
				{
					// $val = ($_POST['start'] + $i + 1);
					$val = $stock_id;
				}
				else if($column=='stock_date')
				{
					$val = showDate($results['records'][$i]['stock_date']);
					$val = ($val)? $val : '-';
				}
				else if($column=='truck_id')
				{
					$truck_no = oneField($zr,'truck_no','trucks','truck_id',$results['records'][$i]['truck_id']);
					$val = (trim($truck_no))? $truck_no : '-';
				}
				else if($column=='cab1')
				{
					$val = $oil_cab[0][0] .'<br />'. $oil_cab[0][1];
				}
				else if($column=='cab2')
				{
					$val = $oil_cab[1][0] .'<br />'. $oil_cab[1][1];
				}
				else if($column=='cab3')
				{
					$val = $oil_cab[2][0] .'<br />'. $oil_cab[2][1];
				}
				else if($column=='cab4')
				{
					$val = $oil_cab[3][0] .'<br />'. $oil_cab[3][1];
				}
				else if($column=='cab5')
				{
					$val = $oil_cab[4][0] .'<br />'. $oil_cab[4][1];
				}
				else if($column=='cab6')
				{
					$val = $oil_cab[5][0] .'<br />'. $oil_cab[5][1];
				}
				else if($column=='stock_status')
				{
					$val = $results['records'][$i]['stock_status'];
					$stock_status =  $results['records'][$i]['stock_status'];
					if($stock_status==0)
						$val = '<span class="status-nonactive">ไม่ใช้งาน</span></span>';
					else if($stock_status==1)
						$val = '<span class="status-active">ใช้งาน</span>';
					else if($stock_status==2)
						$val = '<span class="status-closed">จำหน่าย</span>';
				}
				else if($column=='options')
				{
					$val = '';
					$stt_icon = ($results['records'][$i]['stock_status']==1)? 'trash-o' : 'refresh';
					$stt_bg = ($results['records'][$i]['stock_status']==1)? 'danger' : 'primary';
					$del_title = ($results['records'][$i]['stock_status']==1)? 'ลบสต๊อก' : 'เรียกคืนรายการ';
					if($results['records'][$i]['stock_status']==1)
						$val .= '<a class="btn btn-lg btn-primary btn-circle custom tooltips" href="process.php?stock_id='. $stock_id .'" title="ขายน้ำมัน / ถ่ายน้ำมัน"><i class="fa fa-paper-plane"></i>&nbsp;</a>';
					$val .= '<button type="button" class="btn btn-info btn-view btn-circle btn-lg custom tooltips" id="view_'. $stock_id .'" data-toggle="modal" data-target="#view_modal" title="แสดงรายละเอียด"><i class="fa fa-list-alt"></i></button>';
					if($results['records'][$i]['stock_status']!=0)
						$val .= '<a href="'. HTTP_HOST .'/process/stock/add-edit.php?stock_id='. $stock_id .'" class="btn btn-warning btn-circle btn-lg tooltips" id="edit_'. $stock_id .'" title="แก้ไขสต๊อก"><i class="fa fa-pencil"></i></a>';
					if($results['records'][$i]['stock_status']!=2)
						$val .= '<button type="button" class="btn btn-'. $stt_bg .' btn-del btn-circle btn-lg tooltips" id="delete_'. $stock_id .'_'. $results['records'][$i]['stock_status'] .'" data-toggle="modal" data-target="#delete_modal" title="'. $del_title .'"><i class="fa fa-'. $stt_icon .'"></i></button>';
				}
				$row[] = $val;
			}
			$ret_data[] = $row;
		}
		echo json_encode([
							"draw"				=> ((int)$_POST['draw']) ? (int)$_POST['draw'] : 0,
							"recordsTotal"    	=> (int)$recordsTotal,
							"recordsFiltered" 	=> (int)$recordsTotal,
							"data"            	=> $ret_data
						]);
	} else {
		echo json_encode([
							"draw"				=> 0,
							"recordsTotal"    	=> 0,
							"recordsFiltered" 	=> 0,
							"data"            	=> []
						]);
	}
?>
