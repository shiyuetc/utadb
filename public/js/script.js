function closeAlert() {
	for (var i = 0; i < $(".alert").length; i++) {
		$(".alert").fadeOut('fast').queue(function() {
			$(".alert").remove();
		});
	}
}