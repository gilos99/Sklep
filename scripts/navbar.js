$(window).scroll(()=>{
    if(!isVisible($("#titlebar")))
    {
        $("#nav").css("position" , "fixed");
        $("#main").css("margin-top" , $("#nav").height());
        $("#nav").css("top" , "0");
    }
    else
    {
        $("#nav").css("position" , "relative");
        $("#main").css("margin-top" , 0);
    }
});



function isVisible(elem) {
    var $elem = $(elem);
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var elemBottom = $elem.offset().top + $elem.height();

    return elemBottom > docViewTop;
}