console.log("'Allo 'Allo!"),$(function(){function t(){s=setInterval(function(){var t=n.index(n.filter(".active")),e=n.size()-1;t>=e?n.first().click():n.eq(t+1).click()},c)}function e(t){f.css({left:t}),t>=0?v.fadeOut():v.fadeIn(),-1*g/2>=t?p.fadeOut():p.fadeIn(),h=parseInt(t/m*-1)}function a(){m=Math.round(d.width()/100*32.5),goodsMargin=Math.round(d.width()/100*.625),u.width(m),u.css({"margin-left":goodsMargin,"margin-right":goodsMargin}),u.each(function(){g+=$(this).outerWidth(!0)}),f.width(Math.round(g)),f.css({"margin-left":-goodsMargin}),f.css({left:-1*h*(m+2*goodsMargin)})}var i=$(".slider-wrapper"),n=i.find(".dots a"),o=i.find(".slider-list li"),r=i.next(".thumbs").find(".thumb"),l=n.add(r),s=0,c=1e4;l.click(function(e){if(e.preventDefault(),!$(this).is(".active")){var a=l.index($(this));l.removeClass("active"),$(this).addClass("active"),o.removeClass("active"),o.eq(a).addClass("active"),clearInterval(s),t()}}),l.eq(0).click();var d=$(".goods-list-wrapper"),f=d.find(".goods-list"),u=f.find(".unit"),p=d.find(".right-arrow"),v=d.find(".left-arrow"),h=(p.add(v),0),g=0,m=0;goodsMargin=0,left=0,p.click(function(t){t.preventDefault();var a=m+2*goodsMargin;left-=a,e(left)}),v.click(function(t){t.preventDefault();var a=m+2*goodsMargin;left+=a,e(left)}),a(),p.click(),$(window).resize(function(){a()})}),$(function(){function t(t){console.log(t),$.ajax({type:"POST",url:t,data:a.serialize(),success:function(t){i.html(t),e()}})}function e(){i.find(".pagination a").click(function(e){var a=$(this).attr("href");t(a),e.preventDefault()})}var a=$("form.filters"),i=$(".catalog-list");a.change(function(){var e=$(this).attr("action");t(e)}),e();var n=$(".catalog-detail .btn.buy"),o=$(".catalog-detail .slider-wrapper"),r=$("header .cart");n.click(function(t){t.preventDefault();var e,a=o.clone(),i=o.position(),n=r.position(),l=$(this).attr("data-href"),s=$(this).attr("data-id"),c={goods:[{id:s,amount:1}]};a.width(o.width()),a.addClass("fly").insertBefore(o),a.css({top:i.top,left:i.left}),setTimeout(function(){a.css({top:0-a.height()/2,left:n.left-a.width()/2}).addClass("end"),setTimeout(function(){parseInt(r.find(".count").text());a.remove()},500)},1),$.ajax({type:"POST",url:l,data:c,dataType:"json",success:function(t){1==t.status&&(e=t.goodsCount,r.find(".count").text(e))}})});var l=window.location.hash||null;l&&"order-final"===l.split("#")[1]&&($(".popup-bg").show(),$(".popup.order-final").show(),$(".popup.order-final .close").click(function(t){t.preventDefault(),$(".popup.order-final").fadeOut(200,function(){$(".popup-bg").slideUp(300)})}))});var validator;$(function(){function t(t){var a=t.find(".count input");u={good:{id:a.attr("data-id"),hash:a.attr("name"),amount:a.val()}},e()}function e(){var t=s.attr("data-action");$.ajax({type:s.attr("data-method"),url:t,data:u,dataType:"json",success:function(t){1==t.status&&$(".total .number").text(t.fullsumm),t.items.forEach(function(t){var e=s.find("tr.hash-"+t.hash);e.find(".current-total .number").text(t.summ),e.find(".count input").attr("data-price",t.price)})}})}function a(){var t=window.location.hash||null;t?t.split("#")[1]&&(g=t):g="#n-1",l(g)}function i(){if(Modernizr.localstorage&&localStorage.getItem("formstate")){var t=JSON.parse(localStorage.getItem("formstate"));t.forEach(function(t){p.filter(".n-5").find("."+t.name).html(t.value.replace(/\n\r?/g,"<br>")),console.log(t.name,t.value)});var e=p.filter(".n-5").find(".consist");e.find(".row").remove(),s.find("tr").each(function(){{var t=$(this).find("td.title").text(),a=$(this).find("td.count input").val(),i=$(this).find("td.count input").attr("data-price");$(this).find("td.сurrent-total .number").text()}e.append('<div class="row">               <div class="key">'+t+'</div>               <div class="val">'+a+" шт. X "+i+" РУБ.-</div>             </div>")});var a=c.find(".total").text(),i=p.find(".pay-types input:checked").attr("data-service-price")||0,n=parseInt(a.replace(/\s/g,""))+parseInt(i);p.filter(".n-5").find(".total-conf .full-summ .val").text(a),p.filter(".n-5").find(".total-conf .service-summ .val").text(i+" руб.-"),p.filter(".n-5").find(".total-conf .numbers").text(n+" руб.-")}}function n(){if(Modernizr.localstorage&&localStorage.getItem("formstate")){var t=JSON.parse(localStorage.getItem("formstate"));t.forEach(function(t){c.find("[name="+t.name+"]").each(function(){"radio"==$(this).attr("type")?$(this).filter("[value="+t.value+"]").prop("checked",!0):$(this).val(t.value)})}),i()}}function o(){var t=JSON.parse(localStorage.getItem("steps"));t.forEach(function(t){v.filter("[href="+t+"]").addClass("enabled")})}function r(t){if(localStorage.getItem("steps")){var e=JSON.parse(localStorage.getItem("steps"));-1==e.indexOf(t)&&(e.push(t),localStorage.setItem("steps",JSON.stringify(e)))}}function l(t){if(c.valid()){p.removeClass("visible");var e=p.filter("."+t.split("#")[1]);e.addClass("visible"),r(t),v.removeClass("active").filter("[href="+t+"]").addClass("active enabled"),i(),e.is(".n-5")?$(".bar.bottom").slideUp():$(".bar.bottom").slideDown()}}var s=$("table.cart-goods-list"),c=$("form.cart-detail");if(s.size()){var d=s.find(".count input"),f=s.find(".del a"),u=[];d.change(function(){var e=$(this).closest("tr");t(e)}),f.click(function(e){e.preventDefault();var a=$(this).closest("tr"),i=a.find(d);a.animate({height:0,opacity:0},300,function(){i.val(-1),t(a),a.remove()})})}$("a.new-window").click(function(t){t.preventDefault();var e="scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=957,height=522,left=100,top=150";window.open($(this).attr("href"),"how-to",e)}),validator=c.validate({rules:{name:"required",email:{required:!0,email:!0},address:"required",pay_type:"required",tel:"required"},messages:{name:"Обязательное поле",email:{required:"Обязательное поле",email:"Неверный формат. Попробуйте еще"},address:"Обязательное поле",pay_type:"Выберите способ оплаты",tel:"Обязательное поле"}});var p=c.find("> section"),v=c.find(".bar.top a"),h=c.find("a.btn.next");a();var g="#n-1";if(c.find("> section:not(.n-1) :input").on("input change",function(){var t=c.find("> section:not(.n-1)").find(":input, input").serializeArray();console.log(t),Modernizr.localstorage&&localStorage.setItem("formstate",JSON.stringify(t)),$(this).is("[name=pay_type]")&&c.valid()&&$("#pay_type-error").remove()}),n(),Modernizr.localstorage)if(localStorage.getItem("steps"))o(),console.log(localStorage.getItem("steps"));else{var m=["#n-1"];localStorage.setItem("steps",JSON.stringify(m))}h.click(function(t){t.preventDefault();var e=v.filter(".active").next("img").next("a").attr("href");console.log(v.filter(".active").next("img").next("a")),c.valid()&&(window.location=e)}),v.click(function(t){if(t.preventDefault(),$(this).hasClass("enabled")){var e=$(this).attr("href");c.valid()&&(window.location=e)}}),$(window).on("hashchange",function(){a()})});