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
    if(element === null) {
        return false;
    }

    if(element.className.indexOf(className) < 0) {
        element.className += ' ' + className;
        element.className = element.className.trim();
        Cookie.set('luyatb', '1');
    } else {
    	Cookie.erase('luyatb');
        element.className = element.className.replace(className, '').trim();
    }
};

var removeClassFromElements = function (elements, className) {
    for(var i = 0; i < elements.length; i++) {
        elements[i].className = elements[i].className.replace(className, '').trim();
    }
};

/**
 * @see https://developers.livechatinc.com/blog/setting-cookies-to-subdomains-in-javascript/
 */
var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days) {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      } else {
         expires = "";
      }
      
      host = location.host;
      if (host.split('.').length === 1) {
         document.cookie = name+"="+value+expires+"; path=/";
      } else {
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
	   Cookie.set(name, '0', -1);
   }
};

(function() {
	v = Cookie.get('luyatb');
	if (v==1) {
		toggleLuyaToolbar();
	}
})();