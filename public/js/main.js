// add your custom js here
$(document).ready(function() {
 
	$window = $(window);
 
	if ( $.isFunction($.fn.owlCarousel) ) {
		$("#home-slider").owlCarousel({

		  navigation : false, // Show next and prev buttons
		  paginationSpeed : 1300,
		  autoPlay : 8000,
		  addClassActive : true,
		  singleItem : true

		  // "singleItem:true" is a shortcut for:
		  // items : 1, 
		  // itemsDesktop : false,
		  // itemsDesktopSmall : false,
		  // itemsTablet: false,
		  // itemsMobile : false

		});

		$("#tools-slider").owlCarousel({

		  navigation : false, // Show next and prev buttons
		  paginationSpeed : 1300,
		  autoPlay : 3000,
		  loop : true,
		  items: 6,
		  itemsCustom: [[1200, 6], [992, 5], [768, 4], [480, 3], [0, 2]]

		  // "singleItem:true" is a shortcut for:
		  // items : 1, 
		  // itemsDesktop : false,
		  // itemsDesktopSmall : false,
		  // itemsTablet: false,
		  // itemsMobile : false

		});

		$("#example-slider").owlCarousel({

		  navigation : false, // Show next and prev buttons
		  paginationSpeed : 1300,
		  autoPlay : 3000,
		  loop : true,
		  items: 3
		  //itemsCustom: [[1200, 6], [992, 5], [768, 4], [480, 3], [370, 2]]

		  // "singleItem:true" is a shortcut for:
		  // items : 1, 
		  // itemsDesktop : false,
		  // itemsDesktopSmall : false,
		  // itemsTablet: false,
		  // itemsMobile : false

		});
	}
  
	if ( ($(window).height() + 100) < $(document).height() ) {
		$('#top-link-block').removeClass('hidden').affix({
			// how far to scroll down before link "slides" into view
			offset: {top:100}
		});
	}

	$('section[data-type="background"]').each(function(){
		// declare the variable to affect the defined data-type
		var $scroll = $(this);
					 
		$(window).scroll(function() {
			// HTML5 proves useful for helping with creating JS functions!
			// also, negative value because we're scrolling upwards                             
			var yPos = -($window.scrollTop() / $scroll.data('speed')); 
			 
			// background position
			var coords = '50% '+ yPos + 'px';

			// move the background
			$scroll.css({ backgroundPosition: coords });    
		}); // end window scroll
	});  // end section function  
	
	$('.selectable-table').on('click', '.clickable-row', function(event) {
		$(this).addClass('active').siblings().removeClass('active');
	});
	
	$('.submit').click(function() {
		var items = [];
		var headers = [];
		var url = $(this).attr('data-redirect-url');
		var tableid = '#' + $(this).attr('data-table-ref');
		var extraData = $(tableid).attr('data-extra-fields').split(',');
		
		$($(tableid).find('.active')).children().each(function() {
			items.push($(this).text());
		});
		
		$($(tableid).find('thead tr')).children().each(function() {
			headers.push($(this).text().replace(' ', '_'));
		});
		
		if(items.length <= 0)
		{
			alert('Please select a row');
			return;
		}
		
		var object = {};
		
		for(var i = 0; i < headers.length; i++)
		{
			object[headers[i]] = items[i];
		}
		
		extraData.forEach(function(item, index) {
			item = item.split(':');
			object[item[0].trim()] = item[1].trim();
		});
		
		$.redirect(url, object);
	});
 
});