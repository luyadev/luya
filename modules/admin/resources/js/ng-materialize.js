(function (angular) {
    angular.module("ui.materialize", ["ui.materialize.ngModel", "ui.materialize.collapsible", "ui.materialize.toast", "ui.materialize.sidenav", "ui.materialize.material_select", "ui.materialize.dropdown", "ui.materialize.inputfield", "ui.materialize.input_date", "ui.materialize.tabs", "ui.materialize.pagination", "ui.materialize.pushpin", "ui.materialize.parallax"]);

    angular.module("ui.materialize.ngModel", [])
        .directive("ngModel",["$timeout", function($timeout){
            return {
                restrict: 'A',
                priority: -1, // lower priority than built-in ng-model so it runs first
                link: function(scope, element, attr) {
                    scope.$watch(attr.ngModel,function(value){
                        $timeout(function () {
                            if (value){
                                element.trigger("change");
                            } else if(element.attr('placeholder') === undefined) {
                                if(!element.is(":focus"))
                                    element.trigger("blur");
                            }
                        });
                    });
                }
            }
        }]);

    angular.module("ui.materialize.collapsible", [])
        .directive("collapsible", ["$timeout", function($timeout){
          return {
            link: function(scope, element, attrs) {
              $timeout(function(){
            	// recursion  
            	scope.$on('$includeContentLoaded', function(){
            		    element.collapsible();
            	});
            	  
            	// watcher
            	scope.$watch('container.__placeholders', function(n, o) {
            		element.collapsible();
            	});
            	
            	// basic integration
            	element.collapsible();
              });
            }
          };
        }]);

    angular.module("ui.materialize.parallax", [])
        .directive("parallax", ["$timeout", function($timeout){
            return {
                link: function(scope, element, attrs) {
                    $timeout(function(){
                        element.parallax();
                    });
                }
            };
        }]);

    angular.module("ui.materialize.toast", [])
        .constant("toastConfig", {
            duration: 3000,
            rounded: "rounded"
        })
        .directive("toast", ["toastConfig", function (toastConfig) {
            return {
                scope: {
                    message: "@"
                },
                link: function (scope, element, attrs) {
                    element.bind(attrs.toast, function () {
                        var message = (angular.isDefined(scope.message)) ? scope.message : "";
                        var rounded = (angular.isDefined(attrs.rounded)) ? toastConfig.rounded : null;
                        Materialize.toast(message, toastConfig.duration, rounded);
                    });
                }
            };
        }]);

    angular.module('ui.materialize.pushpin', [])
        .directive('pushpin', [function(){
            return {
                restrict: 'AE',
                require: [
                    '?pushpinTop',
                    '?pushpinOffset',
                    '?pushpinBottom'
                ],
                link: function (scope, element, attrs) {
                    var top    = attrs.pushpinTop || 0;
                    var offset = attrs.pushpinOffset || 0;
                    var bottom = attrs.pushpinBottom || Infinity;
                    setTimeout(function () {
                        element.pushpin({top: top, offset: offset, bottom: bottom});
                    }, 0);

                }
            };
        }]);

    angular.module("ui.materialize.tabs", [])
        .directive("tabs", ["$timeout", function($timeout){
            return {
                link: function (scope, element, attrs) {
                	$timeout(function() {
                		scope.$watch('DroppableBlocksService.blocks', function(n, o) {
                			if (n.length > 0) {
                				element.tabs();
                			}
                		});
                    });
                }
            };
        }]);

    // Example: <a href="#" data-activates="nav-mobile" class="button-collapse top-nav" data-sidenav="left" data-menuwidth="500"  data-closeonclick="true">
    // data-activates is handled by the jQuery plugin.
    angular.module("ui.materialize.sidenav", [])
        .directive("sidenav", [function () {
            return {
                scope: {
                    menuwidth: "@",
                    closeonclick: "@"
                },
                link: function (scope, element, attrs) {
                    element.sideNav({
                        menuWidth: (angular.isDefined(scope.menuwidth)) ? scope.menuwidth : undefined,
                        edge: attrs.sidenav ? attrs.sidenav : "left",
                        closeOnClick: (angular.isDefined(scope.closeonclick)) ? scope.closeonclick == "true" : undefined
                    })
                }
            };
        }]);

    // This works, unless the content inside the select changes.
    angular.module("ui.materialize.material_select", [])
        .directive("materialSelect", ["$compile", "$timeout", function ($compile, $timeout) {
            return {
                link: function (scope, element, attrs) {
                    if (element.is("select")) {
                        $compile(element.contents())(scope);
                        $timeout(function () {
                            element.material_select();
                        });
                    }
                }
            };
        }]);

    /*
     Example usage, notice the empty dropdown tag in the dropdown trigger.

     <!-- Dropdown Trigger -->
     <a class='dropdown-button btn' href='javascript:void(0);' data-activates='demoDropdown' dropdown>Select a demo</a>

     <!-- Dropdown Structure -->
     <ul id='demoDropdown' class='dropdown-content'>
     <li ng-repeat="demo in demoDefiniftions">
     <a href="javascript:void(0);" ng-click="selectDemo(demo)">{{demo.name}}</a>
     </li>
     </ul>*/
    angular.module("ui.materialize.dropdown", [])
        .directive("dropdown", ["$compile", "$timeout", function ($compile, $timeout) {
            return {
                scope: {
                    inDuration: "@",
                    outDuration: "@",
                    constrain_width: "@",
                    hover: "@",
                    alignment: "@",
                    gutter: "@",
                    belowOrigin: "@"
                },
                link: function (scope, element, attrs) {
                    $compile(element.contents())(scope);
                    $timeout(function () {
                        element.dropdown({
                            inDuration: (angular.isDefined(scope.inDuration)) ? scope.inDuration : undefined,
                            outDuration: (angular.isDefined(scope.outDuration)) ? scope.outDuration : undefined,
                            constrain_width: (angular.isDefined(scope.constrainWidth)) ? scope.constrain_width : undefined,
                            hover: (angular.isDefined(scope.hover)) ? scope.hover : undefined,
                            alignment: (angular.isDefined(scope.alignment)) ? scope.alignment : undefined,
                            gutter: (angular.isDefined(scope.gutter)) ? scope.gutter : undefined,
                            belowOrigin: (angular.isDefined(scope.belowOrigin)) ? scope.belowOrigin : undefined
                        });
                    });
                }
            };
        }]);

    /**
     * Instead of adding the .input-field class to a div surrounding a label and input, add the attribute input-field.
     * That way it will also work when angular destroys/recreates the elements.
     *
     * Example:
     <inputfield style="margin-top:10px">
     <label>{{name}}:</label>
     <input type="text" name="{{name}}" ng-model="value">
     </inputfield>
     */
    angular.module("ui.materialize.inputfield", [])
        .directive('inputField', ["$compile", "$timeout", function ($compile, $timeout) {
            return {
                transclude: true,
                scope: {},
                link: function (scope, element) {
                    $timeout(function () {
                        Materialize.updateTextFields();
                    });
                },
                template: '<div ng-transclude class="input-field"></div>'
            };
        }]);

    /**
     * Add pickadate directive
     * Type text is mandatory
     * Example:
     <input input-date
        type="text"
        name="created"
        id="inputCreated"
        ng-model="currentTime"
        format="dd/mm/yyyy"
        months-full="{{ monthFr }}"
        months-short="{{ monthShortFr }}"
        weekdays-full="{{ weekdaysFullFr }}"
        weekdays-short="{{ weekdaysShortFr }}"
        weekdays-letter="{{ weekdaysLetterFr }}"
        today="today"
        clear="clear"
        close="close"
        on-start="onStart()"
        on-render="onRender()"
        on-open="onOpen()"
        on-close="onClose()"
        on-set="onSet()"
        on-stop="onStop()" />
     */
    angular.module("ui.materialize.input_date", [])
        .directive('inputDate', ["$compile", "$timeout", function ($compile, $timeout) {
            // Define Prototype Date format
            // Use like this
            // today = new Date();
            // var dateString = today.format("dd-m-yy");
            var dateFormat = function () {

                var token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
                    timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
                    timezoneClip = /[^-+\dA-Z]/g,
                    pad = function (val, len) {
                        val = String(val);
                        len = len || 2;
                        while (val.length < len) {
                            val = "0" + val;
                        }
                        return val;
                    };

                // Regexes and supporting functions are cached through closure
                return function (date, mask, utc) {

                    var dF = dateFormat;

                    // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
                    if (arguments.length === 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                        mask = date;
                        date = undefined;
                    }

                    // Passing date through Date applies Date.parse, if necessary
                    date = date ? new Date(date) : new Date;
                    if (isNaN(date)) throw SyntaxError("invalid date");

                    mask = String(dF.masks[mask] || mask || dF.masks["default"]);

                    // Allow setting the utc argument via the mask
                    if (mask.slice(0, 4) == "UTC:") {
                        mask = mask.slice(4);
                        utc = true;
                    }

                    var _ = utc ? "getUTC" : "get",
                        d = date[ _ + "Date" ](),
                        D = date[ _ + "Day" ](),
                        m = date[ _ + "Month" ](),
                        y = date[ _ + "FullYear" ](),
                        H = date[ _ + "Hours" ](),
                        M = date[ _ + "Minutes" ](),
                        s = date[ _ + "Seconds" ](),
                        L = date[ _ + "Milliseconds" ](),
                        o = utc ? 0 : date.getTimezoneOffset(),
                        flags = {
                            d:    d,
                            dd:   pad(d),
                            ddd:  dF.i18n.dayNames[D],
                            dddd: dF.i18n.dayNames[D + 7],
                            m:    m + 1,
                            mm:   pad(m + 1),
                            mmm:  dF.i18n.monthNames[m],
                            mmmm: dF.i18n.monthNames[m + 12],
                            yy:   String(y).slice(2),
                            yyyy: y,
                            h:    H % 12 || 12,
                            hh:   pad(H % 12 || 12),
                            H:    H,
                            HH:   pad(H),
                            M:    M,
                            MM:   pad(M),
                            s:    s,
                            ss:   pad(s),
                            l:    pad(L, 3),
                            L:    pad(L > 99 ? Math.round(L / 10) : L),
                            t:    H < 12 ? "a"  : "p",
                            tt:   H < 12 ? "am" : "pm",
                            T:    H < 12 ? "A"  : "P",
                            TT:   H < 12 ? "AM" : "PM",
                            Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                            o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                            S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                        };

                    return mask.replace(token, function ($0) {
                        return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
                    });
                };
            }();

            // Some common format strings
            dateFormat.masks = {
               "default":      "ddd mmm dd yyyy HH:MM:ss",
                shortDate:      "m/d/yy",
                mediumDate:     "mmm d, yyyy",
                longDate:       "mmmm d, yyyy",
                fullDate:       "dddd, mmmm d, yyyy",
                shortTime:      "h:MM TT",
                mediumTime:     "h:MM:ss TT",
                longTime:       "h:MM:ss TT Z",
                isoDate:        "yyyy-mm-dd",
                isoTime:        "HH:MM:ss",
                isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
                isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
            };

            // Internationalization strings
            dateFormat.i18n = {
                dayNames: [
                    "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
                    "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
                ],
                monthNames: [
                    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                    "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
                ]
            };

            // For convenience...
            Date.prototype.format = function (mask, utc) {
                return dateFormat(this, mask, utc);
            };

            return {
                require: 'ngModel',
                scope: {
                    format: "@",
                    formatSubmit: "@",
                    monthsFull: "@",
                    monthsShort: "@",
                    weekdaysFull: "@",
                    weekdaysLetter: "@",
                    today: "=",
                    clear: "=",
                    close: "=",
                    onStart: "&",
                    onRender: "&",
                    onOpen: "&",
                    onClose: "&",
                    onSet: "&",
                    onStop: "&"
                },
                link: function (scope, element, attrs, ngModelCtrl) {
                		
                	/*
                    ngModelCtrl.$formatters.unshift(function (modelValue) {
                        if (modelValue) {
                        	console.log('ng-materialize unshift', modelValue);
                            var date = new Date(modelValue);
                            return (angular.isDefined(scope.format)) ? date.format(scope.format) : date.format('d mmmm, yyyy');
                        }
                        return null;
                    });
					*/
                	
                    var monthsFull = (angular.isDefined(scope.monthsFull)) ? scope.$eval(scope.monthsFull) : undefined,
                        monthsShort = (angular.isDefined(scope.monthsShort)) ? scope.$eval(scope.monthsShort) : undefined,
                        weekdaysFull = (angular.isDefined(scope.weekdaysFull)) ? scope.$eval(scope.weekdaysFull) : undefined,
                        weekdaysLetter = (angular.isDefined(scope.weekdaysLetter)) ? scope.$eval(scope.weekdaysLetter) : undefined;

                    $compile(element.contents())(scope);
                    $timeout(function () {
                        element.pickadate({
                        	container : 'body',
                            format: (angular.isDefined(scope.format)) ? scope.format : undefined,
                            formatSubmit: (angular.isDefined(scope.formatSubmit)) ? scope.formatSubmit : undefined,
                            monthsFull: (angular.isDefined(monthsFull)) ? monthsFull : undefined,
                            monthsShort: (angular.isDefined(monthsShort)) ? monthsShort : undefined,
                            weekdaysFull: (angular.isDefined(weekdaysFull)) ? weekdaysFull : undefined,
                            weekdaysLetter: (angular.isDefined(weekdaysLetter)) ? weekdaysLetter : undefined,
                            today: (angular.isDefined(scope.today)) ? scope.today : undefined,
                            clear: (angular.isDefined(scope.clear)) ? scope.clear : undefined,
                            close: (angular.isDefined(scope.close)) ? scope.close : undefined,
                            onStart: (angular.isDefined(scope.onStart)) ? function(){ scope.onStart() } : undefined,
                            onRender: (angular.isDefined(scope.onRender)) ? function(){ scope.onRender() } : undefined,
                            onOpen: (angular.isDefined(scope.onOpen)) ? function(){ scope.onOpen() } : undefined,
                            onClose: (angular.isDefined(scope.onClose)) ? function(){ scope.onClose() } : undefined,
                            onSet: (angular.isDefined(scope.onSet)) ? function(){ scope.onSet() } : undefined,
                            onStop: (angular.isDefined(scope.onStop)) ? function(){ scope.onStop() } : undefined
                        });
                    });
                }
            };
        }]);

    /**
     * Example:
     <pagination
        page="1"
        page-size="10"
        total="100"
        pagination-action="changePage(page)">
     */
    angular.module("ui.materialize.pagination", [])
        .directive('pagination', function () {

            // Assign null-able scope values from settings
            function setScopeValues(scope, attrs) {
                scope.List = [];
                scope.Hide = false;
                scope.page = parseInt(scope.page) || 1;
                scope.total = parseInt(scope.total) || 0;
                scope.dots = scope.dots || '...';
                scope.ulClass = 'pagination';
                scope.adjacent = parseInt(scope.adjacent) || 2;
                scope.activeClass = 'active';
                scope.disabledClass = 'disabled';

                scope.scrollTop = scope.$eval(attrs.scrollTop);
                scope.hideIfEmpty = scope.$eval(attrs.hideIfEmpty);
            }

            // Validate and clean up any scope values
            // This happens after we have set the
            // scope values
            function validateScopeValues(scope, pageCount) {
                // Block where the page is larger than the pageCount
                if (scope.page > pageCount) {
                    scope.page = pageCount;
                }

                // Block where the page is less than 0
                if (scope.page <= 0) {
                    scope.page = 1;
                }

                // Block where adjacent value is 0 or below
                if (scope.adjacent <= 0) {
                    scope.adjacent = 2;
                }

                // Hide from page if we have 1 or less pages
                // if directed to hide empty
                if (pageCount <= 1) {
                    scope.Hide = scope.hideIfEmpty;
                }
            }

            // Internal Pagination Click Action
            function internalAction(scope, page) {
                // Block clicks we try to load the active page
                if (scope.page == page) {
                    return;
                }

                // Update the page in scope and fire any paging actions
                scope.page = page;
                scope.paginationAction({
                    page: page
                });

                // If allowed scroll up to the top of the page
                if (scope.scrollTop) {
                    scrollTo(0, 0);
                }
            }

            // Previous text
            function prev(scope, pageCount) {

                // Ignore if no page prev to display
                if(pageCount < 1) {
                    return;
                }

                // Calculate the previous page and if the click actions are allowed
                // blocking and disabling where page <= 0
                var disabled = scope.page - 1 <= 0
                var prevPage = scope.page - 1 <= 0 ? 1 : scope.page - 1;

                var prev = {
                    value: '<',
                    liClass: disabled ? scope.disabledClass : '',
                    action: function () {
                        if(!disabled) {
                            internalAction(scope, prevPage);
                        }
                    }
                };

                scope.List.push(prev);
            }

            // Next text
            function next(scope, pageCount) {

                // Ignore if no page next to display
                if(pageCount < 1) {
                    return;
                }

                // Calculate the next page number and if the click actions are allowed
                // blocking where page is >= pageCount
                var disabled = scope.page + 1 > pageCount;
                var nextPage = scope.page + 1 >= pageCount ? pageCount : scope.page + 1;

                var next = {
                    value: '>',
                    liClass: disabled ? scope.disabledClass : '',
                    action: function () {
                        if(!disabled) {
                            internalAction(scope, nextPage);
                        }
                    }
                };

                scope.List.push(next);
            }

            // Add Range of Numbers
            function addRange(start, finish, scope) {
                var i = 0;
                for (i = start; i <= finish; i++) {
                    var item = {
                        value: i.toString(),
                        liClass: scope.page == i ? scope.activeClass : 'waves-effect',
                        action: function() {
                            internalAction(scope, this.value);
                        }
                    };

                    scope.List.push(item);
                }
            }

            // Add Dots ie: 1 2 [...] 10 11 12 [...] 56 57
            function addDots(scope) {
                scope.List.push({
                    value: scope.dots
                });
            }

            // Add First Pages
            function addFirst(scope, next) {
                addRange(1, 2, scope);

                // We ignore dots if the next value is 3
                // ie: 1 2 [...] 3 4 5 becomes just 1 2 3 4 5
                if (next != 3) {
                    addDots(scope);
                }
            }

            function addLast(pageCount, scope, prev) {
                // We ignore dots if the previous value is one less that our start range
                // ie: 1 2 3 4 [...] 5 6  becomes just 1 2 3 4 5 6
                if (prev != pageCount -2) {
                    addDots(scope);
                }

                addRange(pageCount -1, pageCount, scope);
            }

            // Main build function
            function build(scope, attrs) {

                // Block divide by 0 and empty page size
                if (!scope.pageSize || scope.pageSize < 0)
                {
                    return;
                }

                // Assign scope values
                setScopeValues(scope, attrs);

                // local variables
                var start,
                    size = scope.adjacent * 2,
                    pageCount = Math.ceil(scope.total / scope.pageSize);

                // Validation Scope
                validateScopeValues(scope, pageCount);

                prev(scope, pageCount);
                if (pageCount < (5 + size)) {

                    start = 1;
                    addRange(start, pageCount, scope);

                } else {

                    var finish;

                    if (scope.page <= (1 + size)) {

                        start = 1;
                        finish = 2 + size + (scope.adjacent - 1);

                        addRange(start, finish, scope);
                        addLast(pageCount, scope, finish);

                    } else if (pageCount - size > scope.page && scope.page > size) {

                        start = scope.page - scope.adjacent;
                        finish = scope.page + scope.adjacent;

                        addFirst(scope, start);
                        addRange(start, finish, scope);
                        addLast(pageCount, scope, finish);

                    } else {

                        start = pageCount - (1 + size + (scope.adjacent - 1));
                        finish = pageCount;

                        addFirst(scope, start);
                        addRange(start, finish, scope);

                    }
                }
                next(scope, pageCount);
            }

            return {
                restrict: 'EA',
                scope: {
                    page: '@',
                    pageSize: '@',
                    total: '@',
                    dots: '@',
                    hideIfEmpty: '@',
                    adjacent: '@',
                    scrollTop: '@',
                    paginationAction: '&'
                },
                template:
                    '<ul ng-hide="Hide" ng-class="ulClass"> ' +
                        '<li ' +
                        'ng-class="Item.liClass" ' +
                        'ng-click="Item.action()" ' +
                        'ng-repeat="Item in List"> ' +
                        '<a href> ' +
                        '<span ng-bind="Item.value"></span> ' +
                        '</a>' +
                    '</ul>',
                link: function (scope, element, attrs) {

                    // Hook in our watched items
                    scope.$watchCollection('[page, total]', function () {
                        build(scope, attrs);
                    });
                }
            };
        });
}(angular));