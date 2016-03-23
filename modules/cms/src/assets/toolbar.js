/* luya cms toolbar.js */

var toggleLuyaToolbar = function () {
    var e = document.getElementById('luya-cms-toolbar-wrapper');

    toggleClass(e, 'luya-cms-toolbar-wrapper--open');
};

var toggleDetails = function (source, containerId) {
    var e = document.getElementById(containerId);

    if(e.className.indexOf('luya-cms-toolbar__container--open') < 0) {
        removeClassFromElements(document.getElementsByClassName('luya-cms-toolbar__container--open'), 'luya-cms-toolbar__container--open');
        removeClassFromElements(document.getElementsByClassName('luya-cms-toolbar__container-toggler'), 'open');
    }

    toggleClass(source, 'open');
    toggleClass(e, 'luya-cms-toolbar__container--open');
};

var toggleClass = function (element, className) {
    if(element.className.indexOf(className) < 0) {
        element.className += ' ' + className;
        element.className = element.className.trim();
        setCookie('luyatb', '1', 30);
    } else {
    	document.cookie = "luyatb=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        element.className = element.className.replace(className, '').trim();
    }
};

var removeClassFromElements = function (elements, className) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].className = elements[i].className.replace(className, '').trim();
    }
};

var setCookie = function(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
};

var getCookie = function(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
};

(function() {
	v = getCookie('luyatb');
	if (v==1) {
		toggleLuyaToolbar();
	}
})();