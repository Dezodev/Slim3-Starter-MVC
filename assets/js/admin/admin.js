// Generated by CoffeeScript 2.1.1
(function() {
  $(function() {
    var element, resizeElements, results, thisURL;
    $('#side-menu').metisMenu();
    resizeElements = function() {
      var height, topOffset, width;
      topOffset = 50;
      width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
      if (width < 768) {
        $('div.navbar-collapse').addClass('collapse');
        topOffset = 100;
      } else {
        $('div.navbar-collapse').removeClass('collapse');
      }
      height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
      height = height - topOffset;
      if (height < 1) {
        height = 1;
      }
      if (height > topOffset) {
        return $("#page-wrapper").css("min-height", height + "px");
      }
    };
    resizeElements();
    $(window).bind("load resize", resizeElements);
    thisURL = window.location;
    element = $('ul.nav a').filter(function() {
      return this.href === thisURL;
    }).addClass('active').parent();
    results = [];
    while (true) {
      if (element.is('li')) {
        results.push(element = element.parent().addClass('in').parent());
      } else {
        break;
      }
    }
    return results;
  });

}).call(this);
