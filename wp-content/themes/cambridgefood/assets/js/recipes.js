var xhr;
jQuery(document).ready(function(){
	getRecipe('initial');

});

function getRecipe(statusType){
    $("#RecipeLoader").addClass('active');
    var limitstart = jQuery('#limitstart').val();
    var limit = jQuery('#limit').val();

	if (xhr && xhr.readyState != 4 && xhr.readyState != 0) {
		xhr.abort();
    }
    
	data = {
		action: 'getRecipe',
		limitstart: limitstart,
		statusType: statusType,

	};

	xhr = jQuery.post(ajaxurl, data, function (response) {
		if (response) {
			jQuery('#totalRecipe').val(data.total_recipes);
			limitstart = parseInt(limitstart) + parseInt(limit);
			jQuery('#limitstart').val(limitstart);
			var res = JSON.parse(response);
			if(statusType == "initial"){
				jQuery('#RecipeFirstPost').html(res.htmlFirst);
			}			
			jQuery('#RecipeSecondPost').append(res.htmlSecond);
			$("#RecipeLoader").removeClass('active');
		}
		//jQuery('.ma-preloader').fadeOut(500, function(){ jQuery('.ma-preloader').hide(); } );
	});
}