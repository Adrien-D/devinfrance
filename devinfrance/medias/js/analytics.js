Raphael.fn.drawGrid_background = function (max,x, y, w, h,Y,H, color, horizontal_range) {
    color = color || "#000";
    var path = ["M", Math.round(x) + .5, Math.round(y) + .5, "L", Math.round(x + w) + .5, Math.round(y) + .5, Math.round(x + w) + .5, Math.round(y + h) + .5, Math.round(x) + .5, Math.round(y + h) + .5, Math.round(x) + .5, Math.round(y) + .5];
    if (max != 0) {
    	var ii = Math.round(-(y+ .5 - H)/Y);
    } else {
    	var ii = 5;
    	Y = Y/ii;
    }
    
   for (var j = 0; j < ii; j ++) {
    	if (((j%horizontal_range) == 0) && (j != 0)) {
    		var yscale = Math.round(H - (Y * j)),
    			hor = "M"+(x)+" "+yscale+"L"+(x+w)+" "+yscale;
    		path = path.concat(hor);
    	}
    }
    return this.path(path.join(",")).attr({stroke: color});
};

function MAX(data) {
	var max = 0;
	var int = 0;
	for (var j = 0; j < data.length; j++) {
		int = Math.max.apply(Math, data[j]);
		max = Math.max(max,int);
	}
	return max;
}

function Ymargin(max,height, bottommargin, topmargin) {
		if (max == 0) {
			return (height - bottommargin - topmargin);
		} else {
			return ((height - 3*bottommargin - topmargin) / max);
		}
}

function Horizontal_Range(max){
	if(max<7){return 1;}
    else if((max>=7) && (max < 30)){return 5;}
    else if ((max >= 30) && (max < 60)){return 10;}
    else if ((max >= 60) && (max < 300)){return 50;}
    else if ((max >= 300) && (max < 600)){return 100;}
    else if ((max >= 600) && (max < 1200)){return 200;}
    else if ((max >= 1200) && (max < 3000)){return 500;}
    else if ((max >= 3000) && (max < 6000)){return 1000;}
    else if ((max >= 6000) && (max < 12000)){return 2000;}
    else if ((max >= 12000) && (max < 30000)){return 5000;}
    else {return 10000;}
}

$(function () {
    $(".tableau").css({
        position: "absolute",
        left: "-9999em",
        top: "-9999em"
    });
});

