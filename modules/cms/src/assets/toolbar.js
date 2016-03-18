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
    } else {
        element.className = element.className.replace(className, '').trim();
    }
};

var removeClassFromElements = function (elements, className) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].className = elements[i].className.replace(className, '').trim();
    }
};