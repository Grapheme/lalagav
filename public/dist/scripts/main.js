console.log("'Allo 'Allo!"),$(function(){function t(){l=setInterval(function(){var t=n.index(n.filter(".active")),e=n.size()-1;t>=e?n.first().click():n.eq(t+1).click()},c)}function e(t){f.css({left:t}),t>=0?h.fadeOut():h.fadeIn(),-1*g/2>=t?p.fadeOut():p.fadeIn(),v=parseInt(t/m*-1)}function a(){m=Math.round(d.width()/100*32.5),goodsMargin=Math.round(d.width()/100*.625),u.width(m),u.css({"margin-left":goodsMargin,"margin-right":goodsMargin}),u.each(function(){g+=$(this).outerWidth(!0)}),f.width(Math.round(g)),f.css({"margin-left":-goodsMargin}),f.css({left:-1*v*(m+2*goodsMargin)})}var i=$(".slider-wrapper"),n=i.find(".dots a"),o=i.find(".slider-list li"),r=i.next(".thumbs").find(".thumb"),s=n.add(r),l=0,c=1e4;s.click(function(e){if(e.preventDefault(),!$(this).is(".active")){var a=s.index($(this));s.removeClass("active"),$(this).addClass("active"),o.removeClass("active"),o.eq(a).addClass("active"),clearInterval(l),t()}}),s.eq(0).click();var d=$(".goods-list-wrapper"),f=d.find(".goods-list"),u=f.find(".unit"),p=d.find(".right-arrow"),h=d.find(".left-arrow"),v=(p.add(h),0),g=0,m=0;goodsMargin=0,left=0,p.click(function(t){t.preventDefault();var a=m+2*goodsMargin;left-=a,e(left)}),h.click(function(t){t.preventDefault();var a=m+2*goodsMargin;left+=a,e(left)}),a(),p.click(),$(window).resize(function(){a()})}),$(function(){function t(t){console.log(t),$.ajax({type:"POST",url:t,data:a.serialize(),success:function(t){i.html(t),e()}})}function e(){i.find(".pagination a").click(function(e){var a=$(this).attr("href");t(a),e.preventDefault()})}var a=$("form.filters"),i=$(".catalog-list");a.change(function(){var e=$(this).attr("action");t(e)}),e();var n=$(".catalog-detail .btn.buy"),o=$(".catalog-detail .slider-wrapper"),r=$("header .cart");n.click(function(t){t.preventDefault();var e,a=o.clone(),i=o.position(),n=r.position(),s=$(this).attr("data-href"),l=$(this).attr("data-id"),c={goods:[{id:l,amount:1}]};a.width(o.width()),a.addClass("fly").insertBefore(o),a.css({top:i.top,left:i.left}),setTimeout(function(){a.css({top:0-a.height()/2,left:n.left-a.width()/2}).addClass("end"),setTimeout(function(){parseInt(r.find(".count").text());a.remove()},500)},1),$.ajax({type:"POST",url:s,data:c,dataType:"json",success:function(t){1==t.status&&(e=t.goodsCount,r.find(".count").text(e))}})});var s=window.location.hash||null;s&&"order-final"===s.split("#")[1]&&($(".popup-bg").show(),$(".popup.order-final").show(),$(".popup.order-final .close").click(function(t){t.preventDefault(),$(".popup.order-final").fadeOut(200,function(){$(".popup-bg").slideUp(300)})}))});var validator;$(function(){function t(){f={goods:[]},c.each(function(){f.goods.push({id:$(this).attr("data-id"),hash:$(this).attr("hash"),amount:$(this).val()})}),console.log(f),e()}function e(){var t=s.attr("data-action");$.ajax({type:s.attr("data-method"),url:t,data:f,dataType:"json",success:function(t){1==t.status&&$(".total .number").text(t.fullsumm),t.items.forEach(function(t){var e=s.find("tr.hash-"+t.hash);e.find(".current-total .number").text(t.summ),e.find(".count input").attr("data-price").text(t.price)})}})}function a(){var t=window.location.hash||null;t?t.split("#")[1]&&(v=t):v="#n-1",r(v)}function i(){if(Modernizr.localstorage&&localStorage.getItem("formstate")){var t=JSON.parse(localStorage.getItem("formstate"));t.forEach(function(t){l.find("[name="+t.name+"]").each(function(){"radio"==$(this).attr("type")?$(this).filter("[value="+t.value+"]").prop("checked",!0):$(this).val(t.value)})})}}function n(){var t=JSON.parse(localStorage.getItem("steps"));t.forEach(function(t){p.filter("[href="+t+"]").addClass("enabled")})}function o(t){if(localStorage.getItem("steps")){var e=JSON.parse(localStorage.getItem("steps"));-1==e.indexOf(t)&&(e.push(t),localStorage.setItem("steps",JSON.stringify(e)))}}function r(t){if(l.valid()){u.removeClass("visible");var e=u.filter("."+t.split("#")[1]);e.addClass("visible"),o(t),p.removeClass("active").filter("[href="+t+"]").addClass("active enabled")}}var s=$("table.cart-goods-list"),l=$("form.cart-detail");if(s.size()){var c=s.find(".count input"),d=s.find(".del a"),f=[];c.change(function(){t()}),d.click(function(e){e.preventDefault();var a=$(this).closest("tr"),i=a.find(c);a.animate({height:0,opacity:0},300,function(){i.val(-1),t(),a.remove()})})}$("a.new-window").click(function(t){t.preventDefault();var e="scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=957,height=522,left=100,top=150";window.open($(this).attr("href"),"how-to",e)}),validator=l.validate({rules:{name:"required",email:{required:!0,email:!0},address:"required",pay_type:"required",tel:"required"},messages:{name:"Обязательное поле",email:{required:"Обязательное поле",email:"Неверный формат. Попробуйте еще"},address:"Обязательное поле",pay_type:"Выберите способ оплаты",tel:"Обязательное поле"}});var u=l.find("> section"),p=l.find(".bar.top a"),h=l.find("a.btn.next");a();var v="#n-1";if(l.find("> section:not(.n-1) :input").on("input change",function(){var t=l.find("> section:not(.n-1)").find(":input, input").serializeArray();console.log(t),Modernizr.localstorage&&localStorage.setItem("formstate",JSON.stringify(t)),$(this).is("[name=pay_type]")&&l.valid()&&$("#pay_type-error").remove()}),i(),Modernizr.localstorage)if(localStorage.getItem("steps"))n(),console.log(localStorage.getItem("steps"));else{var g=["#n-1"];localStorage.setItem("steps",JSON.stringify(g))}h.click(function(t){t.preventDefault();var e=p.filter(".active").next("img").next("a").attr("href");console.log(p.filter(".active").next("img").next("a")),l.valid()&&(window.location=e)}),p.click(function(t){if(t.preventDefault(),$(this).hasClass("enabled")){var e=$(this).attr("href");l.valid()&&(window.location=e)}}),$(window).on("hashchange",function(){a()})});