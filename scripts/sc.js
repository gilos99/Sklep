var commentsHeight = ($("div[class*='comment']").length * 1.5 * ($('.comment').height() + 12)) + $("#add_comment").height() * 1.5;

if(isNaN(commentsHeight))
{
    if(isNaN($("#add_comment").height()))
    {
        commentsHeight = (($("div[class*='comment']").length * 1.5) *  ($('.comment').height() + 12)) + 50;
    }
    else
    {
        commentsHeight = $("#add_comment").height() * 1.5;
    }
}

$("#sc_main").height(500 + commentsHeight);