// kcjp2014 theme scripts

jQuery( function($) {

  var wpadminbar = $('#wpadminbar'),
      kcjpNavbar = $('#kcjp-global-navbar'),
      kcjpNavH   = kcjpNavbar.height() + 4;

  /**
   * body margin-top for logged in user (adminbar)
   */
  if (wpadminbar.length) {
    kcjpNavbar.css('top',wpadminbar[0].offsetHeight);
  }

  /**
   * Smooth scroll
   */
  $('a.scrollTo').click( function(e) {
    e.preventDefault();
    var href = $(this).attr('href'),
        tar  = $(href == '#' ? 'html' : href),
        tarOffset = tar.offset().top - kcjpNavH
    $('html, body').animate( { scrollTop: tarOffset }, 250 );
  } );

  /**
   * Modal image
   */
  $('a.modal-image').click( function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
  } );

} );

/**
 * home #kitchencar
 */
jQuery( function($) {

  var cell = $('#kitchencars').find('.kitchencar-section');

  cellSizing( cell );

  window.addEventListener('resize', function(e) {
    cellSizing( cell );
  });

  function cellSizing( jq ) {
    var hei;
    jq.each(function() {
      $jq = jQuery(this);
      if ( undefined === hei ) {
        hei = $jq.width() * 0.7109375;
      }
      $jq.height(hei);
    });
  }

} );

/**
 * home 2014 winners
 */
jQuery( function($) {

  var winnerCell = $('#winners2014').find('section.winner'),
      cellHei  = winnerCell.width() * 0.5;

  winnerCell.height( cellHei );

} );

/**
 * 
 */
jQuery( function($) {

  var $container = $('#kitchencar-gallery');

  if ( !$container.length ) {
    return false;
  }
  $container.imagesLoaded( function() {
    $container.masonry( {
      gutter: 10,
      itemSelector: '.masonry-item'
    } );
  } );

} );

