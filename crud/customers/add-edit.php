<?php
	session_start();
	require_once('libs/config.inc');
	require_once('libs/connect.inc');
	include_once('libs/common-functions.php');

	//------- start connection -------//
	require_once('libs/start.php');
	//------- start connection -------//

	$id = isset($_GET['id'])? $_GET['id'] : 0;

	$cus_first_name = '';
	$cus_last_name = '';
	$cus_email = '';
	$cus_department = '';
	$cus_status = 1;
	if((int)$id!=0)
	{
		$conds = [':cus_id'=>$id];
		$sql_string = "SELECT * FROM customers WHERE cus_id=:cus_id LIMIT 1 ";
		$results = $zr->resultLists($sql_string,$conds,true);

		if($results['total']!=0)
		{
			$cus_first_name = $results['records'][0]->cus_first_name;
			$cus_last_name = $results['records'][0]->cus_last_name;
			$cus_email = $results['records'][0]->cus_email;
			$cus_department = $results['records'][0]->cus_department;
			$cus_status = $results['records'][0]->cus_status;
		}
	}
	$mode = ((int)$id!=0)? 'edit' : 'add';
	$mode_text = ((int)$id!=0)? 'แก้ไข' : 'เพิ่ม';
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("libs/head.php"); ?>
		<link rel="stylesheet" href="public/css/validationEngine.jquery.css" />
		<link rel="stylesheet" href="public/css/breadcrumb.css" />
		<link rel="stylesheet" href="public/css/master.css" />
		<link rel="stylesheet" href="public/css/customer-style.css" />
		<title><?php echo $mode_text; ?>ข้อมูลลูกค้า</title>
	</head>
	<body>
		<input type="hidden" id="base_url" value="<?php echo HTTP_HOST; ?>" />
		<div class="container">
			<div class="row">
				<ul id="breadcrumb">
					<li><a href="<?php echo HTTP_HOST; ?>">หน้าหลัก</a></li>
					<li><a onclick="Javascript:void(0);"><?php echo $mode_text; ?>ลูกค้า</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-9 col-sm-9 pddt7"><?php echo $mode_text; ?>ลูกค้า</div>							
								<div class="col-md-3 col-sm-3 text-right">
									<a href="<?php echo HTTP_HOST; ?>">
										<span class="btn btn-default back-to-main"><i class="fa fa-angle-double-left"></i>&nbsp;กลับหน้ารายการหลัก</span>
									</a>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<form role="form" id="customer_form">
										<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
										<input type="hidden" name="cus_id" value="<?php echo $id; ?>" />
										<div class="form-group">
											<label for="cus_first_name" class="col-md-2 col-sm-2 pddt5 form-label text-right">First name&nbsp;:</label>
											<div class="col-md-3 col-sm-3">
												<input type="text" class="validate[required,custom[cus_first_name]] form-control" name="cus_first_name" id="cus_first_name" value="<?php echo $cus_first_name; ?>" maxlength="125" />
											</div>
											<label for="cus_last_name" class="col-md-2 col-sm-2  pddt5 form-label text-right">Last name&nbsp;:</label>
											<div class="col-md-3 col-sm-3 ">
												<input type="text" class="validate[required,custom[cus_last_name]] form-control" name="cus_last_name" id="cus_last_name" value="<?php echo $cus_last_name; ?>" maxlength="125" />
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label for="cus_email" class="col-md-2 col-sm-2  pddt5 form-label text-right">Email&nbsp;:</label>
											<div class="col-md-3 col-sm-3 ">
												<input type="text" class="validate[required] form-control" name="cus_email" id="cus_email" value="<?php echo $cus_email; ?>" maxlength="100" />
											</div>
											<label for="cus_department" class="col-md-2 col-sm-2  pddt5 form-label text-right">Department&nbsp;:</label>
											<div class="col-md-3 col-sm-3 ">
												<input class="form-control" name="cus_department" id="cus_department" value="<?php echo $cus_department; ?>" maxlength="100" />
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label for="cus_status" class="col-md-2 col-sm-2 pddt5 form-label text-right">สถานะการใช้งาน&nbsp;:</label>
											<div class="col-md-3 col-sm-3">
												<select class="form-control" name="cus_status" id="cus_status">
													<option value="1" <?php echo (($cus_status==1)? 'selected' : ''); ?>> ใช้งาน </option>
													<option value="0" <?php echo (($cus_status==0)? 'selected' : ''); ?>> ไม่ใช้งาน </option>
												</select>
											</div>
										</div>
										<p>&nbsp;</p>
										<div class="clearfix"></div>
										<div class="col-lg-offset-4 col-lg-8 col-md-offset-4 col-md-8">
											<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
											<a href="<?php echo HTTP_HOST; ?>/master/customer" class="btn btn-danger back-to-main"><i class="fa fa-reply"></i>&nbsp;ยกเลิก</a>
										</div>										
									</form>
								</div>
							</div>
						</div>
						<div class="action-loading display-hide">
							<i class="fa fa-spin fa-circle-o-notch fa-3x text-primary"></i>
							<p class="text-on-load text-primary"> Loading . . .</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			include_once("libs/script-foot.php");
			//------- end connection -------//
			$zr->endConn();
			//------- end connection -------//
		?>
		<script src="<?php echo HTTP_HOST; ?>/public/js/jquery.validationEngine.js"></script>
		<script src="<?php echo HTTP_HOST; ?>/public/js/customer-validation.js"></script>
		<script src="<?php echo HTTP_HOST; ?>/public/js/add-edit-customer.js"></script>
	</body>
</html>
