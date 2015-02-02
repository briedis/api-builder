(function($){
	'use strict';
	$(function(){
		$('.api-builder .api-method .nav-tabs a').click(function(){
			var el = $(this);
			el.closest('ul').find('li').removeClass('active');
			el.closest('li').addClass('active');
			el.closest('.api-method')
				.find('.tab').addClass('hidden')
				.filter('.' + el.data('target')).removeClass('hidden');
		});
	});
})(jQuery);