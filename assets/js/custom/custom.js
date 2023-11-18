/**
 *	Custom jQuery Scripts
 *	Developed by: Lisa DeBona
 *  Date Modified: 11.08.2023
 */

 (function($) {
	$.fn.jQuerySimpleCounter = function( options ) {
	    var settings = $.extend({
	        start:  0,
	        end:    100,
	        easing: 'swing',
	        duration: 400,
	        complete: ''
	    }, options );

	    var thisElement = $(this);

	    $({count: settings.start}).animate({count: settings.end}, {
			duration: settings.duration,
			easing: settings.easing,
			step: function() {
				var mathCount = Math.ceil(this.count);
				thisElement.text(mathCount);
			},
			complete: settings.complete
		});
	};

}(jQuery));

jQuery(document).ready(function ($) {

  if( $('header.wp-block-template-part .mainNav').length ) {
    var header = $('header.wp-block-template-part .mainNav');
    if( header.find('.wp-block-buttons').length ) {
      var headerButtons = header.find('.wp-block-buttons').html();
      $('<div class="mobile-block-buttons">'+headerButtons+'</div>').insertBefore(header);
    }
    if( header.find('#menu-toggle').length==0 ) {
      $('<button id="menu-toggle" class="menu-toggle"><span class="sr">Menu Toggle</span><span class="bar"></span></button>').insertBefore(header);
    }
  }

  $(document).on('click','#menu-toggle', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $('.mainNav').toggleClass('active');
  });

  //GET INVOLVED
  if( $('.wp-block-columns.involved').length ) {
    if( $('.wp-block-columns.involved .wp-block-image').length ) {
      $('.wp-block-columns.involved .wp-block-image').each(function(){
        var parent = $(this).parent();
        var imageSrc = $(this).find('img').attr('src');
        parent.addClass('boxIcon');
        $(this).css('background-image','url('+imageSrc+')');
        $('<img src="'+assetsDir+'/square.png" alt="" class="resizer" />').appendTo(parent);
      });
    }
  }

  //RECENT NEWS
  if( $('#RecentNews ul.wp-block-latest-posts li').length ) {
    $('#RecentNews ul.wp-block-latest-posts li').each(function(){
      var target = $(this);
      var posttitle = $(this).find('.wp-block-latest-posts__post-title');
      if( target.find('.wp-block-latest-posts__featured-image img').length ) {
        var wpImage = target.find('.wp-block-latest-posts__featured-image img');
        var imgSrc = wpImage.attr('src');
        wpImage.parent().css('background-image','url('+imgSrc+')');
        var featImg = target.find('.wp-block-latest-posts__featured-image img');
        $('<img src="'+assetsDir+'/square.png" alt="" class="resizer" />').insertAfter(featImg);
      }
      var link = posttitle.attr('href');
      $('<div class="more"><a href="'+link+'" class="morelink">Read More</a></div>').appendTo(target);
      posttitle.replaceWith('<p class="posttitle">'+posttitle.html()+'</p>');
      target.wrapInner('<div class="inside"></div>');
    });
  }

  if( $('footer.wp-block-template-part .addressRow p').length ) {
    $('footer.wp-block-template-part .addressRow p').each(function(){
      if( $(this).hasClass('address') ) {
        $(this).prepend('<i class="fa-solid fa-location-dot"></i>');
      } else if( $(this).hasClass('pobox') ) {
        $(this).prepend('<i class="fa-solid fa-envelope"></i>');
      } else if( $(this).hasClass('phone') ) {
        $(this).prepend('<i class="fa-solid fa-phone"></i>');
      }
    });
  }

  //Counter
  if( $('.wp-block-group.numbers h4').length ) {
    $('.wp-block-group.numbers h4').each(function(){
      var str = $(this).text().trim();
      $(this).attr('data-number', str);
      if(isNumeric(str.replace(',',''))) {
        $(this).rCounter({
          'duration':25
        });
      }
    });
  }

  $(function($, win) {
    $.fn.inViewport = function(cb) {
      return this.each(function(i,el){
        function visPx(){
          var H = $(this).height(),
              r = el.getBoundingClientRect(), t=r.top, b=r.bottom;
          return cb.call(el, Math.max(0, t>0? H-t : (b<H?b:H)));  
        } visPx();
        $(win).on("resize scroll", visPx);
      });
    };
  }(jQuery, window));

  $(".wp-block-group.numbers").inViewport(function(px) {
    if(px>0 && !this.initNumAnim) { 
      setTimeout(function(){
        $('.wp-block-group.numbers h4').each(function(){
          var str = $(this).text().trim();
          var num = str.replace(',','');
          var origin = $(this).attr('data-number');
          if(origin!=str) {
            $(this).text(origin);
          }
        });
      },1800);
    } else {
      $('.wp-block-group.numbers h4').each(function() {
        var origin = $(this).attr('data-number');
        $(this).text(origin);
      });
    }
  });

  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }

  //Sticky Nav
  var siteHeader = $('.siteHeader').height();
  $(window).scroll(function() {
    if( $(this).scrollTop() > siteHeader ) {
      $('.siteHeader').addClass('sticky');
    } else {
      $('.siteHeader').removeClass('sticky');
    }
  });

  if( $('body').hasClass('subpage') ) {
    if( $('.hero').length ) {
      if( $('.hero h1').length ) {
        $('h1.wp-block-post-title').parent().remove();
      }
    } else {
      if( $('h1.wp-block-post-title').length ) {
        $('h1.wp-block-post-title').show();
      }
    }
  }

  if( $('.boxStyles .wp-block-group.icon').length ) {
    $('.boxStyles .wp-block-group.icon').each(function(){
      if( $(this).find('.wp-block-image img').length ) {
        var imageSrc = $(this).find('img').attr('src');
        $(this).find('.wp-block-image').css('background-image','url('+imageSrc+')');
      }
      
    });
  }

  if( $('.wp-flexible-container').length ) {
    //var pageId = $(/)
    if( currentPageId ) {
      displayFlexibleContent(currentPageId);
    }
  }

  function displayFlexibleContent(postId) {
    var flexibleContainer = $('.wp-flexible-container');
    $.ajax({
      url: siteURL + '/wp-json/repeatable/v1/post/' + postId,
      method: 'GET',
      beforeSend: function (xhr) {
      },
      success: function(data) {
        if(data) {
          flexibleContainer.html(data);
        }
      }
    },function(data, status){
      //console.log(data);
    });
  }

  // $.ajax({
  //   url: siteURL + '/wp-json/repeatable/v1/post/',
  //   method: 'GET',
  //   beforeSend: function (xhr) {
  //   }
  // }, function(data, status){
  //     console.log(data);
  // });


}); 



