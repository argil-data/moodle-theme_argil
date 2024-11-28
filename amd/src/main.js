define(['jquery', 'theme_argil/ajaxcalls'],
    function($, Ajaxcalls) 
	{
	
	var ajaxx = require("theme_argil/ajaxcalls");
	var ajax1 = new ajaxx();

	function init_switchmode_ajax()
	{
		$("#switchdarkmode").click(function () {
			ajax1.switchdarkmode();
        });
	}
	function init_support_faq_ajax()
	{
		var pageurl = '?redirect=0&op=support';
			
		$(".faq_citem").click(function () {
			$('#faq_list').html('');
			$("#faqloading").addClass('show');	
			$(".faq_citem").parent().removeClass('show');	
			$(this).parent().addClass('show');	
			var fcid = $(this).data("faq_c");
			
			window.history.pushState( {} , '', pageurl+'&cat='+fcid );
			ajax1.get_faq_question_list(fcid);
        });
		$(".faq_qitem").click(function () {
			var qid = $(this).data("faq_q");
			$(".faq_qitem").parent().removeClass('show');	
			$(".fquestion").removeClass('show');	
			$(this).parent().addClass('show');	
			$("#fquestion"+qid).addClass('show');	
			
			var fcid = $(this).data("faq_c");
			var fqid = $(this).data("faq_q");
			window.history.pushState( {} , '', pageurl+'&cat='+fcid+'&topic='+fqid );
		});
		
	}

	return {
        init: function() {
			init_switchmode_ajax();	
        },
		faq: function(){
			init_support_faq_ajax();
		}
    };
});