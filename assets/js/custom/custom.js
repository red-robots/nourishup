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

  $('#popupClose').on('click', function(e){
    e.preventDefault();
    var now = new Date().getTime();
    localStorage.setItem('popState','hide');
    localStorage.setItem('popStateSetupTime', now);
    $('#poupContainer').removeClass('show');
    $('body').css('overflow','');
  });

  $('#announcementBarClose').on('click', function(e){
    e.preventDefault();
    var now = new Date().getTime();
    localStorage.setItem('announcementBarState','hide');
    localStorage.setItem('announcementBarSetupTime', now);
    $('#announcementbar').removeClass('show');
  });


  //Remove extra 'h1'
  if( $('.tribe-events-pg-template h1.tribe-events-single-event-title').length ) {
    $('.tribe-events-pg-template h1.tribe-events-single-event-title').remove(); 
  }

  //Change HERO background-color based on Event Category
  if( $('.tribe-events-pro-summary__event h3.tribe-events-pro-summary__event-title').length ) {
    var tribeBgColor = $("h3.tribe-events-pro-summary__event-title").css("background-color");
    if( $('.subpageHero').length &&  $('.subpageHero img').length==0 ) {
      $('.subpageHero .overlay-background').css({
        'background-color':tribeBgColor,
        'opacity':'1'
      });
    }
  }
  
  if( $('body.single-tribe_events').length ) {
    if( $('.subpageHero').length &&  $('.subpageHero img').length==0 ) {
      if( $('.tribe-events-event-categories a').length ) {
        var catLink = $('.tribe-events-event-categories a').attr('href');
        var catSlug = catLink.slice(0, -1).split('/').reverse()[0];
        $('.subpageHero').addClass('tribe-events-calendar');
        $('.subpageHero .overlay-background').addClass('tribe-events-category-' + catSlug);
        $('.subpageHero .overlay-background').css('opacity',1);
      }
    }
  }

  $(document).on('click','#menu-toggle', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $('#site-navigation').toggleClass('active');
    $('body').toggleClass('mobile-nav-active');
  });

  if( $('ul#primary-menu li.menu-item-has-children').length ) {
    $('ul#primary-menu li.menu-item-has-children > a').each(function(){
      var parentlink = $(this);
      $(this).addClass('parentLink');
      $('<span class="dropdown-arrow" role="button"><span class="sr">Dropdown</span></span>').insertAfter(parentlink);
    });
  }

  $(document).on('click','.main-navigation.active .menu-item-has-children .dropdown-arrow ', function(e){
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).parent().toggleClass('active');
    $(this).next('.sub-menu').slideToggle();
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
  var siteHeader = $('header.site-header').height();
  $(window).scroll(function() {
    if( $(this).scrollTop() > siteHeader ) {
      $('header.site-header').addClass('sticky');
      $('body').addClass('sticky-header');
    } else {
      $('header.site-header').removeClass('sticky');
      $('body').removeClass('sticky-header');
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
          if( $('.repeatable-fullwidth-text-block').length ) {
            $('.repeatable-fullwidth-text-block').each(function(){
              // if( $(this).find('ul').length ) {
              //   $(this).find('ul').each(function(){
              //     var targetUL = $(this);
              //     var list = $(this).find('li');
              //     var countList = list.length;
              //     var colNum = 2;
              //     if(countList>3) {
              //       var newULR = '<div class="checklist"><ul class="check">';
              //       var offset = Math.round(countList/colNum);
              //       var offsetKey = offset-1;
              //       list.eq(offsetKey).addClass('end');
              //       var i=1;
              //       list.each(function(){
              //         if(i % offset==0 && i!=countList) {
              //           newULR += '<li>'+$(this).html()+'</li></ul><ul class="check">';
              //         } else {
              //           newULR += '<li>'+$(this).html()+'</li>';
              //         }
              //         i++;
              //       });
              //       newULR +="</ul></div>";
              //       targetUL.replaceWith(newULR);
              //     }
              //   });
              // }

              // if( $(this).find('.ChecklistWrap p').length ) {
              //   $(this).find('.ChecklistWrap').each(function(){
              //     var targetUL = $(this);
              //     var list = $(this).find('p');
              //     var countList = list.length;
              //     var colNum = 2;
              //     if(countList>3) {
              //       var newULR = '<div class="checklist"><ul class="check">';
              //       var offset = Math.round(countList/colNum);
              //       var offsetKey = offset-1;
              //       list.eq(offsetKey).addClass('end');
              //       var i=1;
              //       list.each(function(){
              //         if(i % offset==0 && i!=countList) {
              //           newULR += '<li>'+$(this).html()+'</li></ul><ul class="check">';
              //         } else {
              //           newULR += '<li>'+$(this).html()+'</li>';
              //         }
              //         i++;
              //       });
              //       newULR +="</ul></div>";
              //       targetUL.replaceWith(newULR);
              //     }
              //   });
              // }
              
            });
          }
          if( $('.ChecklistWrap p').length ) {
            $('.ChecklistWrap').each(function(){
              var targetUL = $(this);
              var list = $(this).find('p');
              var countList = list.length;
              var colNum = 2;

              if( $(this).parents('.repeatable-fullwidth-text-block').length ) {
                if(countList>3) {
                  var newULR = '<div class="checklist"><ul class="check">';
                  var offset = Math.round(countList/colNum);
                  var offsetKey = offset-1;
                  list.eq(offsetKey).addClass('end');
                  var i=1;
                  list.each(function(){
                    if(i % offset==0 && i!=countList) {
                      newULR += '<li>'+$(this).html()+'</li></ul><ul class="check">';
                    } else {
                      newULR += '<li>'+$(this).html()+'</li>';
                    }
                    i++;
                  });
                  newULR +="</ul></div>";
                  targetUL.replaceWith(newULR);
                }
              }
            });
          }

          if( $('.repeatable-twocol-text-block.half').length ) {
            $('.repeatable-twocol-text-block.half .fxcol').each(function(){
              if( $(this).find('h3').length ) {
                if( $(this).find('h3').next().prop("nodeName")=='P' ) {
                  $(this).find('h3').css('margin-bottom','0');
                }
              }
            });
          }

          var timelineBlock = '';
          if( $('.repeatable.timeline-right').length ) {
            timelineBlock = '.textRight';
          }
          if( $('.repeatable.timeline-left').length ) {
            timelineBlock = '.textLeft';
          }

          if( timelineBlock ) {
            $('[class*="timeline-"].repeatable').each(function(){
              if( $(this).find(timelineBlock + ' hr').length && $(this).find(timelineBlock).text().trim().replace(/\s+/g,'') ) {
                var parent = $(this).parents('.textRight');
                var firstP = parent.find('*').eq(0);
                $(this).find(timelineBlock + ' hr').each(function(k){
                  $(this).nextUntil("hr").wrapAll('<div class="TIMELINE_INFO">');
                  if(k==0) {
                    $(this).prevUntil(firstP).addBack().wrapAll('<div class="TIMELINE_INFO">');
                  }
                });
              }
            });

            if( $('.TIMELINE_INFO').length ) {
              $('.TIMELINE_INFO').each(function(){
                var target = $(this);
                var lastElement = $(this).find('*').last();
                target.wrapInner('<div class="textCol"></div>');
                if( $(this).find('img').length ) {
                  $(this).find('img').unwrap().wrapAll('<div class="imageCol"></div>');
                }
                if( $(this).find('.imageCol').length ) {
                  $(this).find('.imageCol').prependTo(target);
                }
              });
              $('.repeatable.timeline-right .textRight hr').remove();
            }
          }

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

  if( $('.subpage-banner h1').length ) {
    $('body').addClass('has-hero');
    $('h1.page-title').remove();
  }

  function splitUL(container,numCols) {
    console.log(numCols);
    var num_cols = numCols,
    listItem = 'li',
    listClass = 'sub-list';
    container.each(function() {
        var items_per_col = new Array(),
        items = $(this).find(listItem),
        min_items_per_col = Math.floor(items.length / num_cols),
        difference = items.length - (min_items_per_col * num_cols);
        for (var i = 0; i < num_cols; i++) {
            if (i < difference) {
                items_per_col[i] = min_items_per_col + 1;
            } else {
                items_per_col[i] = min_items_per_col;
            }
        }
        for (var i = 0; i < num_cols; i++) {
            $(this).append($('<ul ></ul>').addClass(listClass));
            for (var j = 0; j < items_per_col[i]; j++) {
                var pointer = 0;
                for (var k = 0; k < i; k++) {
                    pointer += items_per_col[k];
                }
                $(this).find('.' + listClass).last().append(items[j + pointer]);
            }
        }
    });
    container.replaceWith('<div class="columns-split">'+ container.html() +'</div>');
  }

  //Tribe Plugin
  if( $('.tribe-events-header__events-bar.tribe-events-c-events-bar').length && $('.teccc-legend #legend li').length ) {
    var currentLink = window.location.href;
    var resetLink = ( $('h1.tribe-events-header__title-text').length ) ? '<a href="'+siteURL+'/pantries/" class="resetLink">Reset</a>':'';
    //$(resetLink + '<div class="event-category-dropdown"><button class="selectBox categoryFilterBtn" role="button" aria-expanded="false" aria-controls="legend_box"><span class="catlabel">Select A Category</span></button></div>').prependTo('.tribe-events-header__events-bar.tribe-events-c-events-bar');
    $(resetLink + '<div class="event-category-dropdown"></div>').appendTo('.custom-calendar-filter');

    $('#legend_box').appendTo('.event-category-dropdown');
    $('#legend li[class*="tribe-events-category"]').last().addClass('last');
    $('.event-category-dropdown li.teccc-reset').prependTo('ul#legend');
    
    $('.otherFilters').html( $('.tribe-events-header__events-bar.tribe-events-c-events-bar').html() );
    

    $(document).on('click','.categoryFilterBtn', function(e){
      e.preventDefault();
      $('.event-category-dropdown').toggleClass('dropdown-open');
      $('.event-category-dropdown #legend_box').slideToggle();
      $(this).toggleClass('open');
      if( $(this).attr('aria-expanded')=='false' ) {
        $(this).attr('aria-expanded','true');
      } else {
        $(this).attr('aria-expanded','false');
      }
    });

    $(document).on('click','.otherFilters .tribe-events-c-events-bar__filter-button', function(e){
      e.preventDefault();
      $('.tribe-filter-bar.tribe-filter-bar--horizontal').toggleClass('tribe-filter-bar--open');
    });

    $(document).on('click','.otherFilters .tribe-events-c-view-selector__content a', function(e){
      e.preventDefault();
      var parentIndex = $(this).parent().index();
      var svgIcon = $(this).find('.tribe-events-c-view-selector__list-item-icon svg').html();
      $('.tribe-events-header__events-bar.tribe-events-c-events-bar ul.tribe-events-c-view-selector__list li').eq(parentIndex).find('a').trigger('click');
      $('.otherFilters .tribe-events-c-view-selector__content').hide();
      $('.otherFilters .tribe-events-c-view-selector .tribe-events-c-view-selector__button-icon svg').html(svgIcon);
    });

    $(document).on('click','.otherFilters .tribe-events-c-view-selector__button', function(e){
      e.preventDefault();
      $(this).next().slideToggle();
    });

  }

  if( $('body.post-type-archive-tribe_events').length && $('h1.tribe-events-header__title-text').length ) {
    $('.tribe-events-c-breadcrumbs__list-item').eq(0).find('a').text('Find A Pantry');
    $('ul#legend a').each(function(){
      var pagelink = $(this).attr('href');
      if(pagelink.includes(currentLink)) {
        $(this).parent().addClass('active');
      } 
    });
  }


  if( $('#main .wp-block-heading').length ) {
    $('#main .wp-block-heading').each(function(){
      var target = $(this);
      var nextEl = $(this).next().prop('nodeName');
      if(nextEl=='UL' || nextEl=='P') {
        target.addClass('no-margin-bottom');
      }
    });
  }

  if( $('.wp-block-group.icon figure.wp-block-image').length ) {
    $('.wp-block-group.icon figure.wp-block-image').each(function(){
      var imageDiv = $(this);
      var parent = $(this).parent();
      var imageResizer = parent.find('img.resizer');
      if( parent.next().find('a').length ) {
        var linkTitle = parent.next().find('a').text();
        var blockLink = parent.next().find('a').attr('href');
        imageResizer.wrap('<a href="'+blockLink+'" class="pagelink" aria-label="'+linkTitle+'"></a>');
      }
    });
  }


  $(document).on('click','.tribe-events-pro-map__event-title', function(){
    //alert("Open Map!");
    setTimeout(function(){
      if( $('.tribe-swiper-slide').length > 1 ) {
        var schedules = '';
        var start = [];
        var timeRange = [];
        var timeContainer = $('.tribe-swiper-slide .tribe-events-pro-map__event-tooltip-datetime-wrapper').eq(0);
        $('.tribe-swiper-slide').each(function(){
          if( $(this).find('.tribe-events-pro-map__event-tooltip-datetime').length ) {
            var time = $(this).find('.tribe-events-pro-map__event-tooltip-datetime');
            var start_time = '';
            var end_time = '';
            var startDate = '';
            if( time.find('.tribe-event-date-start').length ) {
              var startTime = time.find('.tribe-event-date-start').text();
              var arrs = startTime.trim().split('@');
              if(arrs.length>1) {
                startDate = arrs[0].trim();
                start.push(startDate);
                start_time = arrs[1].trim();
              }
            }
            if( time.find('.tribe-event-time').length ) {
              end_time = time.find('.tribe-event-time').text().trim();
            }
            var args = {
              'date':startDate,
              'start':start_time,
              'end':end_time
            }
            timeRange.push(args);
          }
        });

        
        
        // var dateArrs = [];
        // if(start.length>1 && timeRange.length) {
        //   var unique = start.filter(getUnique);

        //   for(x=0; x<unique.length; x++) {
        //     var d = unique[x];
        //     console.log(d);
        //   }

        //   //console.log(unique);

        //   // if(unique.length==1) {
        //   //   $('.tribe-events-pro-map__event-tooltip-navigation').hide();
        //   //   var eventDate = unique[0];
        //   //   var dateInfo = eventDate + ':<br>';
        //   //   if(timeRange.length>1) {
        //   //     for(i=0; i<timeRange.length; i++) {
        //   //       var obj = timeRange[i];
        //   //       var start_time_info = obj.start;
        //   //       var end_time_info = obj.end;
        //   //       var newLine = (i>0) ? '<br>' : '';
        //   //       dateInfo += newLine + start_time_info + ' - ' + end_time_info;
        //   //     }
        //   //   }
        //   //   var dateOutput = '<time class="time-range">'+dateInfo+'</time>';
        //   //   $(dateOutput).insertAfter(timeContainer);
        //   //   $('.tribe-events-pro-map__event-tooltip-datetime-wrapper').hide();
        //   // }
        // }

        
      }
    },100);
  });

  function getUnique(value, index, array) {
    return array.indexOf(value) === index;
  }

  function toFindDuplicates(arry) {
    const uniqueElements = new Set(arry);
    const filteredElements = arry.filter(item => {
        if (uniqueElements.has(item)) {
            uniqueElements.delete(item);
        } else {
            return item;
        }
    });

    return [...new Set(uniqueElements)]
  }

}); 



