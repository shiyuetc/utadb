function closeAlert() {
	for (var i = 0; i < $(".alert").length; i++) {
		$(".alert").fadeOut('fast').queue(function() {
			$(".alert").remove();
		});
	}
}

function updateUserStatuses(user) {
	var statusCountElements = document.getElementsByClassName('status-count');
  statusCountElements[0].textContent = (user.stacked_state_count + user.training_state_count + user.mastered_state_count) + '曲';
  statusCountElements[1].textContent = user.mastered_state_count + '曲';
  statusCountElements[2].textContent = user.training_state_count + '曲';
  statusCountElements[3].textContent = user.stacked_state_count + '曲';
}