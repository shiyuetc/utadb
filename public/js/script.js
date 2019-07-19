// アラートの閉じるスクリプト
function closeAlert(alert) {
	var alert = $(alert).parent();
	if (!alert.hasClass('closing')) {
		alert.addClass('closing');
		alert.slideToggle();
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

// 状態管理数を最新の状態に更新するスクリプト
function updateUserStatuses(user) {
	var statusCountElements = document.getElementsByClassName('status-count');
	statusCountElements[0].textContent = user.record_count + '件';
	statusCountElements[1].textContent = (user.stacked_count + user.training_count + user.mastered_count) + '曲';
	statusCountElements[2].textContent = user.mastered_count + '曲';
	statusCountElements[3].textContent = user.training_count + '曲';
	statusCountElements[4].textContent = user.stacked_count + '曲';
}
