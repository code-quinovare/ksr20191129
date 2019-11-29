var getAlert = function(a, b) {
		var c = $('<div class="popUp-div">' + '<div class="popUp-content alertDiv">' + '<div class="popUp-body">' + '<div class="alert-text">' + a.text + '</div>' + '</div>' + '<div class="popUp-foot">' + '<div class="btns-wrap">' + '</div>' + '</div>' + '</div>' + '</div>');
		if (a.alert == 1) {
            c.find(".btns-wrap").append('<div class="img-alert"><img style="margin: 0 auto; width: 50%;height: 50%;" src="img/images/regsuccess.png"></div>');
			c.find(".btns-wrap").append('<div class="btn-alert submitok">确认</div>');
			c.find(".submitok").off("click").on("click", function() {
				window.location = b
			})
		} else if (a.alert == 0) {
			c.find(".btns-wrap").append('<div class="btn-alert submitok">确认</div>');
			c.find(".submitok").off("click").on("click", function() {
				closePopUpDiv(c)
			})
		}else if(a.alert==2){
			c.find(".btns-wrap").append('<div class="btn-alert submitok">确认</div>');
			c.find(".submitok").off("click").on("click", function() {
				window.location.reload();
			})
		}else if(a.alert==3){
			$(".submitok").remove();
		}
		showPopUpDiv(c)
	}
var showPopUpDiv = function(a, b) {
		b = b || $("body");
		var c = $("body").find(".bg");
		if (c.length == 0) {
			c = $("<div class='bg'></div>");
			$("body").append(c)
		}
		$(".bg").css("display", "block");
		b.append(a)
	}
var closePopUpDiv = function(a) {
		if (!a) {
			a = $("body").find(".popUp-div")
		}
		var b = $("body").find(".bg");
		a.remove();
		$(".bg").css("display", "none")
	}