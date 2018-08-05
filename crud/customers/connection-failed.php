<?php
	require_once('libs/config.inc');
	require_once('libs/connect.inc');
	require_once('libs/start.php');

	if(gettype($pdo_conn)=='object')
	{
		header('Location:'. HTTP_HOST .'/index.php');
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include_once("layout/head.php"); ?>
		<title>Connection Failed!</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="login-panel panel panel-primary">
						<div class="panel-body text-center">
							<h2><i class="fa fa-info-circle"></i>&nbsp;กรุณาตรวจสอบการเชื่อมต่อฐานข้อมูล</h2>
							<a href="<?php echo HTTP_HOST .'/index.php'; ?>" class="btn btn-info"><i class="fa fa-refresh"></i>&nbsp;ลองอีกครั้ง</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
