$(function() {
  
  var $formFilters = $('form.filters'),
      $catList = $('.catalog-list');
  
  $formFilters.change(function(){
    var url = $(this).attr('action');
    postFilters(url);
  });
  
  attachAListner();
  
  function postFilters(url) {
    console.log(url)
    $.ajax({
      type: "POST", //must be POST
      url: url,
      data: $formFilters.serialize(),
      success: function(data){
        $catList.html(data);
        attachAListner();
      }
    });
  };
  
  function attachAListner() {
    $catList.find('.pagination a').click(function(e){
      var url = $(this).attr('href');
      postFilters(url);
      e.preventDefault();
    });
  }
  
  var $buyBtn = $('.catalog-detail .btn.buy');
  var $visual = $('.catalog-detail .slider-wrapper');
  var $cart = $('header .cart');
  
  $buyBtn.click(function(e){
    e.preventDefault();
    var $clone = $visual.clone();
    var pos = $visual.position();
    var cartPos = $cart.position();
    var href = $(this).attr('href');
    var id = $(this).attr('data-id');
    var counter;

    $clone.width($visual.width());
    //$clone.height($visual.height());
    $clone.addClass('fly').insertBefore($visual);
    $clone.css({
      top: pos.top,
      left: pos.left
    });
    setTimeout(function(){
      $clone.css({
        top: 0-($clone.height()/2),
        left: cartPos.left-($clone.width()/2)
      }).addClass('end');
      setTimeout(function(){
        var number = parseInt($cart.find('.count').text());
        $cart.find('.count').text(number+=1);
        $clone.remove();
      }, 500);
    }, 1)
    $.ajax({
      type: "POST",
      url: url,
      data: id,
      success: function(data){
        counter = data
        $cart.find('.count').text(counter);
      }
    });
    
  });
  
  var hash = window.location.hash || null;
  
  if(hash) {
    if (hash.split('#')[1]==='order-final') {
      $('.popup-bg').show();
      $('.popup.order-final').show();
      $('.popup.order-final .close').click(function(e){
        e.preventDefault();
        $('.popup.order-final').fadeOut(200, function(){
          $('.popup-bg').slideUp(300);
        })
      });
    }
  }
  
  
});