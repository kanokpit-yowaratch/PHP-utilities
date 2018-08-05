<?php
	session_start();
	// include_once('libs/common-functions.php');
	require_once('../libs/connect.php');

	$id = isset($_GET['id'])? $_GET['id'] : 0;

	$cus_first_name = '';
	$cus_last_name = '';
	$cus_dob = '';
	$cus_address = '';
	$cus_email = '';
	$cus_tel = '';
	$cus_status = 1;
	if((int)$id!=0)
	{
		$conds = array(':cus_id'=>$id);
		$sql_string = "SELECT * FROM customers WHERE cus_id=:cus_id LIMIT 1 ";
		$results = $zr->resultLists($sql_string,$conds,true);

		if($results['total']!=0)
		{
			$cus_first_name = $results['records'][0]->cus_first_name;
			$cus_last_name = $results['records'][0]->cus_last_name;
			$cus_dob = $results['records'][0]->cus_dob;
			$cus_address = $results['records'][0]->cus_address;
			$cus_email = $results['records'][0]->cus_email;
			$cus_tel = $results['records'][0]->cus_email;
			$cus_status = $results['records'][0]->cus_status;
		}
	}
	$mode = ((int)$id!=0)? 'edit' : 'add';
	$mode_text = ((int)$id!=0)? 'แก้ไข' : 'เพิ่ม';
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("../layout/header-css.php"); ?>
		<link rel="stylesheet" href="css/form-list.css" />
		<title><?php echo $mode_text; ?>ข้อมูลลูกค้า</title>
	</head>
	<body>
		<input type="hidden" id="base_url" value="<?php echo HTTP_HOST; ?>/crud/customers" />
		<div class="container">
			<div class="row">
				<ul id="breadcrumb">
					<li><a href="<?php echo HTTP_HOST; ?>/crud/customers"><i class="fa fa-home"></i>&nbsp;หน้าหลัก</a></li>
					<li><a onclick="Javascript:void(0);"><i class="fa fa-edit"></i>&nbsp;<?php echo $mode_text; ?>ลูกค้า</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="card bg-light mb-3">
						<div class="card-header">
							<div class="row">
								<div class="col-md-9 col-sm-9 summ-title"><h6><?php echo $mode_text; ?>ลูกค้า</h6></div>							
								<div class="col-md-3 col-sm-3 text-right">
									<a href="<?php echo HTTP_HOST; ?>/crud/customers">
										<span class="btn btn-default back-to-main"><i class="fa fa-angle-double-left"></i>&nbsp;กลับหน้ารายการหลัก</span>
									</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12">
									<form role="form" class="form-inline" id="customer_form">
										<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
										<input type="hidden" name="cus_id" value="<?php echo $id; ?>" />
										<div class="form-group">
											<label for="cus_first_name" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">ชื่อ&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name="cus_first_name" id="cus_first_name" value="<?php echo $cus_first_name; ?>" maxlength="50" />
											</div>
											<label for="cus_last_name" class="col-lg-2 col-md-2 col-sm-2 form-label">นามสกุล&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name="cus_last_name" id="cus_last_name" value="<?php echo $cus_last_name; ?>" maxlength="50" />
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label for="cus_dob" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">ว/ด/ป เกิด&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="date" class="form-control" name="cus_dob" id="cus_dob" value="<?php echo $cus_dob; ?>" maxlength="10" />
											</div>
											<label for="cus_address" class="col-lg-2 col-md-2 col-sm-2">ที่อยู่&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name="cus_address" id="cus_address" value="<?php echo $cus_address; ?>" maxlength="500" />
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label for="cus_email" class="col-lg-2 col-md-2 col-sm-2 col-xs-12">อีเมล์&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name="cus_email" id="cus_email" value="<?php echo $cus_email; ?>" maxlength="50" />
											</div>
											<label for="cus_tel" class="col-lg-2 col-md-2 col-sm-2">เบอร์โทร&nbsp;:</label>
											<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
												<input type="text" class="form-control" name="cus_tel" id="cus_tel" value="<?php echo $cus_tel; ?>" maxlength="50" />
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label for="cus_status" class="col-md-2 col-sm-2 form-label text-right">สถานะการใช้งาน&nbsp;:</label>
											<div class="col-md-3 col-sm-3">
												<select class="form-control" name="cus_status" id="cus_status">
													<option value="1" <?php echo (($cus_status==1)? 'selected' : ''); ?>> ใช้งาน </option>
													<option value="0" <?php echo (($cus_status==0)? 'selected' : ''); ?>> ไม่ใช้งาน </option>
												</select>
											</div>
										</div>
										<div class="clearfix"></div>
										<div class="form-group">
											<label class="col-md-2 col-sm-2 form-label text-right"></label>
											<div class="col-md-3 col-sm-3">
											<button type="submit" class="btn btn-success"><i class="fa fa-save"></i>&nbsp;บันทึก</button>
											<a href="<?php echo HTTP_HOST; ?>/crud/customers" class="btn btn-danger back-to-main"><i class="fa fa-reply"></i>&nbsp;ยกเลิก</a>
											</div>
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
			include_once("../layout/footer-script.php");
			//------- end connection -------//
			$zr->endConn();
			//------- end connection -------//
		?>
		<script src="js/add-edit-customer.js"></script>
	</body>
</html>
