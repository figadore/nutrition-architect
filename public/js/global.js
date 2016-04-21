(function($)
{
	var methods = {
		initFoodControllerFoodDemo : function()
		{
			equalHeightDays();
			$(".food-entries").droppable(
				{
					//hoverClass: "drop-hover",
					//over: function(event, ui) { $(this).parent()
						//.addClass("drop-hover"); },
					//out: function(event, ui) { $(this).parent()
						//.removeClass("drop-hover"); }
					//activeClass: "drop-active"
				}
			);
			$(".food-entry").draggable(
				{
					//"containment":".day",
					//appendTo: "body",
					connectToSortable:".food-entries",
					cursor: "move",
					distance: 10,
					helper: "clone",
					appendTo: "body",
					revert: "invalid",
					scroll:"false",
					revertDuration: 100,
					//delay: 100,
					start: function(event, ui) { 
						$(this).hide(); 
						$(this).addClass("cloned");
						$(ui.item).addClass("cloned");
					},
					stop: function(event, ui)
					{
						//$(this).removeClass("cloned");
						//$(ui.item).removeClass("cloned");
						$(this).show();
					},
					drag: function(event, ui)
					{
						ui.helper.parentElement = $("body");
					},
					zIndex:9999
					//stack:".day"
				}
			);
			$(".food-entries").sortable(
				{
					connectWith:".food-entries",
					beforeStop: function(event, ui) {
						newItem = ui.item;
					},
					receive: function(event, ui)
					{
						//$(this).append($(ui.helper).clone());
						$(newItem).attr("id","draggable");
						if ($(ui.item).hasClass('cloned'))
						{
							ui.item.remove();
						}
						//$(ui.item).closest('.day').css('height', 'auto');
						$(this).find('.food-entry').removeClass('cloned');
						//$(this).closest('.day').css('height', 'auto');
						equalHeightDays(); 
					}
				}
			);

			$(".section-rows").sortable(
				{
					cursor: "move",
					//trying to have only header area draggable, but 
					//dragging from in a cell still works
					items: ".section-row:not(.cell)", 
					//helper: "clone",
					tolerance:"intersect",
					//containment:"parent"
					axis:"y"
				}
			);

			$('.week-header').click(function() {
					$(this).find('div:first').toggle('slide', {
						complete: function() {
							equalHeightDays(); 
						},
						direction: 'up'
					});
					return false;
				}
			);

			//set all days in a row to match the tallest
			function equalHeightDays()
			{
				$(".row-fluid .row-fluid").each( function(){
					var max=0; 
					//persists through sub iterations to track whether there is 
					//a difference in heights
					var sameHeight = 0; 
					var adjust=false; 
					$(this).find(".seventh.cell").each(function(){
						$(this).css('height', 'auto'); 
						height = $(this).height(); 
						//find max
						if (height > max) 
						{
							max = height;
						} 
						if (sameHeight == 0)
						{
							sameHeight = height;
						}
						//check if there is a difference in heights, adjust all 
						//to match after done iterating
						if (sameHeight != height) 
						{
							adjust = true;
						}
					});
					if (adjust)
					{
						$(this).find(".seventh.cell").each(function(){
							$(this).height(max);
						})
					}
				});
			}
		}
	};
	$.fn.food = function(method)
	{
		if (methods[method] )
		{
			return methods[ method ].apply(this, 
					Array.prototype.slice.call( arguments, 1));
		}
		else if (typeof method === 'object' || !method )
		{
			return methods.init.apply(this, arguments);
		}
		else
		{
			return false;
		}
	}
}
)($)
