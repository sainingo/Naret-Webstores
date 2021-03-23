<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */

class VW_Storefront_Control_Typography extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'vw-storefront-typography';

	/**
	 * Array 
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $l10n = array();

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		// Let the parent class do its thing.
		parent::__construct( $manager, $id, $args );

		// Make sure we have labels.
		$this->l10n = wp_parse_args(
			$this->l10n,
			array(
				'color'       => esc_html__( 'Font Color', 'vw-storefront' ),
				'family'      => esc_html__( 'Font Family', 'vw-storefront' ),
				'size'        => esc_html__( 'Font Size',   'vw-storefront' ),
				'weight'      => esc_html__( 'Font Weight', 'vw-storefront' ),
				'style'       => esc_html__( 'Font Style',  'vw-storefront' ),
				'line_height' => esc_html__( 'Line Height', 'vw-storefront' ),
				'letter_spacing' => esc_html__( 'Letter Spacing', 'vw-storefront' ),
			)
		);
	}

	/**
	 * Enqueue scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_script( 'vw-storefront-ctypo-customize-controls' );
		wp_enqueue_style(  'vw-storefront-ctypo-customize-controls' );
	}

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[ $setting_key ] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => isset( $this->l10n[ $setting_key ] ) ? $this->l10n[ $setting_key ] : ''
			);

			if ( 'family' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_families();

			elseif ( 'weight' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_weight_choices();

			elseif ( 'style' === $setting_key )
				$this->json[ $setting_key ]['choices'] = $this->get_font_style_choices();
		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.family && data.family.choices ) { #>

			<li class="typography-font-family">

				<# if ( data.family.label ) { #>
					<span class="customize-control-title">{{ data.family.label }}</span>
				<# } #>

				<select {{{ data.family.link }}}>

					<# _.each( data.family.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.family.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.weight && data.weight.choices ) { #>

			<li class="typography-font-weight">

				<# if ( data.weight.label ) { #>
					<span class="customize-control-title">{{ data.weight.label }}</span>
				<# } #>

				<select {{{ data.weight.link }}}>

					<# _.each( data.weight.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.weight.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.style && data.style.choices ) { #>

			<li class="typography-font-style">

				<# if ( data.style.label ) { #>
					<span class="customize-control-title">{{ data.style.label }}</span>
				<# } #>

				<select {{{ data.style.link }}}>

					<# _.each( data.style.choices, function( label, choice ) { #>

						<option value="{{ choice }}" <# if ( choice === data.style.value ) { #> selected="selected" <# } #>>{{ label }}</option>

					<# } ) #>

				</select>
			</li>
		<# } #>

		<# if ( data.size ) { #>

			<li class="typography-font-size">

				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.size.link }}} value="{{ data.size.value }}" />

			</li>
		<# } #>

		<# if ( data.line_height ) { #>

			<li class="typography-line-height">

				<# if ( data.line_height.label ) { #>
					<span class="customize-control-title">{{ data.line_height.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.line_height.link }}} value="{{ data.line_height.value }}" />

			</li>
		<# } #>

		<# if ( data.letter_spacing ) { #>

			<li class="typography-letter-spacing">

				<# if ( data.letter_spacing.label ) { #>
					<span class="customize-control-title">{{ data.letter_spacing.label }} (px)</span>
				<# } #>

				<input type="number" min="1" {{{ data.letter_spacing.link }}} value="{{ data.letter_spacing.value }}" />

			</li>
		<# } #>

		</ul>
	<?php }

	/**
	 * Returns the available fonts.  Fonts should have available weights, styles, and subsets.
	 *
	 * @todo Integrate with Google fonts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_fonts() { return array(); }

	/**
	 * Returns the available font families.
	 *
	 * @todo Pull families from `get_fonts()`.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	function get_font_families() {

		return array(
			'' => __( 'No Fonts', 'vw-storefront' ),
        'Abril Fatface' => __( 'Abril Fatface', 'vw-storefront' ),
        'Acme' => __( 'Acme', 'vw-storefront' ),
        'Anton' => __( 'Anton', 'vw-storefront' ),
        'Architects Daughter' => __( 'Architects Daughter', 'vw-storefront' ),
        'Arimo' => __( 'Arimo', 'vw-storefront' ),
        'Arsenal' => __( 'Arsenal', 'vw-storefront' ),
        'Arvo' => __( 'Arvo', 'vw-storefront' ),
        'Alegreya' => __( 'Alegreya', 'vw-storefront' ),
        'Alfa Slab One' => __( 'Alfa Slab One', 'vw-storefront' ),
        'Averia Serif Libre' => __( 'Averia Serif Libre', 'vw-storefront' ),
        'Bangers' => __( 'Bangers', 'vw-storefront' ),
        'Boogaloo' => __( 'Boogaloo', 'vw-storefront' ),
        'Bad Script' => __( 'Bad Script', 'vw-storefront' ),
        'Bitter' => __( 'Bitter', 'vw-storefront' ),
        'Bree Serif' => __( 'Bree Serif', 'vw-storefront' ),
        'BenchNine' => __( 'BenchNine', 'vw-storefront' ),
        'Cabin' => __( 'Cabin', 'vw-storefront' ),
        'Cardo' => __( 'Cardo', 'vw-storefront' ),
        'Courgette' => __( 'Courgette', 'vw-storefront' ),
        'Cherry Swash' => __( 'Cherry Swash', 'vw-storefront' ),
        'Cormorant Garamond' => __( 'Cormorant Garamond', 'vw-storefront' ),
        'Crimson Text' => __( 'Crimson Text', 'vw-storefront' ),
        'Cuprum' => __( 'Cuprum', 'vw-storefront' ),
        'Cookie' => __( 'Cookie', 'vw-storefront' ),
        'Chewy' => __( 'Chewy', 'vw-storefront' ),
        'Days One' => __( 'Days One', 'vw-storefront' ),
        'Dosis' => __( 'Dosis', 'vw-storefront' ),
        'Droid Sans' => __( 'Droid Sans', 'vw-storefront' ),
        'Economica' => __( 'Economica', 'vw-storefront' ),
        'Fredoka One' => __( 'Fredoka One', 'vw-storefront' ),
        'Fjalla One' => __( 'Fjalla One', 'vw-storefront' ),
        'Francois One' => __( 'Francois One', 'vw-storefront' ),
        'Frank Ruhl Libre' => __( 'Frank Ruhl Libre', 'vw-storefront' ),
        'Gloria Hallelujah' => __( 'Gloria Hallelujah', 'vw-storefront' ),
        'Great Vibes' => __( 'Great Vibes', 'vw-storefront' ),
        'Handlee' => __( 'Handlee', 'vw-storefront' ),
        'Hammersmith One' => __( 'Hammersmith One', 'vw-storefront' ),
        'Inconsolata' => __( 'Inconsolata', 'vw-storefront' ),
        'Indie Flower' => __( 'Indie Flower', 'vw-storefront' ),
        'IM Fell English SC' => __( 'IM Fell English SC', 'vw-storefront' ),
        'Julius Sans One' => __( 'Julius Sans One', 'vw-storefront' ),
        'Josefin Slab' => __( 'Josefin Slab', 'vw-storefront' ),
        'Josefin Sans' => __( 'Josefin Sans', 'vw-storefront' ),
        'Kanit' => __( 'Kanit', 'vw-storefront' ),
        'Lobster' => __( 'Lobster', 'vw-storefront' ),
        'Lato' => __( 'Lato', 'vw-storefront' ),
        'Lora' => __( 'Lora', 'vw-storefront' ),
        'Libre Baskerville' => __( 'Libre Baskerville', 'vw-storefront' ),
        'Lobster Two' => __( 'Lobster Two', 'vw-storefront' ),
        'Merriweather' => __( 'Merriweather', 'vw-storefront' ),
        'Monda' => __( 'Monda', 'vw-storefront' ),
        'Montserrat' => __( 'Montserrat', 'vw-storefront' ),
        'Muli' => __( 'Muli', 'vw-storefront' ),
        'Marck Script' => __( 'Marck Script', 'vw-storefront' ),
        'Noto Serif' => __( 'Noto Serif', 'vw-storefront' ),
        'Open Sans' => __( 'Open Sans', 'vw-storefront' ),
        'Overpass' => __( 'Overpass', 'vw-storefront' ),
        'Overpass Mono' => __( 'Overpass Mono', 'vw-storefront' ),
        'Oxygen' => __( 'Oxygen', 'vw-storefront' ),
        'Orbitron' => __( 'Orbitron', 'vw-storefront' ),
        'Patua One' => __( 'Patua One', 'vw-storefront' ),
        'Pacifico' => __( 'Pacifico', 'vw-storefront' ),
        'Padauk' => __( 'Padauk', 'vw-storefront' ),
        'Playball' => __( 'Playball', 'vw-storefront' ),
        'Playfair Display' => __( 'Playfair Display', 'vw-storefront' ),
        'PT Sans' => __( 'PT Sans', 'vw-storefront' ),
        'Philosopher' => __( 'Philosopher', 'vw-storefront' ),
        'Permanent Marker' => __( 'Permanent Marker', 'vw-storefront' ),
        'Poiret One' => __( 'Poiret One', 'vw-storefront' ),
        'Quicksand' => __( 'Quicksand', 'vw-storefront' ),
        'Quattrocento Sans' => __( 'Quattrocento Sans', 'vw-storefront' ),
        'Raleway' => __( 'Raleway', 'vw-storefront' ),
        'Rubik' => __( 'Rubik', 'vw-storefront' ),
        'Rokkitt' => __( 'Rokkitt', 'vw-storefront' ),
        'Russo One' => __( 'Russo One', 'vw-storefront' ),
        'Righteous' => __( 'Righteous', 'vw-storefront' ),
        'Slabo' => __( 'Slabo', 'vw-storefront' ),
        'Source Sans Pro' => __( 'Source Sans Pro', 'vw-storefront' ),
        'Shadows Into Light Two' => __( 'Shadows Into Light Two', 'vw-storefront'),
        'Shadows Into Light' => __( 'Shadows Into Light', 'vw-storefront' ),
        'Sacramento' => __( 'Sacramento', 'vw-storefront' ),
        'Shrikhand' => __( 'Shrikhand', 'vw-storefront' ),
        'Tangerine' => __( 'Tangerine', 'vw-storefront' ),
        'Ubuntu' => __( 'Ubuntu', 'vw-storefront' ),
        'VT323' => __( 'VT323', 'vw-storefront' ),
        'Varela Round' => __( 'Varela Round', 'vw-storefront' ),
        'Vampiro One' => __( 'Vampiro One', 'vw-storefront' ),
        'Vollkorn' => __( 'Vollkorn', 'vw-storefront' ),
        'Volkhov' => __( 'Volkhov', 'vw-storefront' ),
        'Yanone Kaffeesatz' => __( 'Yanone Kaffeesatz', 'vw-storefront' )
		);
	}

	/**
	 * Returns the available font weights.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_weight_choices() {

		return array(
			'' => esc_html__( 'No Fonts weight', 'vw-storefront' ),
			'100' => esc_html__( 'Thin',       'vw-storefront' ),
			'300' => esc_html__( 'Light',      'vw-storefront' ),
			'400' => esc_html__( 'Normal',     'vw-storefront' ),
			'500' => esc_html__( 'Medium',     'vw-storefront' ),
			'700' => esc_html__( 'Bold',       'vw-storefront' ),
			'900' => esc_html__( 'Ultra Bold', 'vw-storefront' ),
		);
	}

	/**
	 * Returns the available font styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function get_font_style_choices() {

		return array(
			'' => esc_html__( 'No Fonts Style', 'vw-storefront' ),
			'normal'  => esc_html__( 'Normal', 'vw-storefront' ),
			'italic'  => esc_html__( 'Italic', 'vw-storefront' ),
			'oblique' => esc_html__( 'Oblique', 'vw-storefront' )
		);
	}
}
