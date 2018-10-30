var $img1 = $("#img1");
var $img2 = $("#img2");
var $img3 = $("#img3");

var items = ['buty1.jpg', 'buty2.jpg','buty3.jpg','buty5.jpg', 'buty6.jpg', 'czapka1.jpg' ,'czapka2.jpg' , 'czapka3.jpg' , 'czapka4.jpg' , 'koszulka1.jpg' , 'koszulka2.jpg' ,'koszulka3.jpg' ,'koszulka4.jpg' , 'kroksy.png' , 'kurtka1.jpg' , 'kurtka2.jpg' , 'spodnie1.jpg' , 'spodnie2.jpg', 'spodnie3.jpg' ,'spodnie4.jpg' , 'szalik1.jpg' , 'szalik2.jpg' , 'szalik3.jpg'];

$img1.fadeOut(400, ()=>{
    $img1.fadeIn(300).delay(400).attr('src','/sklep/assets/items/' + items[Math.floor(Math.random()*items.length)]);
});

$img3.fadeOut(400, ()=>{
    $img3.fadeIn(300).delay(400).attr('src','/sklep/assets/items/' + items[Math.floor(Math.random()*items.length)]);
});

window.setInterval(function(){
    $img1.fadeOut(400, ()=>{
        $img1.fadeIn(300).delay(400).attr('src','/sklep/assets/items/' + items[Math.floor(Math.random()*items.length)]);
    });
}, 6000);

window.setInterval(function(){
    $img2.fadeOut(400, ()=>{
        $img2.fadeIn(300).delay(400).attr('src','/sklep/assets/items/' + items[Math.floor(Math.random()*items.length)]);
    });
}, 5000);

window.setInterval(function(){
    $img3.fadeOut(400, ()=>{
        $img3.fadeIn(300).delay(400).attr('src','/sklep/assets/items/' + items[Math.floor(Math.random()*items.length)]);
    });
}, 4000);