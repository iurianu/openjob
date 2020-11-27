
jQuery.noConflict();

jQuery(document).ready(function($) {
	$('.view-control').on('click', function(event) {
		var extend = $(this).parents("blockquote").find(".extended");
		extend.is(":visible")?$(this).text("Vezi tot! +"):$(this).text("Vezi mai putin! -");
		extend.toggle('show');
	});

    $("label.btn-light").on('click', function(event) {
        var siblings = $(this).siblings('label');
        var select = $(this).find("input[type='radio']");
        if (select.is(':checked')) {
            $(this).css('background-color','#ff2e39');
        }
        siblings.find("input[type='radio']").prop('checked', false);
        siblings.css('background-color','#f8f9fa');
    });
    
});
