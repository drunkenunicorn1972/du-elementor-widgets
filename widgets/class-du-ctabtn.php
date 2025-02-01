<?php
/**
 * Call to Action Button Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_CTA_Button_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_ctabtn';
    }

    public function get_title()
    {
        return __('Call to Action Button', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-button';
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
                'label' => __('Call to Action Button', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'default' => 'ctabtn--01',
                'options' => [
                    'ctabtn--01' => __('Style 01', 'du-elem'),
                    'ctabtn--02' => __('Style 02', 'du-elem'),
                    'ctabtn--03' => __('Style 03', 'du-elem'),
                ],
            ],
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        global $plugin_images;

        $settings = $this->get_settings_for_display();
        if (isset($settings['du_cta_button_link']['url'])) {
            $target = $settings['du_cta_button_link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $settings['du_cta_button_link']['nofollow'] ? ' rel="nofollow"' : '';
        }

        if (isset($settings['du_cta_bgimage']['url']) && !empty($settings['du_cta_bgimage']['url']) && strpos($settings['du_cta_bgimage']['url'], 'placeholder') === false) {
            $bgimage = 'style="background-image: url(' . esc_url( $settings['du_cta_bgimage']['url'] ) . ');"';
            $classbgimage = 'bgimage';
        } else {
            $bgimage = '';
            $classbgimage = 'no-bgimage';
        }

        echo '<div class="du-section-ctabtn ' . $settings["du_cta_style"] . ' ' . $classbgimage . '" ' . $bgimage . '>';
        if (isset($settings['du_cta_button_link']['url'])) {
            echo '<a href="' . $settings['du_cta_button_link']['url'] . '" ' . $target . $nofollow . ' class="btn">';
        }
        echo '<div class="btn-text"><h2>' . $settings['du_cta_button_text'] . '</h2></div>';
        echo '<div class="btn-arrow"><wvicon class="icon-arrow-right-circle"></wvicon></div>';
        if (isset($settings['du_cta_button_link']['url'])) {
            echo '</a>';
        }
        echo '</div>';

    }


}
