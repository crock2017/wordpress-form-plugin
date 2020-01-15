jQuery(document).ready(function($){
	$('#vw_formSubmit').on('click', function(){
		 $('#vw_phone').removeClass('vw_error');
		var vw_phone = $('#vw_phone').val(), vw_error = '';
								
		if(vw_phone.length < 11) {
			vw_error = 'error';
			 $('#vw_phone').addClass('vw_error');
			return;
		}
	//=== Ajax request === 	
		var data_post = {
		action: 'frontvwFormaction',
		vw_phone: vw_phone
	};
	
	jQuery.ajax({
    url: vw_formajax.ajaxurl, // this is the object instantiated in wp_localize_script function
    type: 'POST',
    data:	data_post,
	dataType: 'text', //json or row otherwise
    success: function( data_res ){
		if(data_res == 'ok'){
	 window.location.href = 'http://sttr.su/thankyou/';		
			console.log('email is sent successfuly');
		}
	},
		error: function(error) {
									console.log(error);
		}
	});
//=== end Ajax ====		
	});
	
});