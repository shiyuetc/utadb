function closeAlert() {
	for (var i = 0; i < $(".alert").length; i++) {
		$(".alert").fadeOut('fast').queue(function () {
			$(".alert").remove();
		});
	}
}

// セクションのトグル用スクリプト
function toggleSection(head) {
	var head = $(head);
	var toggle = head.find('.section-toggle')
	var target = head.parent().find('.contents');
	toggle.toggleClass('hidden');
	target.slideToggle();
}

function updateUserStatuses(user) {
	var statusCountElements = document.getElementsByClassName('status-count');
	statusCountElements[0].textContent = (user.stacked_count + user.training_count + user.mastered_count) + '曲';
	statusCountElements[1].textContent = user.mastered_count + '曲';
	statusCountElements[2].textContent = user.training_count + '曲';
	statusCountElements[3].textContent = user.stacked_count + '曲';
}
