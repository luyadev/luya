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
 * dnd dnd-model="data" dnd-ondrop="dropItem(dragged,dropped,position)" dnd-css="{onDrag: 'drag-start', onHover: 'red', onHoverTop: 'red-top', onHoverMiddle: 'red-middle', onHoverBottom: 'red-bottom'}"
 */
.directive('dnd', function(dndFactory) {
	return {
		scope: {
			dndModel : '=',
			dndCss : '=',
			dndOndrop : '&'
		},
		link: function(scope, element) {
	        // this gives us the native JS object
	        var dragable = element[0];
	
	        /* DRAGABLE */
	        
	        dragable.draggable = true;
	
	        dragable.addEventListener(
	            'dragstart',
	            function(e) {
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
    		        
    		        var dragelement = dndFactory.elmnGet();
    		        
    		        console.log(dragelement.contains(el));
    		        
    		        //var isChild = element.has(e.target).length > 0;
                    //var isSelf = el == e.target;
    		        
                    var re = el.getBoundingClientRect();

    		        var height = re.height;
    		        var mouseHeight = e.clientY - re.top;
    		        
    		        var percentage = (100 / height) * mouseHeight;
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

            el.addEventListener(
                'drop',
                function(e) {
                	if (e.preventDefault) { e.preventDefault(); }
                    if (e.stopPropagation) { e.stopPropagation(); }
                    this.classList.remove(scope.dndCss.onHover);
    		        this.classList.remove(scope.dndCss.onHoverTop);
    		        this.classList.remove(scope.dndCss.onHoverMiddle);
    		        this.classList.remove(scope.dndCss.onHoverBottom);
                	scope.$apply(function() {
                		scope.dndOndrop({dragged: dndFactory.get().content, dropped: scope.dndModel, position: dndFactory.get().pos});
                	});
                	return false;
                },
                false
            );
		}
	};
});