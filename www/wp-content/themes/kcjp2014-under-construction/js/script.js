$(function() {

  $('.home .kgsCopy > p').slabText();
  $('.home .leadDiv').delay(400).animate({opacity: 1}, 1000, function() {
    var j, k = 0, lnhght;
    $('.home .kgsCopy > p').children('.slabtext').each(function(i) {
      j = $(this).text().length;
      lnhght = 1 + j * 0.0175 - k * 0.0012;
      $(this).css('lineHeight', lnhght).delay(1500 * i + 20 * k).animate({'opacity': 1}, 200 * j);
      k = j;
    });
  });

  var navH = $('.kgsNavbar').height() + 4;
  var defaultPadding = navH / 2;

  $.get('http://kitchencar.jp/static/kcjp2013.json', function(json) {
    var d = $.parseJSON(json);
    var cnvs = $('#kitchencar-wrapper');
    var cellW = cnvs.width() / 4,
        cellH = cellW * 0.75;
    var agent = navigator.userAgent;
    var carIsize = (agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1 || agent.search(/iPod/) != -1 || agent.search(/Android/) != -1) ? 'carimgS' : 'carimg';
    var n = 0;
    $.each(d, function(i, v) {
      var cell = $.newEl({
        element: 'a',
        'class': 'cell',
        attr: {
          id: 'cell-' + i,
          href: '#',
          'data-name': v.name,
          'data-menu': v.menu,
          'data-genre': v.genre,
          'data-text': v.text,
          'data-itemimg': v.itemimg[0],
          'data-target': '#kitchencar-detail-' + n
        }
      });
      cell.css({
        'opacity': 0,
        'height': cellH,
        'backgroundImage': 'url(' + v[carIsize][0] + ')',
        'backgroundRepeat': 'no-repeat',
        'backgroundPosition': 'center center',
        'background-size': 'auto 102%'
      })
      .appendTo(cnvs).animate({'opacity': 1}, 400);
      if (i%4 == 3) {
        $.newEl({element:'div',id:'kitchencar-detail-' + n,style:'clear:left;background-color:#fff;'}).appendTo(cnvs);
        n++;
      }
    });
    $.newEl({element:'div',id:'kitchencar-detail-' + n,style:'clear:left;background-color:#fff;'}).appendTo(cnvs);
  });
  var topNow;
  $('#kitchencar-wrapper').on('click', '.cell', function(e) {
    e.preventDefault();
    // topNow = $(this)[0].offsetTop;
    topNow = $(window).scrollTop();
    if ($('#open-detail').length > 0)
      $('#open-detail').remove();
    var _d = $(this).data();
    var field = $(_d.target);
    field.mmsfBackdrop({dropColor:'#000',coverOver:$('.kgsNavbar')});
    field.hide().append($.newEl({
      element: 'div',
      id: 'open-detail',
      'class': 'container',
      style: 'padding-top:' + defaultPadding + 'px;padding-bottom:' + defaultPadding + 'px;',
      inner: {
        element: 'div',
        'class': 'row',
        inner: [{
          element: 'div',
          'class': ['col-sm-8', 'pull-right'],
          inner: {
            element: 'h3',
            inner: '<i class="fa fa-truck"></i> ' + _d.name
          }
        },{
          element: 'div',
          'class': 'col-sm-4',
          inner: {
            element: 'img',
            src: _d.itemimg,
            alt: _d.menu,
            style: 'max-width:100%;'
          }
        },{
          element: 'div',
          'class': 'col-sm-8',
          inner: [{
            element: 'p',
            inner: '<i class="fa fa-cutlery"></i> <strong>' + _d.genre + '</strong> | ' + _d.menu
          },{
            element: 'p',
            inner: _d.text
          }]
        }]
      }
    }));
    field.slideDown(250, function() {
      var topOffset = field.offset().top - navH;
      $('html, body').animate({scrollTop:topOffset}, 400);
    });

    $('#mmsf-backdrop, .mmsf-cover').on('click', function() {
      field.empty().mmsfBackdrop();
      $('html, body').animate({scrollTop:topNow - navH}, 250);
    });
  });

  $('a.scrollTo').click(function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    var tar = $(href == '#' ? 'html' : href);
    var tarOffset = tar.offset().top - navH;
    $('html, body').animate({scrollTop:tarOffset}, 250);
    $('button.navbar-toggle').collapse({toggle:false});
  });

});

/*
      var iImgW,
          iImgH,
          ratio = v.itemimg[1] / v.itemimg[2],
          mrgnT = 0;
      if (v.itemimg[1] - v.itemimg[2] > 0) {
        iImgH = cellH;
        iImgW = iImgH * ratio;
      } else {
        iImgW = cellW;
        iImgH = iImgW / ratio;
        mrgnT = (iImgH - cellH) / 2;
      }

          inner: [{
            element: 'h3',
            inner: v.name
          },{
            element: 'div',
            class: 'item-img',
            inner: [{
              element: 'img',
              src: v.itemimg[0],
              width: iImgW,
              height: iImgH,
              style: 'margin-top:-' + mrgnT + 'px;'
            },{
              element: 'p',
              inner: v.menu
            }]
          },{
            element: 'p',
            inner: v.text
          }]
*/



/**
 * Backdrop
 */
!function($){

  $.fn.mmsfBackdrop = function(options) {

    var el = this;

    var opts = $.extend({}, $.fn.mmsfBackdrop['default'], options);

    var backdropObj = $('#' + opts.backdropId);

    if (!backdropObj.length) {

      var backdrop = $('<div>' + opts.inner + '</div>')
        .attr('id', opts.backdropId)
        .css({
          'position': 'fixed',
          'top': 0,
          'left': 0,
          'width': '100%',
          'height': '100%',
          'backgroundColor': opts.dropColor,
          'opacity': opts.opacity,
          'zIndex': opts.zIndex
        })
        .hide()
      ;

      el.each(function() {
        $(this).css('zIndex', opts.zIndex + 1);
        if ('static' == $(this).css('position'))
          $(this).css('position','relative');
      });
      $('body').append(backdrop);

      if (opts.coverOver.length) {

        var coveredEl = new Array(opts.coverOver);
        var cover = $('<div></div>')
          .addClass(opts.coverClass)
          .css({
            'position': 'absolute',
            'top': 0,
            'left': 0,
            'width': '100%',
            'height': '100%',
            'backgroundColor': opts.dropColor,
            'opacity': opts.opacity,
          }).
          hide()
        ;
        $.each(coveredEl, function(i) {
          if ('static' == $(this).css('position')) { // need??
            $(this).css('position','relative');
          }
          cover.appendTo($(this));
        });
        $('.' + opts.coverClass).fadeIn(opts.fadeSpeed);

      }

      backdrop.fadeIn(opts.fadeSpeed);

    } else {

      backdropObj.fadeOut(opts.fadeSpeed, function() {
        $(this).remove();
        el.css({
          'position': '',
          'zIndex': ''
        });
      });
      if ($('.' + opts.coverClass).length) {
        $('.' + opts.coverClass).fadeOut(opts.fadeSpeed, function() {
          $(this).remove();
        });
      }

    }

    return this;

  };

  $.fn.mmsfBackdrop['default'] = {
    // backdrop
    backdropId: 'mmsf-backdrop',
    dropColor: 'white',
    opacity: '.65',
    fadeSpeed: 'normal',
    zIndex: 1000,
    inner: '',
    // cover
    coverOver: '',
    coverClass: 'mmsf-cover'
  };

}(window.jQuery);