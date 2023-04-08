<?php
/* Exit if accessed directly */
if (!defined('ABSPATH')) {
    exit;
}

GFForms::include_addon_framework();

class GFColorPickerAddOn extends GFAddOn
{
    protected $_version = GF_COLOR_PICKER_ADDON_VERSION;
    protected $_min_gravityforms_version = '1.9';
    protected $_slug = 'gf-color-picker';
    protected $_path = 'gf-color-picker/gf-color-picker.php';
    protected $_full_path = __FILE__;
    protected $_title = 'Gravity Forms Color Picker Field Add-On';
    protected $_short_title = 'Color Picker Field Add-On';
    private static $_instance = null;

    public static function get_instance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function pre_init()
    {
        parent::pre_init();

        if ($this->is_gravityforms_supported() && class_exists('GF_Field')) {
            require_once('includes/class-gf-color-picker.php');
        }
    }

    public function init_admin()
    {
        parent::init_admin();

        add_filter('gform_tooltips', array($this, 'tooltips'));
        add_action('gform_field_appearance_settings', array($this, 'field_appearance_settings'), 10, 2);
    }

    public function tooltips($tooltips)
    {
        $simple_tooltips = array(
            'input_class_setting' => sprintf('<h6>%s</h6>%s', esc_html__('Input CSS Classes', 'gf-color-picker'), esc_html__('The CSS Class names to be added to the field input.', 'gf-color-picker')),
        );

        return array_merge($tooltips, $simple_tooltips);
    }

    public function field_appearance_settings($position, $form_id)
    {
        // Add our custom setting just before the 'Custom CSS Class' setting.
        if ($position == 250) {
?>
            <li class="input_class_setting field_setting">
                <label for="input_class_setting">
                    <?php esc_html_e('Input CSS Classes', 'gf-color-picker'); ?>
                    <?php gform_tooltip('input_class_setting') ?>
                </label>
                <input id="input_class_setting" type="text" class="fieldwidth-1" onkeyup="SetInputClassSetting(jQuery(this).val());" onchange="SetInputClassSetting(jQuery(this).val());" />
            </li>

<?php
        }
    }

    public function styles()
    {
        $styles = array(
            array(
                'handle'  => 'gf-color-picker-style',
                'src'     => $this->get_base_url() . '/assets/compiled/frontend.css',
                'version' => $this->_version,
                'enqueue' => array(
                    array('field_types' => array('colorpicker'))
                )
            )
        );

        return array_merge(parent::styles(), $styles);
    }
}
