<?php
/**
 * Quote Widget
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class DU_Quote_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_quote';
    }

    public function get_title()
    {
        return __('Quote', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-blockquote';
    }

    public function get_keywords()
    {
        return ['Rvr', 'quote'];
    }

    public function get_categories()
    {
        return ['du_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_quote',
            [
                'label' => __('Quote', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_quote_title',
            [
                'label' => __('Title Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Quote Title', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_quote_subtitle',
            [
                'label' => __('Sub Title Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Subtitle goes here', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_quote_author',
            [
                'label' => __('Author', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Author', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_quote_style',
            [
                'label' => __( 'Quote Style', 'du-elem' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'qte-default',
                'options' => [
                    'qte-default'   => __( 'Default', 'du-elem' ),
                    'qte-transparent' => __( 'Transparent Background', 'du-elem' ),
                    'qte-darkwindow'    => __( 'Shade behind text', 'du-elem' ),
                ],
            ],
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        echo '<div class="du-section-quote ' . $settings["du_quote_style"] . '">';
        echo '<div class="inner-container">';

        echo '<blockquote>';
        echo '<div class="du-quote-symbol">“</div>';
        echo '<div class="du-quote-title">' . $settings['du_quote_title'] . '</div>';
        if ($settings['du_quote_subtitle']) {
            echo '<div class="du-quote-subtitle">' . $settings['du_quote_subtitle'] . '</div>';
        }
        echo '</blockquote>';

        if ($settings["du_quote_author"]) {
            echo '<div class="du-quote-author">-- ' . $settings['du_quote_author'] . '</div>';
        }

        echo '</div>';
        echo '</div>';

    }


}
