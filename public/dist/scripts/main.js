console.log("'Allo 'Allo!"),$(function(){function t(){l=setInterval(function(){var t=e.index(e.filter(".active")),i=e.size()-1;t>=i?e.first().click():e.eq(t+1).click()},s)}function i(t){d.css({left:t}),t>=0?g.fadeOut():g.fadeIn(),-1*p/2>=t?h.fadeOut():h.fadeIn(),v=parseInt(t/m*-1)}function n(){m=Math.round(f.width()/100*32.5),goodsMargin=Math.round(f.width()/100*.625),u.width(m),u.css({"margin-left":goodsMargin,"margin-right":goodsMargin}),u.each(function(){p+=$(this).outerWidth(!0)}),d.width(Math.round(p)),d.css({"margin-left":-goodsMargin}),d.css({left:-1*v*(m+2*goodsMargin)})}var a=$(".slider-wrapper"),e=a.find(".dots a"),o=a.find(".slider-list li"),r=a.next(".thumbs").find(".thumb"),c=e.add(r),l=0,s=1e4;c.click(function(i){if(i.preventDefault(),!$(this).is(".active")){var n=c.index($(this));c.removeClass("active"),$(this).addClass("active"),o.removeClass("active"),o.eq(n).addClass("active"),clearInterval(l),t()}}),c.eq(0).click();var f=$(".goods-list-wrapper"),d=f.find(".goods-list"),u=d.find(".unit"),h=f.find(".right-arrow"),g=f.find(".left-arrow"),v=(h.add(g),0),p=0,m=0;goodsMargin=0,left=0,h.click(function(t){t.preventDefault();var n=m+2*goodsMargin;left-=n,i(left)}),g.click(function(t){t.preventDefault();var n=m+2*goodsMargin;left+=n,i(left)}),n(),h.click(),$(window).resize(function(){n()})}),$(function(){function t(t){console.log(t),$.ajax({type:"POST",url:t,data:n.serialize(),success:function(t){a.html(t),i()}})}function i(){a.find(".paginator a").click(function(i){var n=$(this).attr("href");t(n),i.preventDefault()})}var n=$("form.filters"),a=$(".catalog-list");n.change(function(){var i=$(this).attr("action");t(i)}),i()}),$(function(){function t(){e.each(function(){r.push({id:$(this).attr("name"),amount:$(this).val()})}),i()}function i(){var t=a.attr("action");$.ajax({type:a.attr("method"),url:t,data:r,dataType:"json",complete:function(t){console.log(t)}})}var n=$("table.cart-goods-list");if(n.size()){var a=$(".form.cart-detail"),e=n.find(".count input"),o=n.find(".del a"),r=[];e.change(function(){t()}),o.click(function(i){i.preventDefault();var n=$(this).closest("tr"),a=n.find(e);n.animate({height:0,opacity:0},300,function(){a.val(-1),t(),n.remove()})})}$("a.new-window").click(function(t){t.preventDefault();var i="scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=957,height=522,left=100,top=150";window.open($(this).attr("href"),"how-to",i)})});