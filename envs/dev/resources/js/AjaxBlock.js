var clickAjax = function(url) {
	$.ajax({
		method: "POST",
		url: url
	}).success(function(r) {
		console.log(r);
	});
};