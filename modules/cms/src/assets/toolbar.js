/* luya cms toolbar.js */

var toggleLuyaToolbar = function() {
	var e = document.getElementById('luya-toolbar-table');
	if (e.style.display == 'block' || e.style.display == '') {
		e.style.display = 'none';
	} else {
		e.style.display = 'block';
	}
};