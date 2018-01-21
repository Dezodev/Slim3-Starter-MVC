$(->
    $('#side-menu').metisMenu()

    resizeElements = ->
        topOffset = 50
        width = if(@.window.innerWidth > 0) then @.window.innerWidth else @.screen.width

        if (width < 768)
            $('div.navbar-collapse').addClass('collapse')
            topOffset = 100; ## 2-row-menu
        else
            $('div.navbar-collapse').removeClass('collapse')

        height = (if(@.window.innerHeight > 0) then @.window.innerHeight else @.screen.height) - 1
        height = height - topOffset

        height = 1 if (height < 1)
        if (height > topOffset)
            $("#page-wrapper").css("min-height", (height) + "px")

    resizeElements()
    $(window).bind("load resize", resizeElements)

    thisURL = window.location;
    element = $('ul.nav a').filter(->
        return @.href == thisURL;
    ).addClass('active').parent();

    while (true)
        if (element.is('li'))
            element = element.parent().addClass('in').parent()
        else
            break
)
