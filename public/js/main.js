(function() {
  $('pre').addClass('prettify');
  $('body').delegate('h6 > a.toggle', 'click', function(e) {
    e.preventDefault();
    var div = $('+div', $(this).parent());
    if (div.toggle().toggleClass('hidden').is(':visible')) {
      $('span', this).html('&#9660;');
    } else {
      $('span', this).html('&#9658;');
    }
  }).delegate('h6 > a.remove', 'click', function(e) {
    e.preventDefault();
    $(this).parents('.menuitem:first').remove();
  }).delegate('.addattr', 'click', function(e) {
    // add attribute
    e.preventDefault();
    var input = $(this).prevAll(':text:last').clone().removeAttr('id').val(''),
      link = $(this).prevAll('a.removeattr:last').clone().removeClass('hidden');
    $(this).prevAll('a.removeattr:last').after(input, link);
  }).delegate('.removeattr', 'click', function(e) {
    // remove attribute
    e.preventDefault();
    $(this).prev().remove();
    $(this).remove();
  }).delegate('.addhtmlattr', 'click', function(e) {
    // add html attribute
    e.preventDefault();
    var content = $(this).prevAll(':text:first')
      .clone().removeAttr('id').val('');
    $(this).prevAll(':text:first').after(content);
    var prop = $(this).parent().next('.cell--small');
    var proptext = $(':text:last, a.removehtmlattr:last', prop)
      .clone().removeAttr('id').removeClass('hidden').val('');
    prop.append(proptext);
  }).delegate('.removehtmlattr', 'click', function(e) {
    // remove html attribute
    e.preventDefault();
    var elms = $('a.removehtmlattr', $(this).parent()),
      index = elms.index(this),
      prop = $(this).parent().prev('.cell--small');
    $(':text:eq(' + index + ')', $(this).parent()).remove();
    $(':text:eq(' + index + ')', prop).remove();
    $(this).remove();
  }).delegate('.menuitem :text.update-title', 'paste keyup click', function() {
    $('h6 q.update', $(this).parents('.menuitem:first')).text($(this).val());
  });

  var menuItemCache = {},
  counter = parseInt($(':hidden[name=menuitem__counter]').val(), 10);
  $('a.menuitems__new').on('click', function(e) {
    e.preventDefault();
    var itemType = $(this).prev('select[name=menuitem__type]').val();
    if (itemType in menuItemCache) {
      counter++;
      $('.menuitems').append('<div class="menuitem">' + menuItemCache[itemType].replace(/\:id/g, counter) + '</div>');
      return;
    }
    $.getJSON($(this).data('url') + '/' + itemType)
      .done(function(data) {
      menuItemCache[data.itemType] = data.html;
      counter++;
      $('.menuitems').append('<div class="menuitem">' + data.html.replace(/\:id/g, counter) + '</div>');
    }).fail(function() {
      alert('Cannot get menu item type.');
    });
  });
})();
