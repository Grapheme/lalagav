console.log("'Allo 'Allo!"),$(function(){function t(){c=setInterval(function(){var t=a.index(a.filter(".active")),i=a.size()-1;t>=i?a.first().click():a.eq(t+1).click()},s)}function i(t){d.css({left:t}),t>=0?h.fadeOut():h.fadeIn(),-1*g/2>=t?p.fadeOut():p.fadeIn(),v=parseInt(t/w*-1)}function n(){w=Math.round(f.width()/100*32.5),goodsMargin=Math.round(f.width()/100*.625),u.width(w),u.css({"margin-left":goodsMargin,"margin-right":goodsMargin}),u.each(function(){g+=$(this).outerWidth(!0)}),d.width(Math.round(g)),d.css({"margin-left":-goodsMargin}),d.css({left:-1*v*(w+2*goodsMargin)})}var e=$(".slider-wrapper"),a=e.find(".dots a"),o=e.find(".slider-list li"),r=e.next(".thumbs").find(".thumb"),l=a.add(r),c=0,s=1e4;l.click(function(i){if(i.preventDefault(),!$(this).is(".active")){var n=l.index($(this));l.removeClass("active"),$(this).addClass("active"),o.removeClass("active"),o.eq(n).addClass("active"),clearInterval(c),t()}}),l.eq(0).click();var f=$(".goods-list-wrapper"),d=f.find(".goods-list"),u=d.find(".unit"),p=f.find(".right-arrow"),h=f.find(".left-arrow"),v=(p.add(h),0),g=0,w=0;goodsMargin=0,left=0,p.click(function(t){t.preventDefault();var n=w+2*goodsMargin;left-=n,i(left)}),h.click(function(t){t.preventDefault();var n=w+2*goodsMargin;left+=n,i(left)}),n(),p.click(),$(window).resize(function(){n()})}),$(function(){function t(t){console.log(t),$.ajax({type:"POST",url:t,data:n.serialize(),success:function(t){e.html(t),i()}})}function i(){e.find(".pagination a").click(function(i){var n=$(this).attr("href");t(n),i.preventDefault()})}var n=$("form.filters"),e=$(".catalog-list");n.change(function(){var i=$(this).attr("action");t(i)}),i();var a=$(".catalog-detail .btn.buy"),o=$(".catalog-detail .slider-wrapper"),r=$("header .cart");a.click(function(t){t.preventDefault();var i=o.clone(),n=o.position(),e=r.position();i.width(o.width()),i.addClass("fly").insertBefore(o),i.css({top:n.top,left:n.left}),setTimeout(function(){i.css({top:0-i.height()/2,left:e.left-i.width()/2}).addClass("end"),setTimeout(function(){var t=parseInt(r.find(".count").text());r.find(".count").text(t+=1),i.remove()},500)},1)});var l=window.location.hash||null;l&&"order-final"===l.split("#")[1]&&($(".popup-bg").show(),$(".popup.order-final").show(),$(".popup.order-final .close").click(function(t){t.preventDefault(),$(".popup.order-final").fadeOut(200,function(){$(".popup-bg").slideUp(300)})}))}),$(function(){function t(){a.each(function(){r.push({id:$(this).attr("name"),amount:$(this).val()})}),i()}function i(){var t=e.attr("action");$.ajax({type:e.attr("method"),url:t,data:r,dataType:"json",complete:function(t){console.log(t)}})}var n=$("table.cart-goods-list");if(n.size()){var e=$(".form.cart-detail"),a=n.find(".count input"),o=n.find(".del a"),r=[];a.change(function(){t()}),o.click(function(i){i.preventDefault();var n=$(this).closest("tr"),e=n.find(a);n.animate({height:0,opacity:0},300,function(){e.val(-1),t(),n.remove()})})}$("a.new-window").click(function(t){t.preventDefault();var i="scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=957,height=522,left=100,top=150";window.open($(this).attr("href"),"how-to",i)})});