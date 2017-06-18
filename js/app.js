$(function(){

	$('#forecast').hide();
	$('#prev').hide();

	// Mouse event showing legend for arrow
	$('#arrowPrev').mouseover(function(){
		$('#prev').show();
	});	
	$('#arrowPrev').mouseout(function(){
		$('#prev').hide();
	});

	// Forecast weather shown or hidden on click
	$('#btn_forecast').on('click', function(){
		if($('#arrowPrev').hasClass('fa-arrow-circle-down')){
			$('#prev').html() === 'See the forecast';
			$('#forecast').show();	
			$('#arrowPrev').removeClass('fa-arrow-circle-down').addClass('fa-arrow-circle-up');
			$('#prev').html('Hide Forecasts');
		}
		else if ($('#arrowPrev').hasClass('fa-arrow-circle-up')){
			$('#prev').html() === 'Hide Forecasts';
			$('#forecast').hide();
			$('#arrowPrev').removeClass('fa-arrow-circle-up').addClass('fa-arrow-circle-down');
			$('#prev').html('See the forecast');
		}
	});

});