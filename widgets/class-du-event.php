<?php
/**
 * Event Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Event_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_event';
    }

    public function get_title()
    {
        return __('Event / Workshop', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-info-box';
    }

    public function get_keywords()
    {
        return ['Rvr', 'event', 'workshop', 'calendar-item'];
    }

    public function get_categories()
    {
        return ['DU_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_event',
            [
                'label' => __('Event / Workshop', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_event_title',
            [
                'label' => __('Title Text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Title', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_event_text',
            [
                'label' => __('Event Description', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'du_event_date',
            [
                'label' => __('Event date', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Date or Text', 'du-elem'),
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_event_price',
            [
                'label' => __('Event price', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('19,99', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_event_buttontext',
            [
                'label' => __('Button Text', 'du-elem'),
                'label_block' => true,
                'placeholder' => __('Type something special here, my friend!', 'du-elem'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Learn More', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_event_link',
            [
                'label' => __('Button Link', 'du-elem'),
                'type' => \Elementor\Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false
                ],
            ]
        );

        $this->add_control(
            'du_event_image',
            [
                'label' => esc_html__('Choose Image', 'du-elem'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $target = $settings['du_event_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['du_event_link']['nofollow'] ? ' rel="nofollow"' : '';

        echo '<div class="du-section-event">';
        echo '<a href="' . $settings['du_event_link']['url'] . '" ' . $target . $nofollow . '>';

        echo '<div class="inner-container-top" style="background-image: url(' . $settings['du_event_image']['url'] . ');">';
        echo '<div class="event-date"><wvicon class="icon-calendar"></wvicon>' . $settings['du_event_date'] . '</div>';
        if ($settings['du_event_price']) {
            echo '<div class="event-price"><wvicon class="icon-user"></wvicon>&euro;&nbsp;' . $settings['du_event_price'] . '</div>';
        }
        echo '</div>';

        echo '<div class="inner-container-bottom">';
        echo '<div class="event-title">' . $settings['du_event_title'] . '</div>';
        echo '<div class="event-description">' . $settings['du_event_text'] . '</div>';
        echo '<div class="event-button">' . $settings['du_event_buttontext'] . '</div>';
        echo '</div>';

        echo '</a>';
        echo '</div>';

    }


}