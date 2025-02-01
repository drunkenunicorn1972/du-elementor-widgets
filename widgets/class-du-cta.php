<?php
/**
 * Call to Action Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Call_To_Action_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_cta';
    }

    public function get_title()
    {
        return __('Call to Action Card', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-call-to-action';
    }

    public function get_keywords()
    {
        return ['Rvr', 'action', 'call to', 'happy', 'cta'];
    }

    public function get_categories()
    {
        return ['DU_category'];
    }


    protected function _register_controls()
    {
        global $plugin_images;

        $this->start_controls_section(
            'DU_cta',
            [
                'label' => __('Call to Action', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_cta_title',
            [
                'label' => __('Title Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('CTA Title', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_cta_subtitle',
            [
                'label' => __('Sub Title Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Subtitle goes here', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_cta_desc',
            [
                'label' => __('Description', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Description', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_cta_button_text',
            [
                'label' => __('Button Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Button Text', 'du-elem'),
                'default' => __('Submit', 'du-elem'),

            ]
        );

        $this->add_control(
            'du_cta_button_link',
            [
                'label' => __('Button Link', 'du-elem'),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => true,
                    'nofollow' => false,
                ],
            ]
        );

        $this->add_control(
            'du_cta_bgimage',
            [
                'label' => esc_html__( 'Choose Background Image', 'du-elem' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'du_cta_style',
            [
                'label' => __('CTA Style', 'du-elem'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'ctastyle--01',
                'options' => [
                    'ctastyle--01' => __('Style 01', 'du-elem'),
                    'ctastyle--02' => __('Style 02', 'du-elem'),
                    'ctastyle--03' => __('Style 03', 'du-elem'),
                    'ctastyle--04' => __('Style 04', 'du-elem'),
                ],
            ],
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        global $plugin_images;
        $settings = $this->get_settings_for_display();
        $cta_btn_link = '';

        if (isset($settings['du_cta_button_link']) && isset($settings['du_cta_button_text'])) {
            $target = $settings['du_cta_button_link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $settings['du_cta_button_link']['nofollow'] ? ' rel="nofollow"' : '';
            $cta_btn_link = '<a href="' . $settings['du_cta_button_link']['url'] . '" ' . $target . $nofollow . ' class="btn">' . $settings['du_cta_button_text'] . ' <wvicon class="icon-arrow-right"></wvicon>' . '</a>';
        }

        if (isset($settings['du_cta_bgimage']['url']) && !empty($settings['du_cta_bgimage']['url']) && strpos($settings['du_cta_bgimage']['url'], 'placeholder') === false) {
            $bgimage = 'style="background-image: url(' . esc_url( $settings['du_cta_bgimage']['url'] ) . ');"';
            $classbgimage = 'bgimage';
        } else {
            $bgimage = '';
            $classbgimage = 'no-bgimage';
        }

        echo '<div class="du-section-call-to-action ' . $settings["du_cta_style"] . '">';
        echo '<div class="left-container ' . $classbgimage . '" ' . $bgimage . '>';
        echo '<div class="inner-color-container">';
        echo '<div class="cta-title">';
        echo '<h2>' . $settings['du_cta_title'] . '</h2>';
        if ($settings['du_cta_subtitle']) {
            echo '<div class="sub-title">' . $settings['du_cta_subtitle'] . '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="right-container">';
        echo '<p class="cta-desc">' . $settings['du_cta_desc'] . '</p>';
        echo $cta_btn_link;
        echo '</div>';
        echo '</div>';

    }


}
