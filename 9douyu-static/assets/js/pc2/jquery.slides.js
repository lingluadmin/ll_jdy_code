(function($){
	var numpic = $('#v4-slides li').size()-1;
	var nownow = 0;
	var inout = 0;
	var TT = 0;
	var SPEED = 7000;
	var stopscroll = true;
	var btnPrev = $('#v4-slides_prev');
	var btnNext = $('#v4-slides_next');

	$('#v4-slides li').eq(0).siblings('li').css({'display':'none'});


	var ulstart = '<ul id="v4-pagination">',
		ulcontent = '',
		ulend = '</ul>';
	ADDLI();
	var pagination = $('#v4-pagination li');
	var paginationwidth = $('#v4-pagination').width();
	$('#v4-pagination').css('margin-left',(-paginationwidth/2))
	
	pagination.eq(0).addClass('current')
		
	function ADDLI(){
		//var lilicount = numpic + 1;
		for(var i = 0; i <= numpic; i++){
			ulcontent += '<li>' + '<a href="#">' + (i+1) + '</a>' + '</li>';
		}
		
		$('#v4-slides').after(ulstart + ulcontent + ulend);	
	}

	pagination.on('click',DOTCHANGE)
	
	function DOTCHANGE(){
		
		var changenow = $(this).index();
		
		$('#v4-slides li').eq(nownow).css('z-index','800');
		$('#v4-slides li').eq(changenow).css({'z-index':'900'}).show();
		pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
		$('#v4-slides li').eq(nownow).fadeOut(400,function(){$('#v4-slides li').eq(changenow).fadeIn(500);});
		nownow = changenow;
	}
	
	pagination.mouseenter(function(){
		inout = 1;
	})
	
	pagination.mouseleave(function(){
		inout = 0;
	})
	

	btnPrev.click(function() {

		nownow = nownow%(numpic+1);
		var NN = nownow%(numpic+1)-1;
		$('#v4-slides li').eq(nownow).css('z-index','800');
		$('#v4-slides li').eq(NN).stop(true,true).css({'z-index':'900'}).show();
		$('#v4-slides li').eq(nownow).fadeOut(400,function(){$('#v4-slides li').eq(NN).fadeIn(500);});
		pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

		nownow-=1;


	});
	btnNext.click(function() {
		auto();

	});

	function GOGO(){
		
		auto();


		TT = setTimeout(GOGO, SPEED);
		
	}
	function auto(){
		var NN = nownow+1;

		if( inout == 1 ){
			//Do nothing
		} else {
			if(nownow < numpic){
				$('#v4-slides li').eq(nownow).css('z-index','800');
				$('#v4-slides li').eq(NN).css({'z-index':'900'}).show();
				pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
				$('#v4-slides li').eq(nownow).fadeOut(400,function(){$('#v4-slides li').eq(NN).fadeIn(500);});
				nownow += 1;

			}else{
				NN = 0;
				$('#v4-slides li').eq(nownow).css('z-index','800');
				$('#v4-slides li').eq(NN).stop(true,true).css({'z-index':'900'}).show();
				$('#v4-slides li').eq(nownow).fadeOut(400,function(){$('#v4-slides li').eq(0).fadeIn(500);});
				pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

				nownow=0;

			}
		}

	}
	if(stopscroll){
		$('#v4-slides a').hover(function(){
			inout = 1;
		},function(){
			inout = 0;
		});
	}
	
	TT = setTimeout(GOGO, SPEED);



})(jQuery)