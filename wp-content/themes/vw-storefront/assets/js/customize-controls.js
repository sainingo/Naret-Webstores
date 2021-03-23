( function( api ) {

	// Extends our custom "vw-storefront" section.
	api.sectionConstructor['vw-storefront'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );