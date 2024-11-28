define(['jquery', 'core/notification','core/ajax', 'core/templates'],
       function($, notification, ajax, templates) {

    function Ajaxcall() {
        this.value = "ajax ok";
    };

	Ajaxcall.prototype.switchdarkmode = function() {
        var promises = ajax.call([{
            methodname: 'theme_argil_switchdarkmode',
            args: {},
            done: console.log("ajax done"),
            fail: function(response) {
				console.log('fail: ');
				console.log(response);
			}
        }]);
        promises[0].then(function(data) { 
			if(data['darkmode'])
			{
				$('body').addClass('darkmode');	
				$("#switchmode").attr('data-darkmode','dark');	
				$(".switchmodeicon ").addClass('checked ');
			}
			else
			{
				$('body').removeClass('darkmode');	
				$("#switchmode").attr('data-darkmode','light');
				$(".switchmodeicon ").removeClass('checked ');
				
			}	
        });
    };
	
	Ajaxcall.prototype.get_faq_question_list = function(fcid) {
		var promises = ajax.call([{
            methodname: 'theme_argil_get_faq_question_list',
            args: {catid: fcid},
            done: console.log("faq list done"),
            fail: function(response) {
				console.log('fail: theme_argil_get_faq_question_list');
				console.log(response);
			}
        }]);
		promises[0].then(function(data) {
			$("#faqloading").removeClass('show');	
			$('#faq_list' ).html(data.content);
			
			$(".faq_qitem").click(function () {
				var pageurl = '?redirect=0&op=support';
				var qid = $(this).data("faq_q");
				$(".faq_qitem").parent().removeClass('show');	
				$(".fquestion").removeClass('show');	
				$(this).parent().addClass('show');	
				$("#fquestion"+qid).addClass('show');	

			
				var fcid = $(this).data("faq_c");
				var fqid = $(this).data("faq_q");
				window.history.pushState( {} , '', pageurl+'&cat='+fcid+'&topic='+fqid );
			});
		
		});	
	};

    return Ajaxcall;
});