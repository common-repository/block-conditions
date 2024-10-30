<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://chintesh.github.io/
 * @since      1.0.0
 *
 * @package    Block_Conditions
 * @subpackage Block_Conditions/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Block_Conditions
 * @subpackage Block_Conditions/public
 * @author     Chintesh Prajapati <prajapatichintesh95@gmail.com>
 */
class Block_Conditions_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Block_Conditions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Block_Conditions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'block-conditions-front-css', plugin_dir_url( __FILE__ ) . 'css/block-conditions-public.css', array(), $this->version, 'all' );

			$device_size_desktop_min = get_option( 'desktop_breakopint', false );
			if(empty($device_size_desktop_min)){
				$device_size_desktop_min = '1025';
			}
			$device_size_tablet_max = get_option( 'tablet_breakopint_start', false );
			if(empty($device_size_tablet_max)){
				$device_size_tablet_max = '1024';
			}
			$device_size_tablet_min = get_option( 'tablet_breakopint_end', false );
			if(empty($device_size_tablet_min)){
				$device_size_tablet_min = '768';
			}
			$device_size_mobile_max = get_option( 'mobile_breakopint_end', false );
			if(empty($device_size_mobile_max)){
				$device_size_mobile_max = '767';
			}

			$media_css = "
			@media (min-width: {$device_size_desktop_min}px) {
				.block-con-desktop-hidden {
					display: none !important;
				}
			}
			@media (min-width: {$device_size_tablet_min}px) and (max-width: {$device_size_tablet_max}px) {
				.block-con-tablet-hidden {
					display: none !important;
				}
			}
			@media(max-width: {$device_size_mobile_max}px) {
				.block-con-hide-mobile {
					display: none !important;
				}
			}
			";

		wp_add_inline_style( 'block-conditions-front-css', $media_css );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Block_Conditions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Block_Conditions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/block-conditions-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Filter block content before displaying.
	 *
	 * @param string $block_content the block content.
	 * @param array  $block the whole Gutenberg block object including attributes.
	 * @return string $block_content the new block content.
	 */
	function block_conditions_post_save_content( $block_content, $block ) {
		$blockhidearr = [];
		if($block['attrs']['hideinmobile']){
			$blockhidearr['hideinmobile'] = $block['attrs']['hideinmobile'];
		}
		if($block['attrs']['hideindesktop']){
			$blockhidearr['hideindesktop'] = $block['attrs']['hideindesktop'];
		}
		if($block['attrs']['hideinteblate']){
			$blockhidearr['hideinteblate'] = $block['attrs']['hideinteblate'];
		}
		if($block['attrs']['logged_in']){
			$blockhidearr['logged_in'] = $block['attrs']['logged_in'];
		}
		if($block['attrs']['logged_out']){
			$blockhidearr['logged_out'] = $block['attrs']['logged_out'];
		}
		if(!empty($block['attrs']['country']))	{
			$blockhidearr['counries'] = $block['attrs']['country'];
		}
		if ( ! isset( $blockhidearr ) || empty( $blockhidearr ) ) {
			return $block_content;
		}
		$block_content = $this->block_conditions_render_device_visibility( $block_content, $blockhidearr, $block );

		$render_block = apply_filters( 'block_conditions_render_conditions', array(), $blockhidearr, $block );
		
		if ( $render_block['state'] == 'no') {
				return '';
		}
		return $block_content;
	}

	/**
	 * Add device visibility per block.
	 *
	 * @param array $block_content the whole block object.
	 * @param array $conditions block conditions array.
	 * @param array $block the whole block object.
	 * @return string $block_content
	 */
	public function block_conditions_render_device_visibility( $block_content, $conditions, $block ) {
		$html_classes = '';
		if ( isset( $conditions['hideinmobile'] ) && $conditions['hideinmobile'] == '1' ) {
			$html_classes .= 'block-con-hide-mobile ';
		}
		if ( isset( $conditions['hideinteblate'] ) && $conditions['hideinteblate'] == '1' ) {
			$html_classes .= 'block-con-tablet-hidden ';
		}
		if ( isset( $conditions['hideindesktop'] ) && $conditions['hideindesktop'] == '1' ) {
			$html_classes .= 'block-con-desktop-hidden ';
		}
		if ( ! empty( $html_classes ) ) {
			$needle = 'class="';
			$find_class_tag = strpos( $block_content, $needle );
			if ( $find_class_tag !== false ) {
				$replacement = 'class="' . $html_classes . ' ';
				$new_block = substr_replace( $block_content, $replacement, $find_class_tag, strlen( $needle ) );
			} else {
				$new_block = '<div class="' . $html_classes . '">' . $block_content . '</div>';
			}
			return $new_block;
		} else {
			return $block_content;
		}
	}


	/**
	 * Render User state visibility per block.
	 *
	 * @param array $render_block array containing condition name and 'yes'/'no' if blocks should be rendered.
	 * @param array $conditions Block conditions array.
	 * @param array $block the whole block object.
	 * @return array render_block
	 */
	public function block_conditions_render_conditions_fun( $render_block, $conditions, $block ) {
		if ( isset( $conditions['logged_in'] ) && $conditions['logged_in'] == '1' && is_user_logged_in()) {
			$render_block['state'] = 'no';
		}
		if ( isset( $conditions['logged_out'] ) && $conditions['logged_out'] == '1' && !is_user_logged_in()) {
			$render_block['state'] = 'no';
		}

		$ip = wp_remote_retrieve_body( wp_remote_get('https://api.ipify.org/') );
		$ipresult = @json_decode(wp_remote_retrieve_body(wp_remote_get( "http://ip-api.com/json/".$ip)));
		$country_code = $ipresult->countryCode;
		if ( !empty($country_code) && !empty($conditions['counries']) && is_array($conditions['counries']) && in_array($country_code, $conditions['counries'], true )) {
		   	$render_block['state'] = 'no';
		}
		return $render_block;
	}

}
