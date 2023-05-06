/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function( $, api ) {
    wp.customize.bind('ready', function() {
    	// Show message on change.
        var magic_blog_settings = ['magic_blog_slider_num', 'magic_blog_services_num', 'magic_blog_projects_num', 'magic_blog_testimonial_num', 'magic_blog_blog_section_num', 'magic_blog_reset_settings', 'magic_blog_testimonial_num', 'magic_blog_partner_num'];
        _.each( magic_blog_settings, function( magic_blog_setting ) {
            wp.customize( magic_blog_setting, function( setting ) {
                var blogGutenNotice = function( value ) {
                    var name = 'needs_refresh';
                    if ( value && magic_blog_setting == 'magic_blog_reset_settings' ) {
                        setting.notifications.add( 'needs_refresh', new wp.customize.Notification(
                            name,
                            {
                                type: 'warning',
                                message: localized_data.reset_msg,
                            }
                        ) );
                    } else if( value ){
                        setting.notifications.add( 'reset_name', new wp.customize.Notification(
                            name,
                            {
                                type: 'info',
                                message: localized_data.refresh_msg,
                            }
                        ) );
                    } else {
                        setting.notifications.remove( name );
                    }
                };

                setting.bind( blogGutenNotice );
            });
        });

        /* === Radio Image Control === */
        api.controlConstructor['radio-color'] = api.Control.extend( {
            ready: function() {
                var control = this;

                $( 'input:radio', control.container ).change(
                    function() {
                        control.setting.set( $( this ).val() );
                    }
                );
            }
        } );

        // Sortable sections
        jQuery( "body" ).on( 'hover', '.magic-blog-drag-handle', function() {
            jQuery( 'ul.magic-blog-sortable-list' ).sortable({
                handle: '.magic-blog-drag-handle',
                axis: 'y',
                update: function( e, ui ){
                    jQuery('input.magic-blog-sortable-input').trigger( 'change' );
                }
            });
        });

        /* On changing the value. */
        jQuery( "body" ).on( 'change', 'input.magic-blog-sortable-input', function() {
            /* Get the value, and convert to string. */
            this_checkboxes_values = jQuery( this ).parents( 'ul.magic-blog-sortable-list' ).find( 'input.magic-blog-sortable-input' ).map( function() {
                return this.value;
            }).get().join( ',' );

            /* Add the value to hidden input. */
            jQuery( this ).parents( 'ul.magic-blog-sortable-list' ).find( 'input.magic-blog-sortable-value' ).val( this_checkboxes_values ).trigger( 'change' );

        });

        // Deep linking for counter section to about section.
        jQuery('.magic-blog-edit').click(function(e) {
            e.preventDefault();
            var jump_to = jQuery(this).attr( 'data-jump' );
            wp.customize.section( jump_to ).focus()
        });

    });
})( jQuery, wp.customize );
