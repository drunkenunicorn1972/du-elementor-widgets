<?php
/**
 * Team Member Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Teammember_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_teammember';
    }

    public function get_title()
    {
        return __('Teammember', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-person';
    }

    public function get_keywords()
    {
        return ['DU', 'teammember', 'team', 'person'];
    }

    public function get_categories()
    {
        return ['du_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_teammember',
            [
                'label' => __('Teammember', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_teammember_image',
            [
                'label' => esc_html__('Choose Image', 'du-elem'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'du_teammember_name',
            [
                'label' => __('Name', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('John Doe', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_teammember_function',
            [
                'label' => __('Function', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('CEO', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_teammember_text',
            [
                'label' => __('Teammember Description', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo '<div class="du-teammember">';

        echo '<div class="inner-container-top">';
        echo '<img src=" ' . $settings['du_teammember_image']['url'] .  ' " alt="' . $settings['du_teammember_name'] . '">';
        echo '</div>';

        echo '<div class="inner-container-bottom">';
        echo '<div class="name">' . $settings['du_teammember_name'] . '</div>';
        echo '<div class="function">' . $settings['du_teammember_function'] . '</div>';
        if (strlen(trim($settings['du_event_buttontext']))>0) {
            echo '<div class="description">' . $settings['du_event_buttontext'] . '</div>';
        }
        echo '</div>';

        echo '</div>';

    }


}