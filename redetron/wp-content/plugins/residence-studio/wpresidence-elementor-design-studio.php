<?php
/**
 * Plugin Name: WpResidence Elementor Design Studio
 * Description: Elementor Design Studio for WpResidence
 * Plugin URI:  https://themeforest.net/item/wp-residence-real-estate-wordpress-theme/7896392
 * Version:     5.0.9
 * Author:      WpEstate
 * Author URI:  https://wpestate.org/
 * Text Domain: wpestate-studio-templates
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
 
final class WpResidence_Elementor_Design_Studio {

    const VERSION = '1.0.0';
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    public $header_footer_instance;
    private $admin_notices;
    private $ajax_callbacks;
    private $init_plugin;
    private $custom_post_type;
    private $meta_boxes;
    private $custom_columns;

    /**
     * Constructor. Adds initialization hooks.
     */
    public function __construct() {
        add_action('init', [$this, 'i18n']);
        add_action('plugins_loaded', [$this, 'init']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_styles']);
        add_action('elementor/editor/before_wp', [$this, 'add_custom_button']);
        add_action('elementor/editor/footer', [$this, 'render_template']);
        add_action('elementor/frontend/before_enqueue_styles', [$this, 'force_styles']);
    }

    /**
     * Enqueues custom styles for the frontend.
     */
    public function force_styles() { ?>
        <style>
            .wpestate-library-open-modal {
                margin-left: 5px;
                padding: 9px !important;
                animation: pulsex 2s infinite;
            }
            .wpestate-library-open-modal:before {
                content: '';
                width: 22px;
                height: 22px;
                background-image: url('<?php echo WP_PLUGIN_URL . '/residence-studio/img/editor-wpresidence.svg'; ?>');
                background-position: center center;
                background-size: contain;
                background-repeat: no-repeat;
            }
            @keyframes pulsex {
                0% {
                    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.3);
                }
                70% {
                    box-shadow: 0 0 0 7px rgba(207, 207, 207, 0.7);
                }
                100% {
                    box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
                }
            }
            .wpestate-library-template-name {
                font-size: 20px;
            }
        </style>
    <?php }

    /**
     * Loads plugin textdomain for translations.
     */
    public function i18n() {
        load_plugin_textdomain('residence-elementor-studio');
    }

    /**
     * Initializes the plugin by including required files and setting up instances.
     */
    public function init() {
        require_once(__DIR__ . '/includes/class-admin-notices.php');
        require_once(__DIR__ . '/includes/class-header-footer-templates.php');
        require_once(__DIR__ . '/includes/class-ajax-callbacks.php');
        require_once(__DIR__ . '/includes/class-init.php');
        require_once(__DIR__ . '/includes/class-custom-post-type.php');
        require_once(__DIR__ . '/includes/class-meta-boxes.php');
        require_once(__DIR__ . '/includes/class-custom-columns.php');
        require_once(__DIR__ . '/includes/helper_functions.php');
        require_once(__DIR__ . '/plugin.php');
        require_once(__DIR__ . '/functions/elementor-menu-walker.php');
        require_once(__DIR__ . '/functions/elementor-menu-mobile-walker.php');
  
        $this->admin_notices = new WpResidence_Elementor_Admin_Notices();
        $this->header_footer_instance = new WpResidence_Elementor_Header_Footer_Templates();
        $this->ajax_callbacks = new WpResidence_Elementor_Ajax_Callbacks();
        $this->init_plugin = new WpResidence_Elementor_Init();
        $this->custom_post_type = new WpResidence_Custom_Post_Type();
        $this->meta_boxes = new WpResidence_Meta_Boxes();
        $this->custom_columns = new WpResidence_Custom_Columns();

        add_filter('single_template', [$this, 'force_elementor_canvas_template'], 10, 1);
        add_action('template_redirect', [$this, 'restrict_template_access']);
        add_action('wp_ajax_wpestate_add_head_foot', [$this->ajax_callbacks, 'add_head_foot_callback']);
    }

    /**
     * Enqueues custom scripts for Elementor editor.
     */
    public function enqueue_scripts() {
        wp_enqueue_script('elementor-custom-button', plugins_url('/js/custom-button.js', __FILE__), ['jquery', 'elementor-editor'], '1.0', true);
        wp_localize_script('elementor-custom-button', 'wpestate_ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wpestate_nonce') // Generate nonce
        ));
        
    }

    /**
     * Enqueues custom styles for Elementor editor.
     */
    public function enqueue_styles() {
        wp_enqueue_style('elementor-custom-button', plugins_url('/css/custom.css', __FILE__));
    }

    /**
     * Adds a custom button to the Elementor editor interface.
     */
    public function add_custom_button() {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var buttonHtml = '<div id="custom-library-button" class="elementor-add-new-section elementor-button elementor-button-success">' +
                                 '<i class="eicon-library"></i><span class="elementor-button-title">My Templates</span></div>';
                $('.elementor-add-section .elementor-add-new-section').last().after(buttonHtml);

                $('#custom-library-button').on('click', function() {
                    elementor.templates.getModal().show();
                    elementor.templates.getTemplatesTab().setActiveView('my-custom-templates');
                });
            });
        </script>
        <?php
    }

    /**
     * Forces the use of Elementor canvas template for specific post types.
     *
     * @param string $template The path to the template to be used.
     * @return string The path to the Elementor canvas template.
     */
    public function force_elementor_canvas_template($template) {
        if (is_singular('wpestate-studio')) {
            $template = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';
            if (file_exists($template)) {
                return $template;
            }
            return ELEMENTOR_PATH . '/includes/page-templates/canvas.php';
        }
        return $template;
    }

    /**
     * Restricts access to specific templates based on user capabilities.
     */
    public function restrict_template_access() {
        if (is_singular('wpestate-studio') && !current_user_can('edit_posts')) {
            wp_redirect(home_url(), 301);
            exit;
        }
    }

    /**
     * Renders the template modal for Elementor editor.
     */
