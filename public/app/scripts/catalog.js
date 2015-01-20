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
    $catList.find('.paginator a').click(function(e){
      var url = $(this).attr('href');
      postFilters(url);
      e.preventDefault();
    });
  }
  
});