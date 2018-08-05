$(function() {
	$('.btn-info').click(function(){
		var id = $(this).attr('id');
		var cus_id = id.split('_')[1];
		if(cus_id!=0)
		{
			$.ajax({
				url: $('#base_url').val() +'/ajax.php',
				type: 'POST',
				data: {'mode':'view','cus_id':cus_id},
				beforeSend: function(){
					$('.action-loading').show();
					$('.action-loading').css('z-index',1050);
					$('.modal').css('z-index',1040);
				},
				dataType: 'HTML',
				success: function(response){
					$('.action-loading').hide();
					$('.modal').css('z-index',1050);
					$('#view_content').html(response);
				}
			});
		}
	});
	$('.btn-del').click(function(){
		var id = $(this).attr('id');
		var cus_id = id.split('_')[1];
		var cus_status = id.split('_')[2];
		var txt_del_mode = (cus_status==1)? 'ท่านต้องการลบข้อมูลนี้หรือไม่?' : 'ท่านต้องการเปิดใช้งานรายการนี้หรือไม่?';
		$('#txt_del_mode').html(txt_del_mode);
		// console.log(cus_id);
		$('#confirm_btn').click(function(){
			$.ajax({
				url: $('#base_url').val() +'/ajax.php',
				type: 'POST',
				data: {'mode':'delete','cus_id':cus_id,'cus_status':cus_status},
				beforeSend: function(){
					$('.action-loading').show();
					$('.action-loading').css('z-index',1050);
					$('.modal').css('z-index',1040);
				},
				dataType: 'json',
				success: function(response){
					$('.action-loading').hide();
					if(response.ret_status!=0)
					{
						saveSuccess();
						setTimeout(function(){
							window.location='index.php';
						}, 2000);
					} else {
						$('.modal').css('z-index',1050);
						showWarning('เกิดความผิดพลาดในระบบ กรุณาตรวจสอบอีกครั้ง','Warning!');
					}
				}
			});
		});
	});
});
