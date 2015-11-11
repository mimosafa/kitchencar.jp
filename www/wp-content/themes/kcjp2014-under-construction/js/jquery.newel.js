/**
 * Create New Element
 *
 * @param options: Object {element: String HTML tag, inner:[], class:String||Array, attr:Object[, attr:value, ...]]}
 * @return HTML Object
 */
!function($) {

  $.newEl = function(options) {

    var opts = $.extend({}, options);
    var o = { element: '', inner: [], 'class': [], attr: {}, outer: '' };
    $.each(opts, function(i, v) {
      if ('element' == i) {
        o.element = v;
        delete opts.element;
      } else if ('inner' == i) {
        o.inner = o.inner.concat(v);
        delete opts.inner;
      } else if ('class' == i) {
        o['class'] = o['class'].concat(v);
        delete opts['class'];
      } else if ('attr' == i) {
        o.attr = v;
        delete opts.attr;
      } else if ('outer' == i) {
        o.outer = v;
        delete opts.outer;
      }
    });
    o.attr = $.extend(o.attr, opts);

    if (o.element) {
      var el = $('<' + o.element + '>');
    } else {
      return false;
    }
    $.each(o['class'], function(i, v) { el.addClass(v); });
    $.each(o.inner, function(i, v) {
      if (typeof v == 'object') {
        var innerOpts = $.extend({}, v);
        el.append($.newEl(innerOpts));
      } else {
        el.append(v);
      }
    });
    if (!$.isEmptyObject(o.attr)) {
      $.each(o.attr, function(i, v) {
        if (i == 'value') el.val(v);
        else el.attr(i, v);
      });
    }

    if (!o.outer) {
      return el;
    } else {
      if (typeof o.outer != 'object') {
        el.wrap(o.outer);
      } else {
        var outerOpts = $.extend({}, o.outer);
        el.wrap($.newEl(outerOpts));
      }
      return el.parent();
    }

  }

}(window.jQuery);