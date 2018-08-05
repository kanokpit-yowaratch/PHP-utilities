<?php
	session_start();
	require_once('../libs/connect.php');
	if(gettype($pdo_conn)!='object') {
		header('Location:'. HTTP_HOST .'/connection-failed.php');
		exit;
	}

	$sql_string = "SELECT * FROM customers ";
	$results = $zr->resultLists($sql_string,'',true); // true=object,false=array
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("../layout/header-css.php"); ?>
		<!-- <link rel="stylesheet" href="public/css/master.css" /> -->
		<!-- <link rel="stylesheet" href="public/css/customer-style.css" />-->
		<title>ข้อมูลลูกค้า</title>
	</head>
	<body class="crud">
		<input type="hidden" id="base_url" value="<?php echo HTTP_HOST; ?>" />
		<div class="container">
			<div class="row">
				<ul id="breadcrumb">
					<li><a href="<?php echo HTTP_HOST; ?>"><span class="icon icon-home"></span>หน้าหลัก</a></li>
					<li><a onclick="Javascript:void(0);"><span class="icon icon-double-angle-right"></span>ข้อมูลลูกค้า</a></li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">ข้อมูลลูกค้า</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-9 col-sm-9 pddt7">รายการลูกค้าทั้งหมด <?php echo $results['total']; ?> รายการ</div>
								<div class="col-md-3 col-sm-3 text-right">
									<a href="<?php echo HTTP_HOST; ?>/add-edit.php">
										<span class="btn btn-success"><i class="fa fa-plus"></i>&nbsp;เพิ่มข้อมูล</span>
									</a>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="table-responsive">
										<table class="table table-striped table-condensed table-bordered table-hover">
											<thead>
												<tr>
													<th class="text-center">Item</th>
													<th class="text-center">Name</th>
													<th class="text-center">Status</th>
													<th class="text-center">Email</th>
													<th class="text-center">Department</th>
													<th class="text-center">Manage</th>
												</tr>
											</thead>
											<tbody id="tbody_customer_list">
												<?php
													if($results['total']!=0)
													{
														foreach($results['records'] as $k=>$val){
															$full_name = trim($val->cus_first_name .' '. $val->cus_last_name);
															$stt_class = ($val->cus_status==1)? 'danger' : 'primary';
															$stt_icon = ($val->cus_status==1)? 'close' : 'refresh';
															$stt_txt = ($val->cus_status==1)? '<label class="label label-success">ใช้งาน</label>' : '<label class="label label-danger">ไม่ใช้งาน</label>';
												?>
															<tr>
																<td class="text-center"><?php echo ($k+1); ?></td>
																<td class="text-center"><?php echo $full_name; ?></td>
																<td class="text-center"><?php echo $stt_txt; ?></td>
																<td class="text-center"><?php echo $val->cus_email; ?></td>
																<td class="text-center"><?php echo $val->cus_department; ?></td>
																<td class="text-center">
																	<a class="btn btn-warning" href="add-edit.php?id=<?php echo $val->cus_id; ?>"><i class="fa fa-pencil"></i>&nbsp;</a>
																	<button type="button" class="btn btn-sm btn-<?php echo $stt_class; ?> btn-del" id="delete_<?php echo $val->cus_id; ?>_<?php echo $val->cus_status; ?>" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-<?php echo $stt_icon; ?>"></i>&nbsp;</button>
																</td>
															</tr>
												<?php
														}
													} else {
												?>
														<tr>
															<td colspan="6" class="text-center">--- ไม่พบข้อมูล ---</td>
														</tr>
												<?php
													}
												?>
											</tbody>
										</table>
									</div>
									<div id="delete_modal" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
										<div class="modal-dialog modal-md">
											<div class="modal-content">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">×</span>
														</button>
														<h4 class="modal-title" id="mySmallModalLabel">Confirm&nbsp;?</h4>
													</div>
													<div class="modal-body">
														<div id="txt_del_mode"></div>
													</div>
													<div class="modal-footer">
														<button class="btn btn-primary" id="confirm_btn"><i class="fa fa-check"></i>&nbsp;ใช่</button>
														<button class="btn btn-md btn-danger" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i>&nbsp;ยกเลิก</button>
													</div>
												</div>
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
				</div>
			</div>
		</div>
		<?php
			include_once("../layout/footer-script.php");
			//------- end connection -------//
			$zr->endConn();
			//------- end connection -------//
		?>
		<script src="<?php echo HTTP_HOST; ?>/crud/customers/js/customer-list.js"></script>
	</body>
</html>
