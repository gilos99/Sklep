var itemsLenght = $("div[class*='i_cart']").length * ($('.i_cart').height() + 12);

if(itemsLenght > 500)
{
    $("#cart_main").height(itemsLenght);
}
else
{
    $("#cart_main").height(490);
}