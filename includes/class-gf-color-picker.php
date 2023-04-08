<?php

if (!class_exists('GFForms')) {
    die();
}
class Color_Picker_Field extends GF_Field
{
    public $type = 'colorpicker';

    public function get_form_editor_field_title()
    {
        return esc_attr__('Color', 'gf-color-picker');
    }

    public function get_form_editor_button()
    {
        return array(
            'group' => 'advanced_fields',
            'text'  => $this->get_form_editor_field_title(),
        );
    }

    /**
     * Returns the field's form editor icon.
     *
     * This could be an icon url or a gform-icon class.
     *
     * @return string
     */
    public function get_form_editor_field_icon()
    {
        return plugin_dir_url(__FILE__) . 'images/drop-icon.svg';
    }


    public function get_form_editor_field_settings()
    {
        return array(
            'conditional_logic_field_setting',
            'prepopulate_field_setting',
            'error_message_setting',
            'label_setting',
            'label_placement_setting',
            'admin_label_setting',
            'rules_setting',
            'visibility_setting',
            'duplicate_setting',
            'default_value_setting',
            'description_setting',
            'css_class_setting',
        );
    }

    public function is_conditional_logic_supported()
    {
        return true;
    }

    public function get_field_input($form, $value = '', $entry = null)
    {
        $form_id         = absint($form['id']);
        $is_entry_detail = $this->is_entry_detail();
        $is_form_editor  = $this->is_form_editor();

        $html_input_type = 'color';
        $class = 'gf-color-picker';

        $id          = (int) $this->id;
        $field_id    = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

        $value        = esc_attr($value);

        $tabindex              = $this->get_tabindex();
        $disabled_text         = $is_form_editor ? 'disabled="disabled"' : '';
        $placeholder_attribute = $this->get_field_placeholder_attribute();
        $required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
        $invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
        $aria_describedby      = $this->get_aria_describedby();
        $autocomplete          = $this->enableAutocomplete ? $this->get_field_autocomplete_attribute() : '';

        $input = "<input name='input_{$id}' id='{$field_id}' type='{$html_input_type}' value='{$value}' class='{$class}' {$aria_describedby} {$tabindex} {$placeholder_attribute} {$required_attribute} {$invalid_attribute} {$disabled_text} {$autocomplete} />";

        return sprintf("<div class='ginput_container ginput_container_color'>%s</div>", $input);
    }

    public function validate($value, $form)
    {
        $regex = '/#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/';
        if ($value !== '' && $value !== 0 && !preg_match($regex, $value)) {
            $this->failed_validation = true;
            if (!empty($this->errorMessage)) {
                $this->validation_message = $this->errorMessage;
            }
        }
    }
}

GF_Fields::register(new Color_Picker_Field());
