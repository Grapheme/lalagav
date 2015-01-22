$(function() {
  function prepareJson() {
    $countInputs.each(function(){
      items.push({
        id: $(this).attr('name'),
        amount: $(this).val()
      });
    });
    sendJson();
  };
  
  function sendJson() {
    var url = $form.attr('action');
    $.ajax({
      type: $form.attr('method'),
      url: url,
      data: items,
      dataType: 'json',
      complete: function(data){
        console.log(data)
      }
    });
  }
  
  var $cartGoodsList = $('table.cart-goods-list');
  
  if ($cartGoodsList.size()) {
    var $form = $('.form.cart-detail'),
        $countInputs = $cartGoodsList.find('.count input'),
        $dels = $cartGoodsList.find('.del a'),
        items = [];

    $countInputs.change(function(){
      prepareJson();
    });
    
    $dels.click(function(e){
      e.preventDefault();
      var $item = $(this).closest('tr'),
          $input = $item.find($countInputs);
      
      $item.animate({
        height: 0,
        opacity: 0,
      }, 300, function(){
        $input.val(-1);
        prepareJson();
        $item.remove();
      });
    });
  };
  
  $('a.new-window').click(function(e){
    e.preventDefault();
    var params = 'scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,' +
    'width=957,height=522,left=100,top=150';
    window.open($(this).attr('href'), 'how-to', params);  
  });
  
});