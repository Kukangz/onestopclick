jQuery(document).ready(function($){

    // jQuery sticky Menu
    
    $(".mainmenu-area").sticky({topSpacing:0});
    $(".datepicker").datepicker();

    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }



    
    $('.product-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:5,
            }
        }
    });  
    
    $('.related-products-carousel').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:2,
            },
            1000:{
                items:2,
            },
            1200:{
                items:3,
            }
        }
    });  
    
    $('.brand-list').owlCarousel({
        loop:true,
        nav:true,
        margin:20,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
            },
            600:{
                items:3,
            },
            1000:{
                items:4,
            }
        }
    });    
    
    
    // Bootstrap Mobile Menu fix
    $(".navbar-nav li a").click(function(){
        $(".navbar-collapse").removeClass('in');
    });    
    
    // jQuery Scroll effect
    $('.navbar-nav li a, .scroll-to-up').bind('click', function(event) {
        var $anchor = $(this);
        var headerH = $('.header-area').outerHeight();
        $('html, body').stop().animate({
            scrollTop : $($anchor.attr('href')).offset().top - headerH + "px"
        }, 1200, 'easeInOutExpo');

        event.preventDefault();
    });    

   
});

$('#star1').click(function(){
    $('#star').val(1);
    toggle_star(1);
});

$('#star2').click(function(){
    $('#star').val(2);
    toggle_star(2);
});

$('#star3').click(function(){
    $('#star').val(3);
    toggle_star(3);
});

$('#star4').click(function(){
    $('#star').val(4);
    toggle_star(4);
});

$('#star5').click(function(){
    $('#star').val(5);
    toggle_star(5);
});

function toggle_star(value){
    $('#star1,#star2,#star3,#star4,#star5').css('color', '#333');
    var selector = '';
    for(a = 1; a <= value; a++){
        selector+= '#star'+a;
        if(a != value){
            selector+= ',';
        }
    }
    $(selector).css('color', '#5a88ca');
}


$('.plus').click(function(){
    var obj = $(this).siblings('input.qty');
    var qty = obj.val();
    qty++;
    if(qty < 1)
    {
        return;
    }
    var dataprice = obj.data("price");
    var price = obj.data("price") * qty;
    $(this).siblings('input.qty').val(qty);
    $(this).parents("td").siblings("td.product-subtotal").children("span").html(price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    var subtotal = $('#subtotal').data("subtotal") + dataprice;
    $('#subtotal').data("subtotal", subtotal);
    $('#subtotal').html(subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    $('#total').html(subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    if(update_url !== undefined){
        $.ajax(update_url+obj.data("product")+'/'+qty);
    }
});

$('.minus').click(function(){
    var obj = $(this).siblings('input.qty');
    var qty = obj.val();
    qty--;
    if(qty < 1)
    {
        return;
    }
    var dataprice = obj.data("price");
    var price = obj.data("price") * qty;
    $(this).siblings('input.qty').val(qty);
    $(this).parents("td").siblings("td.product-subtotal").children("span").html(price.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    var subtotal = $('#subtotal').data("subtotal") - dataprice;
    $('#subtotal').data("subtotal", subtotal);

    $('#subtotal').html(subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    $('#total').html(subtotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,'));
    if(update_url !== undefined){
        $.ajax(update_url+obj.data("product")+'/'+qty);
    }
});

var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
  } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
  } 
});
}

// $(function() {

//     var $sidebar   = $("#sidebar"), 
//     $footer = $('.footer-top-area'),
//     $window    = $(window),
//     offset     = $sidebar.offset(),
//     topPadding = 0;

//     if(($sidebar).length > 0){
//         $window.scroll(function() {
//             if ($window.scrollTop() > offset.top) {
//                 $sidebar.stop().animate({
//                     marginTop: $window.scrollTop() - offset.top + topPadding
//                 });
//             } else {
//                 $sidebar.stop().animate({
//                     marginTop: 0
//                 });
//             }
//         });
//     }
    
// });

$( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      //values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] ); //+ " - $" + ui.values[ 1 ] );
    }
});
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) );// +
     // " - $" + $( "#slider-range" ).slider( "values", 1 ) );
 } );