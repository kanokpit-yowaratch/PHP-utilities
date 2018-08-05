$(function(){
	// $('#customer_form').validationEngine({promptPosition : "topRight", scroll: false, arrow:true});
	// $('#customer_form').on('submit',(function(e){
	// 	if($('#customer_form').validationEngine('validate'))
	// 		submitForm(this);
	// 	return false;
	// }));
});
function submitForm(this_form){
	var formData = new FormData(this_form);
	// formData.append('some_ele', $('#some_ele').val());
	$.ajax({
		url: $('#base_url').val() +'/ajax.php',
		type: 'POST',
		data: formData,
		beforeSend: function(){
			$('.action-loading').show();
			$('.action-loading').css('z-index',10050);
			$('.modal').css('z-index',10049);
		},
		dataType: 'json',
		cache: false,
		contentType: false,
		processData: false,
		success: function(response){
			// console.log(response);
			$('.action-loading').hide();
			// if(response.total==1)
			// {
				saveSuccess();
				setTimeout(function(){
					window.location='index.php';
				}, 2000);
			// } else {
				// $('.modal').css('z-index',10050);
				// showWarning('เกิดความผิดพลาดในระบบ กรุณาตรวจสอบอีกครั้ง','Warning!');
			// }
		}
	});
	return false;
}
