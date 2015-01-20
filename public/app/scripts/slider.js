$(function() {
  var $sliderWrapper = $('.slider-wrapper'),
      $dots = $sliderWrapper.find('.dots a'),
      $slides = $sliderWrapper.find('.slider-list li'),
      $thumbs = $sliderWrapper.next('.thumbs').find('.thumb'),
      $dots_and_thumbs = $dots.add($thumbs),
      _interval = 0,
      _delay = 10*1000;
  
  $dots_and_thumbs.click(function(e){
    e.preventDefault();
    if (!$(this).is('.active')) {
      var _index = $dots_and_thumbs.index($(this));
      
      $dots_and_thumbs.removeClass('active');
      $(this).addClass('active');
      
      $slides.removeClass('active');
      $slides.eq(_index).addClass('active');
      clearInterval(_interval);
      startNext();
    };
  });
  
  $dots_and_thumbs.eq(0).click();
  
  function startNext() {
    _interval = setInterval(function(){
      var _index = $dots.index($dots.filter('.active'));
      var _size = $dots.size()-1;
      if (_index >= _size) {
        $dots.first().click();
      } else {
        $dots.eq(_index+1).click();
      };
    }, _delay);
  }
  
  var $goodsListWrapper = $('.goods-list-wrapper'),
      $goodsList = $goodsListWrapper.find('.goods-list'),
      $goods = $goodsList.find('.unit'),
      $rightArrow = $goodsListWrapper.find('.right-arrow'),
      $leftArrow = $goodsListWrapper.find('.left-arrow'),
      $arrows = $rightArrow.add($leftArrow),
      curSlide = 0,
      goodsListWidth = 0,
      goodsWidth = 0;
      goodsMargin = 0,
      left = 0;
  
  $rightArrow.click(function(e){
    e.preventDefault();
    var new_left = goodsWidth+goodsMargin*2
    left -= new_left
    showOrHideBtns(left);
  });
  
  $leftArrow.click(function(e){
    e.preventDefault();
    var new_left = goodsWidth+goodsMargin*2
    left += new_left
    showOrHideBtns(left);
  });
  
  function showOrHideBtns(left) {
    $goodsList.css({
      left: left
    });
    if (left >= 0) {
      $leftArrow.fadeOut();
    } else {
      $leftArrow.fadeIn();
    }
    if (left <= (goodsListWidth*-1)/2) {
      $rightArrow.fadeOut();
    } else {
      $rightArrow.fadeIn();
    }
    curSlide = parseInt((left/goodsWidth)*-1);
  }
  
  function resizeSlider() {
    goodsWidth = Math.round(($goodsListWrapper.width()/100)*32.5);
    goodsMargin = Math.round(($goodsListWrapper.width()/100)*(1.25/2));
    $goods.width(goodsWidth);
    $goods.css({
      'margin-left': goodsMargin,
      'margin-right': goodsMargin
    });
    $goods.each(function(){
      goodsListWidth+=$(this).outerWidth(true);
    });
    $goodsList.width(Math.round(goodsListWidth));
    $goodsList.css({
      'margin-left': -goodsMargin
    });
    $goodsList.css({
      left: -1*(curSlide*(goodsWidth+goodsMargin*2))
    });
  };
  
  
  
  resizeSlider();
  $rightArrow.click();
  $(window).resize(function() {
    resizeSlider();
  });
});