angular.module('dnd', [])

.factory('dndFactory', function() {
	return {
		data : {content: null, pos:null, element : null},
		content : function(value) {
			this.data.content = value;
		},
		elmnSet : function(e) {
			this.data.element = e;
		},
		elmnGet : function() {
			return this.data.element;
		},
		get : function() {
			return this.data;
		},
		pos: function(pos) {
			this.data.pos = pos;
		}
	}
})

/**
 * Usage:
 * 
 * ```js
 * dnd dnd-model="data" dnd-isvalid="isValid(hover,dragged)" dnd-drag-disabled dnd-diable-drag-middle dnd-drop-disabled dnd-ondrop="dropItem(dragged,dropped,position)" dnd-css="{onDrag: 'drag-start', onHover: 'red', onHoverTop: 'red-top', onHoverMiddle: 'red-middle', onHoverBottom: 'red-bottom'}"
 * ```
 * 
 * + dnd-model: This is the model which will be used as "dropped", when drag is disabled this model is not needed
 * + dnd-disable-drag-middle
 * + dnd-drag-disabled
 * + dnd-is-valid
 */
.directive('dnd', function(dndFactory) {
	return {
		restrict : 'A',
		transclude: false,
		replace: false,
		template: false,
		templateURL: false,
		scope: {
			dndModel : '=',
			dndCss : '=',
			dndOndrop : '&',
			dndIsvalid : '&',
		},
		link: function(scope, element, attrs) {
			var isValid = true;
			
			var disableMiddleDrop = attrs.hasOwnProperty('dndDisableDragMiddle');
			
	        // this gives us the native JS object
	        var dragable = element[0];
	
	        /* DRAGABLE */
	        
	        if (!attrs.hasOwnProperty('dndDragDisabled')) {
	        	dragable.draggable = true;
	        }
	
	        dragable.addEventListener(
	            'dragstart',
	            function(e) {
	            	isValid = true;
	            	dndFactory.content(scope.dndModel);
	            	dndFactory.elmnSet(dragable);
	                this.classList.add(scope.dndCss.onDrag);
	                return false;
	            },
	            false
	        );
	
	        dragable.addEventListener(
	            'dragend',
	            function(e) {
	                this.classList.remove(scope.dndCss.onDrag);
	                return false;
	            },
	            false
	        );
	        
	        /* DROPABLE */
	        
	        var el = element[0];
	          
        	el.addEventListener(
    		    'dragover',
    		    function(e) {
    		        e.dataTransfer.dropEffect = 'move';
    		        // allows us to drop
    		        if (e.preventDefault) { e.preventDefault(); }
    		        if (!scope.dndIsvalid({hover:  scope.dndModel, dragged: dndFactory.get().content})) {
		        		e.stopPropagation();
		        		e.preventDefault();
		        		isValid = false;
		        		return false;
		        	}
    		        
                    var re = el.getBoundingClientRect();
    		        var height = re.height;
    		        var mouseHeight = e.clientY - re.top;
    		        var percentage = (100 / height) * mouseHeight;
    		        if (disableMiddleDrop) {
    		        	if (percentage <= 50) {
        		        	this.classList.add(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('top');
        		        } else {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.add(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('bottom');
        		        }
    		        } else {
    		        	if (percentage <= 25) {
        		        	this.classList.add(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('top');
        		        } else if (percentage >= 65) {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.remove(scope.dndCss.onHoverMiddle);
        		        	this.classList.add(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('bottom');
        		        } else {
        		        	this.classList.remove(scope.dndCss.onHoverTop);
        		        	this.classList.add(scope.dndCss.onHoverMiddle);
        		        	this.classList.remove(scope.dndCss.onHoverBottom);
        		        	dndFactory.pos('middle');
        		        }
    		        }
    		        
    		        this.classList.add(scope.dndCss.onHover);
    		        return false;
    		    },
    		    false
    		);
        	
        	el.addEventListener(
    		    'dragenter',
    		    function(e) {
    		        this.classList.add(scope.dndCss.onHover);
    		        return false;
    		    },
    		    false
    		);

    		el.addEventListener(
    		    'dragleave',
    		    function(e) {
    		        this.classList.remove(scope.dndCss.onHover);
    		        this.classList.remove(scope.dndCss.onHoverTop);
    		        this.classList.remove(scope.dndCss.onHoverMiddle);
    		        this.classList.remove(scope.dndCss.onHoverBottom);
    		        return false;
    		    },
    		    false
    		);

    		if (!attrs.hasOwnProperty('dndDropDisabled')) {
	            el.addEventListener(
	                'drop',
	                function(e) {
	                	if (e.preventDefault) { e.preventDefault(); }
	                    if (e.stopPropagation) { e.stopPropagation(); }
	                    this.classList.remove(scope.dndCss.onHover);
	    		        this.classList.remove(scope.dndCss.onHoverTop);
	    		        this.classList.remove(scope.dndCss.onHoverMiddle);
	    		        this.classList.remove(scope.dndCss.onHoverBottom);
	    		        if (isValid) {
		                	scope.$apply(function() {
		                		scope.dndOndrop({dragged: dndFactory.get().content, dropped: scope.dndModel, position: dndFactory.get().pos});
		                	});
	    		        }
	                	return false;
	                },
	                false
	            );
    		}
		}
	};
});