window.onload = function (){
    function getAnchors(p1x, p1y, p2x, p2y, p3x, p3y) {
        var l1 = (p2x - p1x) / 2,
            l2 = (p3x - p2x) / 2,
            a = Math.atan((p2x - p1x) / Math.abs(p2y - p1y)),
            b = Math.atan((p3x - p2x) / Math.abs(p2y - p3y));
        a = p1y < p2y ? Math.PI - a : a;
        b = p3y < p2y ? Math.PI - b : b;
        var alpha = Math.PI / 2 - ((a + b) % (Math.PI * 2)) / 2,
            dx1 = l1 * Math.sin(alpha + a),
            dy1 = l1 * Math.cos(alpha + a),
            dx2 = l2 * Math.sin(alpha + b),
            dy2 = l2 * Math.cos(alpha + b);
        return {
            x1: p2x - dx1,
            y1: p2y + dy1,
            x2: p2x + dx2,
            y2: p2y + dy2
        };
    }
    
    var Nb_graph = 0,
    	Nb_courbe = 0,
    	graph = [];
	$(".tableau").each(function() {
		graph[Nb_graph] = [];
		Nb_courbe = 0;
		var xAxis = [],
    		labels = [],
    		data = [],
    		legend = [];
		$(this).find(".xAxis li").each(function () {
	        xAxis.push($(this).html());
	    });
	    
	    $(this).find('.Labels li').each(function() {
	    	labels.push($(this).html());
	    });
	    
	    $(this).find('.data ul').each(function() {
	    	data[Nb_courbe] = [];
	    	legend[Nb_courbe]= $(this).attr("data-legend");
	    	$(this).find("li").each(function(){
	    		data[Nb_courbe].push($(this).html());
	    	});
	    	Nb_courbe ++;
	    });
	    graph[Nb_graph].push(xAxis);
	    graph[Nb_graph].push(labels);
	    graph[Nb_graph].push(data);
	    graph[Nb_graph].push(legend);
	    Nb_graph ++;
	});
	
	var id = [];
	$(".image").each(function(){
		id.push(this.id);
	});
	
	var height = 250,
		width = 900,
		leftmargin = 30,
        bottommargin = 20,
        topmargin = 50,
        flag3 = -1, flag4 = -1,Nb_couleurs = 0;
        txt = {font: '9px Helvetica, Arial', fill: "#000"},
        txt1 = {font: '13px Helvetica, Arial', fill: "#fff"},
        txt2 = {font: '20px Helvetica, Arial', fill: "#000"},
        colors = ["#339","#C00","#FC0","#09F","#390","#F06","#060","#F06","#606"];
        
	for (i = 0; i < id.length; i++) {
		var r = Raphael(id[i],width, height),
        	X = (width - leftmargin) / graph[i][0].length,
        	max = MAX(graph[i][2]),
        	Y = Ymargin(max, height, bottommargin, topmargin),
        	Range = Horizontal_Range(max);
        	
		r.drawGrid_background(max,leftmargin + X * .5 + .5, topmargin + .5 * i, width - leftmargin - X, height - topmargin - bottommargin,Y, height - bottommargin, "#999",Range);

		if (max != 0) {
			var kk = -((topmargin + .5 * i) + .5 -height + bottommargin)/Y;
		} else {
			var kk = 5; Y = Y/kk;
		}
	    for (var k = 0; k <= kk; k++) {
	    	var xlabels = 27,
				ylabels = Math.round(height - bottommargin - Y * k);
	    	if ((k%Range) == 0) {
	    		r.text(xlabels, ylabels, k);
	    	}
	    }
	    
	    for (var c = 0, cc = graph[i][0].length; c < cc; c++) {
	    	var x = Math.round(leftmargin + X * (c + .5));
			r.text(x, height - 6, graph[i][0][c]).attr(txt).toBack();
	    }
	    
	    for (var d = 0; d < graph[i][2].length; d ++) {
	    	var color = colors[(Nb_couleurs)%10],
		    	flag = 0,
		    	flag2 = 0;
	    	var path = r.path().attr({stroke: color, "stroke-width": 4, "stroke-linejoin": "round"}),
	    		bgp = r.path().attr({stroke: "none", opacity: .3});
	    	var p, bgpp;
	    	Nb_couleurs ++;
	    	
	    	var leg = d*100 + 100
	    	r.path(["M",leg-55,35,"L",leg-35,35]).attr({stroke: color, "stroke-width": 4, "stroke-linejoin": "round"});
    		var dot2 = r.circle(leg-45, 35, 4).attr({fill: "#333", stroke: color, "stroke-width": 2});
    		var legende_courbe = r.text(leg,35, graph[i][3][d]);
	    	
	    	for (var g = 0; g < graph[i][0].length; g++) {
	    		var x = Math.round(leftmargin + X * (g + .5));
	    		var y = Math.round(height - bottommargin - Y * graph[i][2][d][g]);
	    		var dot = r.circle(x, y, 4).attr({fill: "#333", stroke: color, "stroke-width": 2});
	    		
		    	if ((g==0) || (g == (graph[i][0].length)-1) || ((graph[i][2][d][g] == Math.max.apply(Math, graph[i][2][d])) && (flag == 0)) || ((graph[i][2][d][g] == Math.min.apply(Math, graph[i][2][d])) && (flag2 == 0))) {
		    		var t = r.text((x+(5*Math.pow(-1, d))), (y-10), graph[i][2][d][g]).attr({fill :color});
		    		if (graph[i][2][d][g] == Math.max.apply(Math, graph[i][2][d])) {
		    			flag = 1;
		    		}
		    		if (graph[i][2][d][g] == Math.min.apply(Math, graph[i][2][d])) {
		    			flag2 = 1;
		    		}
		    	} else {
		    		var t = r.text((x+5), (y-10), graph[i][2][d][g]).attr({fill :"none"});
		    	}
		    	if (!g) {
			        p = ["M", x, y, "C", x, y];
			        bgpp = ["M", leftmargin + X * .5, height - bottommargin, "L", x, y, "C", x, y];
			    }
					    
			    if (g && g < graph[i][0].length) {
		            var X0 = Math.round(leftmargin + X * (g - .5)),
		                X2 = Math.round(leftmargin + X * (g + 1.5));
		              
	                var Y0 = Math.round(height - bottommargin - (Y * graph[i][2][d][g - 1]));
	                
	                if (g != (graph[i][0].length)-1) {
	                	Y2 = Math.round(height - bottommargin - (Y * graph[i][2][d][g + 1]));
	                } else {
	                	Y2 = Math.round(height - bottommargin - (Y * graph[i][2][d][g]));
	                }
	                
	                var a = getAnchors(X0, Y0, x, y, X2, Y2);
		            	p = p.concat([a.x1, a.y1, x, y, a.x2, a.y2]);
		            	bgpp = bgpp.concat([a.x1, a.y1, x, y, a.x2, a.y2]);
	            }
			    
			    var Lab2 = r.text(x-5, y-20, graph[i][2][d][g]).attr({font: '30px Helvetica, Arial', fill : "#fff"}).hide();
			    var Lab = r.text(x-5, y-20, graph[i][2][d][g]).attr({font: '25px Helvetica, Arial', fill : color}).hide();
	    		var blanket = r.set();
	    		blanket.push(r.rect(leftmargin + (X * g), y-(X/2)-3, X, X+3).attr({stroke: "none", fill: "#fff", opacity: 0}));
				var rect = blanket[blanket.length - 1];
				(function (x, y, data, lbl, dot, Lab, Lab2, t) {
					rect.hover(function () {dot.attr("r", 6);
						Lab.show();
						Lab2.show();
						t.hide();
						},
	   
						function () {
							dot.attr("r", 4);
							Lab.hide();
							Lab2.hide();
							t.show();
					});
				})
				(x, y,graph[i][2][d][g], graph[i][1][g], dot, Lab, Lab2, t);
	    	}
		    p = p.concat([x, y, x, y]);
		    bgpp = bgpp.concat([x, y, x, y, "L", x, height - bottommargin, "z"]);
		    path.attr({path: p});
		    bgp.attr({path: bgpp});
		    
		    blanket.toFront();
		    }  
		} 
	}