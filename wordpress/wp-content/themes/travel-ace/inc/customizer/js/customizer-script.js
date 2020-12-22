
( function( $, api ) {
	/* === Repeater Text Control === */
	api.controlConstructor['travel-ace-repeater-text'] = api.Control.extend({

		ready: function() {

			'use strict';

			var control = this;

			control.initCustomControl();
		},

		initCustomControl: function() {

			'use strict';

			var control = this;

			control.populate(control);

			control.container.on( 'click', '.btn-add-field', control, function(event) {
				control.add(event);
			} );
			control.container.on( 'change', '.repeater-text-single-field', control, function() {
				control.updateValue();
			} );
			control.container.on( 'click', '.btn-remove-field', control, function(event) {
				control.remove(event);
				control.updateValue();
			} );
		},

		populate: function() {

			'use strict';

			var wrapper = this.selector;
			var multi_saved_value = jQuery(wrapper).find( '.repeater-text-value' ).val();
			if ( multi_saved_value.length > 0 ) {
				var multi_saved_values = multi_saved_value.split( '|' );
				jQuery(wrapper).find( '.repeater-text-fields' ).empty();
				jQuery.each(multi_saved_values, function( i, value ) {
					jQuery(wrapper).find( '.repeater-text-fields' ).append( '<div class="set"><input type="text" value="' + value + '" class="repeater-text-single-field" /><span class="btn-remove-field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
				});
			}
		},

		add: function(event) {
			'use strict';

			event.preventDefault();
			jQuery(event.target).parent('.repeater-text-input').find('.repeater-text-fields').append( '<div class="set"><input type="text" value="" class="repeater-text-single-field" /><span class="btn-remove-field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
		},

		remove: function(event) {
			'use strict';

			event.preventDefault();
			jQuery(event.target).parent().parent().remove();
		},

		updateValue: function() {
			'use strict';

			var values = '';
			var wrapper = this.selector;
			jQuery(wrapper).find( '.repeater-text-fields .repeater-text-single-field' ).each(function() {
				values += jQuery(this).val() + '|';
			});

			jQuery(wrapper).find( '.repeater-text-value' ).val( values.slice( 0, -1 ) ).change();
		}

	});

    // upsell 
    api.sectionConstructor['travel-ace-upsell'] = api.Section.extend( {
        // No events for this type of section.
        attachEvents: function () {},
        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );
} )( jQuery, wp.customize );
/**
* Custom Js for image select in customizer
*
* @package travel_ace
*/
 jQuery(document).ready(function($) {
    $('#customize-control-theme_options-layout_options_blog #travel-ace-img-container li label img').click(function(){    	
        $('#customize-control-theme_options-layout_options_blog #travel-ace-img-container li').each(function(){
            $(this).find('img').removeClass ('travel-ace-radio-img-selected') ;
        });
        $(this).addClass ('travel-ace-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_archive #travel-ace-img-container li label img').click(function(){    	
        $('#customize-control-theme_options-layout_options_archive #travel-ace-img-container li').each(function(){
            $(this).find('img').removeClass ('travel-ace-radio-img-selected') ;
        });
        $(this).addClass ('travel-ace-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_page #travel-ace-img-container li label img').click(function(){    	
        $('#customize-control-theme_options-layout_options_page #travel-ace-img-container li').each(function(){
            $(this).find('img').removeClass ('travel-ace-radio-img-selected') ;
        });
        $(this).addClass ('travel-ace-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_single #travel-ace-img-container li label img').click(function(){    	
        $('#customize-control-theme_options-layout_options_single #travel-ace-img-container li').each(function(){
            $(this).find('img').removeClass ('travel-ace-radio-img-selected') ;
        });
        $(this).addClass ('travel-ace-radio-img-selected') ;
    });   

    $('#customize-control-theme_options-layout_options_boxed #travel-ace-img-container li label img').click(function(){    	
        $('#customize-control-theme_options-layout_options_boxed #travel-ace-img-container li').each(function(){
            $(this).find('img').removeClass ('travel-ace-radio-img-selected') ;
        });
        $(this).addClass ('travel-ace-radio-img-selected') ;
    });                    
});
