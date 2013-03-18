/*!
 * jQuery miniZoomPan 1.0
 * 2009 Gian Carlo Mingati
 * Version: 1.0 (18-JUNE-2009)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Requires:
 * jQuery v1.3.2 or later
 * 
 */
jQuery.fn.miniZoomPan = function(settings) {
	
	settings = jQuery.extend({
	sW: 10, // small image width
	sH: 10, // small image height
	lW: 20, // large image width
	lH: 20, // large image height
	frameColor: "#cecece",
	frameWidth: 1,
	loaderContent: "<img src='images/zoomlens.gif' />" // plain text or an image tag eg.: "<img src='yoursite.com/spinner.gif' />"
	}, settings);

	return this.each(function(){
		
		var div =  jQuery(this);
		div.css({width: settings.sW, height: settings.sH, border: settings.frameWidth+"px solid "+settings.frameColor}).addClass("minizoompan");
		var ig = div.children();
		ig.css({position: "relative"});
		jQuery(window).bind("load", function() {
		ig.width(settings.sW); 
		ig.height(settings.sH); 
		});
		div.css({overflow: "hidden"});
		jQuery("<span class='loader'>"+settings.loaderContent+"<\/span>").insertBefore(ig);
				
		div.mousemove(function(e){
			var divWidth = div.width();
			var divHeight = div.height();
			var igW = ig.width();
			var igH = ig.height();
			var dOs = div.offset();
			var leftPan = (e.pageX - dOs.left) * (divWidth - igW) / (divWidth+settings.frameWidth*2);
			var topPan = (e.pageY - dOs.top) * (divHeight - igH) / (divHeight+settings.frameWidth*2);
			ig.css({left: leftPan, top: topPan});			
		});    
		
		div.hover(
			function () {
				ig.css({ width: settings.lW, height: settings.lH});
				var Limg = "admin/product_picture/zoom/";
				var Simg = "admin/product_picture/";
				//var hiSrc = ig.attr("src").replace(/s.jpg/, 'l.jpg');
				var hiSrc = ig.attr("src").replace(/Simg/, Limg);
				swapImage(ig, hiSrc);
				div.children("span.loader").fadeIn(250);
			},
			function () {
				ig.css({left: "0", top: "0", width: settings.sW, height: settings.sH});
					var Limg = "admin/product_picture/zoom/";
				var Simg = "admin/product_picture/";
				//var hiSrc = ig.attr("src").replace(/s.jpg/, 'l.jpg');
				var loSrc = ig.attr("src").replace(/Limg/, Simg);
				swapImage(ig, loSrc);
				div.children("span.loader").fadeOut(250);
			}
		);
		
		function swapImage(param, uri){
			param.load(function () {
				div.children("span.loader").fadeOut(250);
			}).error(function (){
			alert("Image does not exist or its SRC is not correct.");
			}).attr('src', uri);
		}
		

		
	});	

};