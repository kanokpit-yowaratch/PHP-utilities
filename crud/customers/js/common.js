function saveSuccess(){
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "positionClass": "toast-bottom-center",
	  "showDuration": "3000",
	  "hideDuration": "3000",
	  "timeOut": "5000",
	  "extendedTimeOut": "3000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	var title = 'Success!';
	var msg = 'ระบบทำรายการสำเร็จ';
	toastr['success'](msg,title);
}
function showWarning(msg,title){
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "positionClass": "toast-bottom-full-width",
	  "showDuration": "3000",
	  "hideDuration": "3000",
	  "timeOut": "5000",
	  "extendedTimeOut": "3000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	toastr['warning'](msg,title);
}
