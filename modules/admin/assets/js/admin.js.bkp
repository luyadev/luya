// ModulesNav switch

$( document ).ready( function() {
    $( '#js-settings' ).settings();
});

registerEvent('onMenuFinish', function(e) {
	$( '#js-modulesnav' ).modulesNav();
	$( '#js-modulesnav' ).overlay();
});

registerEvent('onSubMenuFinish', function(e) {
	$( '#js-sidebar' ).sidebar();
});
/*
registerEvent('onCrudCreate', function(e) {
	$('input[type="text"], input[type="password"], input[type="email"], textarea').jvFloat();
});
*/

;(function($){

    $.fn.sidebar = function() {
        var $self = this;

        var $links              = $self.find( '.Sidebar-Link' );
        var $currentIndicator   = $self.find( '.Sidebar-CurrentIndicator');

        function init()
        {
            moveCurrentIndicator();

            $links.on( 'click', function() {
                $links.removeClass( 'current' );

                $( this ).addClass( 'current' );
                moveCurrentIndicator();
            });
        }

        function moveCurrentIndicator() {
            if( $self.find( '.current' ).length > 0 ) {
                $currentIndicator.show();

                var offsetTop = $('.Sidebar .current').offset().top - $( '.Container').offset().top;
                var transformY = ( offsetTop / $('.Sidebar-CurrentIndicator').outerHeight() ) * 100;

                $currentIndicator.css(
                    'transform', 'translateY(' + transformY + '%)',
                    '-webkit-transform', 'translateY(' + transformY + '%)'
                );
            }
        }

        if ($self.length >= 1) {
            init();
        }

        return $self;
    };

})(jQuery);

;(function($){

    $.fn.settings = function() {
        var $self = this;

        var $toggler = $( '.SettingsNav-Link' );

        function init()
        {
            $toggler.on( 'click', function() {
                $( 'body' ).toggleClass( 'js-settings-active' );
            });
        }

        if ($self.length >= 1) {
            init();
        }

        return $self;
    };

})(jQuery);

;(function($){

    $.fn.modulesNav = function() {
        var $self = this;

        var $tabs               = $self.find( '.ModulesNav-Link' );
        var $currentIndicator   = $self.find( '.ModulesNav-CurrentIndicator');

        function init()
        {
            moveCurrentIndicator( $( '.current' ) );

            // todo: Remove. Will be done by Angular?
            $tabs.on( 'click', function() {
                $tabs.removeClass( 'current' );

                $( this ).addClass( 'current' );
                moveCurrentIndicator( $( '.current' ) );
            });
        }

        function moveCurrentIndicator( $current ) {
            $currentIndicator.css({
                'transform':            'translate3d(' + $tabs.index( $current ) + '00%,0,0)',
                '-webkit-transform':    'translate3d(' + $tabs.index( $current ) + '00%,0,0)'
            });
        }

        if ($self.length >= 1) {
            init();
        }

        return $self;
    };

})(jQuery);

;(function($){

    $.fn.overlay = function() {
        var $self = this;

        var $links = $self.find( '.ModulesNav-Link' );
        var $overlay = $( '.Overlay' );

        function init()
        {
            $links.on( 'mouseenter', function() {
                var label = $(this).data().overlayLabel;
                $overlay.addClass( 'Overlay--visible' );
                $( '.Overlay-Text' ).text( label );
            });

            $links.on( 'mouseleave', function() {
                $overlay.removeClass( 'Overlay--visible' );
            });
        }

        if ($self.length >= 1) {
            init();
        }

        return $self;
    };

})(jQuery);