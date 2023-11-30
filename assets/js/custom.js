"use strict";

/**
 *	Custom jQuery Scripts
 *	Developed by: Lisa DeBona
 *  Date Modified: 11.08.2023
 */
(function ($) {
  $.fn.jQuerySimpleCounter = function (options) {
    var settings = $.extend({
      start: 0,
      end: 100,
      easing: 'swing',
      duration: 400,
      complete: ''
    }, options);
    var thisElement = $(this);
    $({
      count: settings.start
    }).animate({
      count: settings.end
    }, {
      duration: settings.duration,
      easing: settings.easing,
      step: function step() {
        var mathCount = Math.ceil(this.count);
        thisElement.text(mathCount);
      },
      complete: settings.complete
    });
  };
})(jQuery);

jQuery(document).ready(function ($) {
  // if( $('.wp-block-site-logo').length ) {
  //   if( $('body').hasClass('home') ) {
  //     if(typeof homepageLogo!=undefined && homepageLogo) {
  //       $('.wp-block-site-logo a').html('<img src="'+homepageLogo+'" alt="'+siteName+' Logo" class="custom-logo">');
  //       $('.wp-block-site-logo').addClass('customized');
  //     }
  //   } else {
  //     if(typeof subpageLogo!=undefined && subpageLogo) {
  //       $('.wp-block-site-logo a').html('<img src="'+subpageLogo+'" alt="'+siteName+' Logo" class="custom-logo">');
  //       $('.wp-block-site-logo').addClass('customized');
  //     }
  //   }
  // }
  $(document).on('click', '#menu-toggle', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $('#site-navigation').toggleClass('active');
    $('body').toggleClass('mobile-nav-active');
  });
  $(document).on('click', '.main-navigation.active .menu-item-has-children > a ', function (e) {
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).parent().toggleClass('active');
    $(this).next('.sub-menu').slideToggle();
  }); //GET INVOLVED

  if ($('.wp-block-columns.involved').length) {
    if ($('.wp-block-columns.involved .wp-block-image').length) {
      $('.wp-block-columns.involved .wp-block-image').each(function () {
        var parent = $(this).parent();
        var imageSrc = $(this).find('img').attr('src');
        parent.addClass('boxIcon');
        $(this).css('background-image', 'url(' + imageSrc + ')');
        $('<img src="' + assetsDir + '/square.png" alt="" class="resizer" />').appendTo(parent);
      });
    }
  } //RECENT NEWS


  if ($('#RecentNews ul.wp-block-latest-posts li').length) {
    $('#RecentNews ul.wp-block-latest-posts li').each(function () {
      var target = $(this);
      var posttitle = $(this).find('.wp-block-latest-posts__post-title');

      if (target.find('.wp-block-latest-posts__featured-image img').length) {
        var wpImage = target.find('.wp-block-latest-posts__featured-image img');
        var imgSrc = wpImage.attr('src');
        wpImage.parent().css('background-image', 'url(' + imgSrc + ')');
        var featImg = target.find('.wp-block-latest-posts__featured-image img');
        $('<img src="' + assetsDir + '/square.png" alt="" class="resizer" />').insertAfter(featImg);
      }

      var link = posttitle.attr('href');
      $('<div class="more"><a href="' + link + '" class="morelink">Read More</a></div>').appendTo(target);
      posttitle.replaceWith('<p class="posttitle">' + posttitle.html() + '</p>');
      target.wrapInner('<div class="inside"></div>');
    });
  }

  if ($('footer.wp-block-template-part .addressRow p').length) {
    $('footer.wp-block-template-part .addressRow p').each(function () {
      if ($(this).hasClass('address')) {
        $(this).prepend('<i class="fa-solid fa-location-dot"></i>');
      } else if ($(this).hasClass('pobox')) {
        $(this).prepend('<i class="fa-solid fa-envelope"></i>');
      } else if ($(this).hasClass('phone')) {
        $(this).prepend('<i class="fa-solid fa-phone"></i>');
      }
    });
  } //Counter


  if ($('.wp-block-group.numbers h4').length) {
    $('.wp-block-group.numbers h4').each(function () {
      var str = $(this).text().trim();
      $(this).attr('data-number', str);

      if (isNumeric(str.replace(',', ''))) {
        $(this).rCounter({
          'duration': 25
        });
      }
    });
  }

  $(function ($, win) {
    $.fn.inViewport = function (cb) {
      return this.each(function (i, el) {
        function visPx() {
          var H = $(this).height(),
              r = el.getBoundingClientRect(),
              t = r.top,
              b = r.bottom;
          return cb.call(el, Math.max(0, t > 0 ? H - t : b < H ? b : H));
        }

        visPx();
        $(win).on("resize scroll", visPx);
      });
    };
  }(jQuery, window));
  $(".wp-block-group.numbers").inViewport(function (px) {
    if (px > 0 && !this.initNumAnim) {
      setTimeout(function () {
        $('.wp-block-group.numbers h4').each(function () {
          var str = $(this).text().trim();
          var num = str.replace(',', '');
          var origin = $(this).attr('data-number');

          if (origin != str) {
            $(this).text(origin);
          }
        });
      }, 1800);
    } else {
      $('.wp-block-group.numbers h4').each(function () {
        var origin = $(this).attr('data-number');
        $(this).text(origin);
      });
    }
  });

  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  } //Sticky Nav


  var siteHeader = $('header.site-header').height();
  $(window).scroll(function () {
    if ($(this).scrollTop() > siteHeader) {
      $('header.site-header').addClass('sticky');
      $('body').addClass('sticky-header');
    } else {
      $('header.site-header').removeClass('sticky');
      $('body').removeClass('sticky-header');
    }
  });

  if ($('body').hasClass('subpage')) {
    if ($('.hero').length) {
      if ($('.hero h1').length) {
        $('h1.wp-block-post-title').parent().remove();
      }
    } else {
      if ($('h1.wp-block-post-title').length) {
        $('h1.wp-block-post-title').show();
      }
    }
  }

  if ($('.boxStyles .wp-block-group.icon').length) {
    $('.boxStyles .wp-block-group.icon').each(function () {
      if ($(this).find('.wp-block-image img').length) {
        var imageSrc = $(this).find('img').attr('src');
        $(this).find('.wp-block-image').css('background-image', 'url(' + imageSrc + ')');
      }
    });
  }

  if ($('.wp-flexible-container').length) {
    if (currentPageId) {
      displayFlexibleContent(currentPageId);
    }
  }

  function displayFlexibleContent(postId) {
    var flexibleContainer = $('.wp-flexible-container');
    $.ajax({
      url: siteURL + '/wp-json/repeatable/v1/post/' + postId,
      method: 'GET',
      beforeSend: function beforeSend(xhr) {},
      success: function success(data) {
        if (data) {
          flexibleContainer.html(data);

          if ($('.repeatable-fullwidth-text-block').length) {
            $('.repeatable-fullwidth-text-block').each(function () {
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
              if ($(this).find('.ChecklistWrap p').length) {
                $(this).find('.ChecklistWrap').each(function () {
                  var targetUL = $(this);
                  var list = $(this).find('p');
                  var countList = list.length;
                  var colNum = 2;

                  if (countList > 3) {
                    var newULR = '<div class="checklist"><ul class="check">';
                    var offset = Math.round(countList / colNum);
                    var offsetKey = offset - 1;
                    list.eq(offsetKey).addClass('end');
                    var i = 1;
                    list.each(function () {
                      if (i % offset == 0 && i != countList) {
                        newULR += '<li>' + $(this).html() + '</li></ul><ul class="check">';
                      } else {
                        newULR += '<li>' + $(this).html() + '</li>';
                      }

                      i++;
                    });
                    newULR += "</ul></div>";
                    targetUL.replaceWith(newULR);
                  }
                });
              }
            });
          }
        }
      }
    }, function (data, status) {//console.log(data);
    });
  } // $.ajax({
  //   url: siteURL + '/wp-json/repeatable/v1/post/',
  //   method: 'GET',
  //   beforeSend: function (xhr) {
  //   }
  // }, function(data, status){
  //     console.log(data);
  // });


  if ($('.subpage-banner h1').length) {
    $('body').addClass('has-hero');
    $('h1.page-title').remove();
  }

  function splitUL(container, numCols) {
    console.log(numCols);
    var num_cols = numCols,
        listItem = 'li',
        listClass = 'sub-list';
    container.each(function () {
      var items_per_col = new Array(),
          items = $(this).find(listItem),
          min_items_per_col = Math.floor(items.length / num_cols),
          difference = items.length - min_items_per_col * num_cols;

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
    container.replaceWith('<div class="columns-split">' + container.html() + '</div>');
  }
});
"use strict";

(function () {
  tinymce.PluginManager.add('checklistbutton', function (editor, url) {
    //console.log(url);
    var parts = url.split('assets');
    var themeURL = parts[0]; // Add Button to Visual Editor Toolbar

    editor.addButton('custom_class', {
      title: 'Checklist',
      cmd: 'custom_class',
      image: themeURL + 'assets/img/checklist.png'
    }); // Add Command when Button Clicked

    editor.addCommand('custom_class', function () {
      //alert('Button clicked!');
      // var selected_text = editor.selection.getContent({
      //   'format': 'html'
      // });
      var selected_text = editor.selection.getContent();

      if (selected_text.length === 0) {
        alert('Please select some text.');
        return;
      }

      var open_column = '<div class="ChecklistWrap">';
      var close_column = '</div>';
      var return_text = '';
      return_text = open_column + selected_text + close_column;
      editor.execCommand('mceReplaceContent', false, return_text);
      return; //var selected_text = editor.selection.getContent();
      // var selected_text = editor.selection.getContent({
      //   'format': 'html'
      // });
      // var return_text = '';
      // return_text = '<span class="dropcap">' + selected_text + '</span>';
      // editor.execCommand('mceInsertContent', 0, return_text);
    });
  });
})();