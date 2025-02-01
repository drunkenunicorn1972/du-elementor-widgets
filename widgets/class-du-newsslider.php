<?php
/**
 * Event Widget
 */

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_NewsSlider_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_newsslider';
    }

    public function get_title()
    {
        return __('Posts slider', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-post-slider';
    }

    public function get_keywords()
    {
        return ['Rvr', 'posts', 'slider', 'news'];
    }

    public function get_categories()
    {
        return ['DU_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_newsslider',
            [
                'label' => __('Posts slider', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_newsslider_amount',
            [
                'label' => __('Show # items', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('6', 'du-elem'),
                'default' => __('6', 'du-elem'),
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $elem_id = $this->get_id();
        $target = ' target="_self"';
        $nofollow = ' rel="nofollow"';

        $args = array(
            'posts_per_page' => $settings['du_newsslider_amount'], // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
            'post_type' => 'post',
            'orderby' => 'date', // Order by date
        );

        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()) :

            echo '<section class="du-splide-conveyor splide" id="splide-conveyor-' . $elem_id . '">';
            echo '<div class="du-splide__track splide__track du-section-newsslider">';
//            echo '<h2>' . esc_html__('Aktuelles', 'du-elem') . '</h2>';
            echo '<ul class="splide__list">';

            while ($recent_posts->have_posts()) : $recent_posts->the_post();

                if (has_post_thumbnail()) {
                    $image_url = get_the_post_thumbnail_url();
                }
                $post_link = get_permalink();

                echo '<li class="du-newsslider-item splide__slide">';
                include 'templates/post-item.php';
                echo '</li>';

            endwhile;

            echo '</ul>';
            echo '</div>';
            echo '</section>';

            wp_reset_postdata();

            ?>
            <script>
                function run_splide_conveyor_<?php echo $elem_id; ?>() {
                    let conveyorElementId_<?php echo $elem_id; ?> = '#splide-conveyor-<?php echo $elem_id; ?>';
                    console.log('Starting slider ' + conveyorElementId_<?php echo $elem_id; ?>);
                    // bound it to splide
                    let slider_<?php echo $elem_id; ?> = new Splide(conveyorElementId_<?php echo $elem_id; ?>, {
                        type: 'loop',
                        autoplay: false,
                        perPage: 4,
                        focus: 0,
                        perMove: 1,
                        interval: 5000,
                        pagination: true,
                        autoWidth: false,
                        omitEnd: true,
                        breakpoints: {
                            576: {
                                perPage: 1,
                            },
                            768: {
                                perPage: 2,
                            },
                            900: {
                                perPage: 3,
                            },
                            1200: {
                                perPage: 4,
                            }
                        }
                    }).mount();
                }

                run_splide_conveyor_<?php echo $elem_id; ?>();
            </script>
        <?php

        else:
            echo '<p>' . __('No recent posts found', 'du-elem') . '</p>';
        endif;
    }


}