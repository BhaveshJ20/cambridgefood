var xhr;
jQuery(document).ready(function(){
	getRecipeAndTips('initial');

});

function getRecipeAndTips(statusType){
    $("#RecipeAndTipLoader").addClass('active');
    var limitstart = jQuery('#limitstart').val();
    var limit = jQuery('#limit').val();

	if (xhr && xhr.readyState != 4 && xhr.readyState != 0) {
		xhr.abort();
    }
    
	data = {
		action: 'getRecipeAndTips',
		limitstart: limitstart,
		statusType: statusType,

	};

	xhr = jQuery.post(ajaxurl, data, function (response) {
		if (response) {
			jQuery('#totalRecipeAndTips').val(data.total_recipesandtips);
			limitstart = parseInt(limitstart) + parseInt(limit);
			jQuery('#limitstart').val(limitstart);
			var res = JSON.parse(response);
			if(statusType == "initial"){
				jQuery('#RecipeTipFirstPost').html(res.htmlFirst);
			}			
			jQuery('#RecipeTipSecondPost').append(res.htmlSecond);
			$("#RecipeAndTipLoader").removeClass('active');
		}
		//jQuery('.ma-preloader').fadeOut(500, function(){ jQuery('.ma-preloader').hide(); } );
	});
}