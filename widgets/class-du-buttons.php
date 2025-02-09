<?php
/**
 * B2W Button Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Buttons_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'DU_buttons';
    }

    public function get_title()
    {
        return __('Big Button', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-button';
    }

    public function get_keywords()
    {
        return ['Du', 'button', 'link', 'ui', 'cta', 'happy'];
    }

    public function get_categories()
    {
        return ['du_category'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_buttons',
            [
                'label' => __('Big Button', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // add our controls
        $this->add_control(
            'du_button_title',
            [
                'label' => __('Button Title', 'du-elem'),
                'label_block' => true,
                'placeholder' => __('', 'du-elem'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Title', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_button_text',
            [
                'label' => __('Button Text', 'du-elem'),
                'label_block' => true,
                'placeholder' => __('Type something special here, my friend!', 'du-elem'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Learn More', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_button_image',
            [
                'label' => esc_html__('Choose Image', 'du-elem'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'du_button_link',
            [
                'label' => __('Button Link', 'du-elem'),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => false
                ],
            ]
        );

        $this->add_control(
            'du_button_style',
            [
                'label' => __('Button Style', 'du-elem'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'btn-primary',
                'options' => [
                    'btn-primary' => __('Primary', 'du-elem'),
                    'btn-secondary' => __('Secondary', 'du-elem'),
                    'btn-invert' => __('Invert', 'du-elem'),
                ],
            ],
        );

        $this->add_responsive_control(
            'du_button_align',
            [
                'label' => __('Alignment', 'du-elem'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [

                    'left' => [
                        'title' => __('Left', 'du-elem'),
                        'icon' => 'eicon-text-align-left',
                    ],

                    'center' => [
                        'title' => __('Center', 'du-elem'),
                        'icon' => 'eicon-text-align-center',
                    ],

                    'right' => [
                        'title' => __('Right', 'du-elem'),
                        'icon' => 'eicon-text-align-right',
                    ],

                ],

                'devices' => ['desktop', 'tablet', 'mobile'],
                'default' => 'left',
                'selectors' => [
                    '{{WRARvrR}} .link-box' => 'text-align: {{VALUE}};',
                ],
                'toggle' => true,

            ],
        );


        $this->end_controls_section();

    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();
        $target = $settings['du_button_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['du_button_link']['nofollow'] ? ' rel="nofollow"' : '';

        echo '<div class="du-big-button ' . $settings["button_align"] . ' ' . $settings['du_button_style'] . '">';
        echo '<a href="' . $settings['du_button_link']['url'] . '" ' . $target . $nofollow . '">';
        echo '<div class="btn-image">';
        echo '<img src="' . $settings["du_button_image"]["url"] . '" alt="' . $settings["du_button_image"]["alt"] . '" class="btn-pictogram">';
        echo '</div>';
        echo '<div class="btn-text">';
        echo '<h2>' . $settings["du_button_title"] . '</h2>';
        echo '<p>' . $settings["du_button_text"] . '</p>';
        echo '<wvicon class="icon-arrow-right-circle"></wvicon>';
        echo '</div>';
        echo '</a>';
        echo '</div>';

    }

}