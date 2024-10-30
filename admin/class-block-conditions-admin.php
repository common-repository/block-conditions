<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://chintesh.github.io/
 * @since      1.0.0
 *
 * @package    Block_Conditions
 * @subpackage Block_Conditions/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Block_Conditions
 * @subpackage Block_Conditions/admin
 * @author     Chintesh Prajapati <prajapatichintesh95@gmail.com>
 */
class Block_Conditions_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/block-conditions-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/block-conditions-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'block-conditions-builds', plugin_dir_url( __FILE__ ) . 'js/block-conditions.build.js', array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), $this->version, false );

	}


	public function block_conditions_menu(){

		$parent      = 'options-general.php';
		$plugin_name = __( 'Block Conditions', 'block-conditions' );
		$permissions = 'manage_options';
		$slug        = 'block-conditions';
		$callback    = array( $this, 'block_conditions_page' );
		$priority    = 100;

		add_submenu_page(
			$parent,
			$plugin_name,
			$plugin_name,
			$permissions,
			$slug,
			$callback,
			$priority
		);

	}


	public function block_conditions_plugin_setting(){
		register_setting( 'block-conditions-opt', 'desktop_breakopint' );
		register_setting( 'block-conditions-opt', 'tablet_breakopint_start' );
		register_setting( 'block-conditions-opt', 'tablet_breakopint_end' );
		register_setting( 'block-conditions-opt', 'mobile_breakopint_end' );
	}

	public function block_conditions_page(){

		$desktop_breakopint = !empty(get_option('desktop_breakopint')) ? get_option('desktop_breakopint') : '1025' ;

		$tablet_breakopint_start = !empty(get_option('tablet_breakopint_start')) ? get_option('tablet_breakopint_start') : '1024' ;

		$tablet_breakopint_end = !empty(get_option('tablet_breakopint_end')) ? get_option('tablet_breakopint_end') : '768' ;

		$mobile_breakopint_end = !empty(get_option('mobile_breakopint_end')) ? get_option('mobile_breakopint_end') : '767' ;

		?>

		<div class="wrap">
		<h1>Block Conditions</h1>

		<form method="post" action="options.php">
		    <?php settings_fields( 'block-conditions-opt' ); ?>
		    <?php do_settings_sections( 'block-conditions-opt' ); ?>
		    <table class="form-table">
		        <tr valign="top">
		        <th scope="row">Desktop Minimum size (Pixels)</th>
		        <td><input type="number" name="desktop_breakopint" value="<?php echo esc_attr( $desktop_breakopint ); ?>" /></td>
		        </tr>
		         
		        <tr valign="top">
		        <th scope="row">Tablet Maximum size (Pixels)</th>
		        <td><input type="number" name="tablet_breakopint_start" value="<?php echo esc_attr( $tablet_breakopint_start ); ?>" /></td>
		        </tr>
		        
		        <tr valign="top">
		        <th scope="row">Tablet Minimum size (Pixels)</th>
		        <td><input type="number" name="tablet_breakopint_end" value="<?php echo esc_attr( $tablet_breakopint_end ); ?>" /></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row">Mobile Maximum size (Pixels)</th>
		        <td><input type="number" name="mobile_breakopint_end" value="<?php echo esc_attr( $mobile_breakopint_end ); ?>" /></td>
		        </tr>
		    </table>
		    
		    <?php submit_button(); ?>

		</form>
		</div>

		<?php

	}

}
