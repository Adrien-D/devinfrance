function refresh_display() {
	document.getElementById('display').innerHTML = document.getElementById('block[value]').value;
}

function inverse_grey_color(name) {
	var elt = document.getElementById('link_'+name);
	var mingrey = new RegExp("_mingrey.jpeg");
	var min = new RegExp("_min.jpeg");
	var str = elt.src;
	if (mingrey.test(elt.src)) {
		elt.src = str.replace(mingrey, "_min.jpeg");
	} else if (min.test(elt.src)) {
		elt.src = str.replace(min, "_mingrey.jpeg");
	}
}

function show_dev(name, count, id) {
	document.getElementById('link_'+name+id).style.borderColor = "#00007F";
	if (count != "") {
		document.getElementById('info_dev').innerHTML = "<h5>?</h5> "+name+" : "+count+" dev";
	} else {
		document.getElementById('info_dev').innerHTML = "<h5>?</h5> "+name;
	}
}

function hide_dev(name, id) {
	document.getElementById('link_'+name+id).style.borderColor = "#0000FF";
	document.getElementById('info_dev').innerHTML = "";
}

window.onload = function (){
	
		var title_menu = document.getElementById('title_menu').innerHTML;
		var height = document.getElementById('fixed_menu').offsetHeight;
		var width = document.getElementById('title_menu').offsetWidth;
		var inscription_top = 0;
		if (document.getElementById('inscription_fixed')) {
			inscription_top = $('#inscription_fixed').offset().top;
			
			if ($(window).scrollTop() > inscription_top - height) {
				document.getElementById('inscription_fixed').className = "cadre_inscription_fixed";
				document.getElementById('inscription_fixed').style.top = height+3+"px";
			} else {
				document.getElementById('inscription_fixed').className = "cadre_inscription";
			}
		}
					
		
		if (document.getElementById('count_title').innerHTML) {
			var count_title = document.getElementById('count_title').innerHTML;
			var positionElementInPage = $('#count_title').offset().top + 104 ;
			
			if ($(window).scrollTop() > positionElementInPage) {
				document.getElementById('title_menu').innerHTML = count_title;
				document.getElementById('title_menu').style.fontSize = "30px";
				document.getElementById('fixed_menu').style.height = height+"px";
				document.getElementById('title_menu').style.width = width+"px";
			} else {
				document.getElementById('title_menu').innerHTML = title_menu;
				document.getElementById('title_menu').style.fontSize = "20px";
			}
			
			$(window).scroll(
					function() {
							if ($(window).scrollTop() > positionElementInPage) {
								document.getElementById('title_menu').innerHTML = count_title;
								document.getElementById('title_menu').style.fontSize = "30px";
								document.getElementById('fixed_menu').style.height = height+"px";
								document.getElementById('title_menu').style.width = width+"px";
							} else {
								document.getElementById('title_menu').innerHTML = title_menu;
								document.getElementById('title_menu').style.fontSize = "20px";
							}
							if (document.getElementById('inscription_fixed')) {
								if ($(window).scrollTop() > inscription_top - height) {
									document.getElementById('inscription_fixed').className = "cadre_inscription_fixed";
									document.getElementById('inscription_fixed').style.top = height+3+"px";
								} else {
									document.getElementById('inscription_fixed').className = "cadre_inscription";
								}
							}
					});
		}
	
};