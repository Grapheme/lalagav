var validator;
$(function() {
  function prepareJson($item) {
    items = {'good':[]};
    var $input = $item.find('.count input');
    //$countInputs.each(function(){
      items.good.push({
        id: $input.attr('data-id'),
        hash: $input.attr('hash'),
        amount: $input.val()
      });
    //});
    console.log(items);
    sendJson();
  };
  
  function sendJson() {
    var url = $cartGoodsList.attr('data-action');
    $.ajax({
      type: $cartGoodsList.attr('data-method'),
      url: url,
      data: items,
      dataType: 'json',
      success: function(data){
        if (data.status == true) {
          $('.total .number').text(data.fullsumm);
        }
        data.items.forEach(function(item){
          var $tr = $cartGoodsList.find('tr.hash-'+item.hash);
          $tr.find('.current-total .number').text(item.summ);
          $tr.find('.count input').attr('data-price').text(item.price);
        });
      }
    });
  }
  
  var $cartGoodsList = $('table.cart-goods-list');
  var $bigForm = $('form.cart-detail');
  
  if ($cartGoodsList.size()) {
    var //$form = $('.form.cart-detail'),
        $countInputs = $cartGoodsList.find('.count input'),
        $dels = $cartGoodsList.find('.del a'),
        items = [];

    $countInputs.change(function(){
      var $item = $(this).closest('tr');
      prepareJson($item);
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
        prepareJson($item);
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
  
  validator = $bigForm.validate({
    rules: {
      name: 'required',
      email: {
        required: true,
        email: true
      },
      address: 'required',
      pay_type: 'required',
      tel: 'required'
    },
    messages: {
      name: 'Обязательное поле',
      email: {
        required: 'Обязательное поле',
        email: 'Неверный формат. Попробуйте еще'
      },
      address: 'Обязательное поле',
      pay_type: 'Выберите способ оплаты',
      tel: 'Обязательное поле'
    }
    /*submitHandler: function(form) {
      //console.log(form);
      console.log(arguments);
    }*/
  });
  
  var $sections = $bigForm.find('> section');
  var $links = $bigForm.find('.bar.top a');
  var $nextBtn = $bigForm.find('a.btn.next');
  getHash();
  
  var section_n = '#n-1';
  
  function getHash() {
    var hash = window.location.hash || null;
    
    if(hash) {
      if (hash.split('#')[1]) {
        section_n = hash
      };
    } else {
      section_n = '#n-1';
    };
    sectionShow(section_n);
  };
  
  $bigForm.find('> section:not(.n-1) :input').on('input change', function(e){
    var state = $bigForm.find('> section:not(.n-1)').find(':input, input').serializeArray()
    console.log(state);
    if (Modernizr.localstorage) {
      localStorage.setItem('formstate', JSON.stringify(state));
    };
    if ($(this).is('[name=pay_type]')) {
      if ($bigForm.valid()) {
        $('#pay_type-error').remove();
      };
    };
  });
  
  loadState();
  
  function loadState() {
    if (Modernizr.localstorage) {
      if (localStorage.getItem('formstate')) {
        var state = JSON.parse(localStorage.getItem('formstate'));
        state.forEach(function(input){
          $bigForm.find('[name='+input.name+']').each(function(){
            if ($(this).attr('type')=='radio') {
              $(this).filter('[value='+input.value+']').prop('checked', true);
            } else {
              $(this).val(input.value);
            };
          });
        });
      };
    };
  };
  
  
  
  function loadSteps(){
    var steps = JSON.parse(localStorage.getItem('steps'));
    steps.forEach(function(step){
      $links.filter("[href="+step+"]").addClass('enabled');
    });
  };
  
  if (Modernizr.localstorage) {
    if (localStorage.getItem('steps')) {
      loadSteps()
      console.log(localStorage.getItem('steps'))
    } else {
      var steps = ['#n-1'];
      localStorage.setItem('steps', JSON.stringify(steps));
    }
  };
  
  function addStep(n) {
    if (localStorage.getItem('steps')) {
      var steps = JSON.parse(localStorage.getItem('steps'));
      if (steps.indexOf(n)==-1) {
        steps.push(n);
        localStorage.setItem('steps', JSON.stringify(steps));
      }
    }
  }
  
  function sectionShow(n) {
    if ($bigForm.valid()) {
      $sections.removeClass('visible');
      var $thisSection = $sections.filter('.'+n.split('#')[1]);
      $thisSection.addClass('visible');
      addStep(n);
      $links.removeClass('active').filter('[href='+n+']').addClass('active enabled');
    };
  };
  
  $nextBtn.click(function(e){
    e.preventDefault();
    var nextHash = $links.filter('.active').next('img').next('a').attr('href');
    console.log($links.filter('.active').next('img').next('a'))
    if ($bigForm.valid()) {
      window.location = nextHash;
    }
    //getHash();
  });
  
  $links.click(function(e){
    e.preventDefault();
    if ($(this).hasClass('enabled')) {
      var thisHash = $(this).attr('href');
      if ($bigForm.valid()) {
        window.location = thisHash;
      }
      //getHash();
    }
  });
  
  $(window).on('hashchange', function() {
    getHash();
  });
  
});