public function render_template() {
    ?>
        <script type="text/html" id="wpestate-library-modal-header">
            <div class="elementor-templates-modal__header">
                <div class="elementor-templates-modal__header__logo-area">
                    <div class="elementor-templates-modal__header__logo">
                        <span class="elementor-templates-modal__header__logo__title" id="wpestate-template-header-title">
                            WpResidence Templates
                        </span>
                    </div>
                </div>

                <div class="elementor-templates-modal__header__menu-area">
                    <div id="wpestate-studio-header-menu">
                        <div id="wpestate-tab-block" class="elementor-component-tab elementor-template-library-menu-item elementor-active" data-tab="block">Custom Blocks</div>
                        <div id="wpestate-tab-template" class="elementor-component-tab elementor-template-library-menu-item" data-tab="template">Full Pages</div>
                    </div>
                </div>

                <div class="elementor-templates-modal__header__items-area">
                    <div class="elementor-templates-modal__header__close elementor-templates-modal__header__close--normal elementor-templates-modal__header__item">
                        <i class="eicon-close" aria-hidden="true" title="<?php echo esc_html__('Close', 'wpestate-studio-templates'); ?>"></i>

                        <span class="elementor-screen-only">
                            <?php echo esc_html__('Close', 'wpestate-studio-templates'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </script>

        <script type="text/html" id="tmpl-wpestate-studio-modal-order">
            <div id="elementor-template-library-filter">
                <select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select" data-elementor-filter="subtype">
                    <option value="all"><?php echo esc_html__('All', 'wpestate-studio-templates'); ?></option>
                    <# data.tags.forEach(function(item, i) { #>
                        <option value="{{{item.slug}}}">{{{item.title}}}</option>
                    <# }); #>
                </select>
            </div>
        </script>

        <script type="text/template" id="tmpl-wpestate-studio-header-menu">
            <# jQuery.each( tabs, ( tab, args ) => { #>    
                <div class="elementor-component-tab elementor-template-library-menu-item" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
            <# } ); #>
        </script>

        <script type="text/html" id="tmpl-wpestate-template-preview-container">
            <div class="template-preview" style="width: 100%; height: 100%; background-color: red;">
                {{{data.content}}}
            </div>
        </script>

        <script type="text/html" id="wpestate-elementor-load-modal">
            <div id="elementor-template-library-templates" data-template-source="remote">
                <div id="elementor-template-library-toolbar">
                    <div id="elementor-template-library-filter-toolbar-remote" class="elementor-template-library-filter-toolbar"></div>

                    <div id="elementor-template-library-filter-text-wrapper">
                        <label for="elementor-template-library-filter-text" class="elementor-screen-only"><?php echo esc_html__('Search Templates:', 'wpestate-studio-templates'); ?></label>
                        <input id="elementor-template-library-filter-text" placeholder="<?php echo esc_attr__('Search', 'wpestate-studio-templates'); ?>">
                        <i class="eicon-search"></i>
                    </div>
                </div>

                <div id="elementor-template-library-templates-container"></div>
                <div id="elementor-template-library-preview" style="position: absolute;display:none;  background-color: red;width: auto; height: auto;inset: 120px 10px 20px;"></div> <!-- Preview container -->

            </div>

            <div class="elementor-loader-wrapper" style="display: none">
                <div class="elementor-loader">
                    <div class="elementor-loader-boxes">
                        <div class="elementor-loader-box"></div>
                        <div class="elementor-loader-box"></div>
                        <div class="elementor-loader-box"></div>
                        <div class="elementor-loader-box"></div>
                    </div>
                </div>
                <div class="elementor-loading-title"><?php echo esc_html__('Loading', 'wpestate-studio-templates'); ?></div>
            </div>
        </script>

        <script type="text/html" id="tmpl-wpestate-studio-modal-item">
            <# data.elements.forEach(function(item, i) { #>
                <div class="elementor-template-library-template elementor-template-library-template-remote elementor-template-library-template-{{{item.type === 'template' ? 'page' : 'block'}}}" data-slug="{{{item.slug}}}" data-tag="{{{item.category}}}" data-type="{{{item.type}}}" data-name="{{{item.title}}}">
                    <div class="elementor-template-library-template-body">
                        <# if (item.type === 'block') { #>
                            <img src="{{{item.image}}}">
                        <# } else { #>
                        <div class="elementor-template-library-template-screenshot" style="background-image: url({{{item.image}}})"></div>
                        <# } #>
                        
                        <a class="elementor-template-library-template-preview wpresidence-studio-preview" href="{{{item.link}}}" target="_blank" data-template-id="{{{item.id}}}">
                           <?php echo esc_html__('Live Preview', 'wpestate-studio-templates'); ?> <i class="eicon-editor-external-link" aria-hidden="true"></i>
                        </a>
                        
                        
                    </div>
                    <div class="elementor-template-library-template-footer">
                        <a class="elementor-template-library-template-action elementor-template-library-template-insert elementor-button wpresidence-elementor-button-title" data-id="{{{item.id}}}">
                            <i class="eicon-file-download" aria-hidden="true"></i>
                            <span class="elementor-button-title ">Insert</span>
                        </a>
                        <div>{{{item.title}}}</div>
                    </div>
                </div>
            <# }); #>
        </script>
    <?php
}








}

global $wpestate_studio;
$wpestate_studio = new WpResidence_Elementor_Design_Studio();
