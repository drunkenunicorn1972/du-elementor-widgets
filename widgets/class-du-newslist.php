<?php
/**
 * News list
 */

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Newslist_Widget extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'DU_newslist';
    }

    public function get_title()
    {
        return __('News list', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_keywords()
    {
        return ['Rvr', 'posts', 'list', 'news'];
    }

    public function get_categories()
    {
        return ['DU_category'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_newslist',
            [
                'label' => __('Posts slider', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_newslist_amount',
            [
                'label' => __('Show # items', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('12', 'du-elem'),
                'default' => __('12', 'du-elem'),
            ]
        );

        $this->end_controls_section();

    }

    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
        $elem_id = $this->get_id();
        if (isset($settings['du_event_link'])) {
            $target = $settings['du_event_link']['is_external'] ? ' target="_blank"' : '';
            $nofollow = $settings['du_event_link']['nofollow'] ? ' rel="nofollow"' : '';
        } else {
            $target = ' target="_blank"';
            $nofollow = ' rel="nofollow"';
        }
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $args = array(
            'posts_per_page' => $settings['du_newslist_amount'], // Number of recent posts thumbnails to display
            'post_status' => 'publish', // Show only the published posts
            'post_type' => 'post',
            'orderby' => 'date', // Order by date
            'paged' => $paged
        );

        $recent_posts = new WP_Query($args);

        if ($recent_posts->have_posts()) :

            echo '<div class="du-news-list">';
//            echo '<h2>' . esc_html__('Aktuelles', 'du-elem') . '</h2>';
            echo '<ul class="du-newslist">';

            while ($recent_posts->have_posts()) : $recent_posts->the_post();

                echo '<li class="du-newslist-item">';
                include 'templates/post-item.php';
                echo '</li>';

            endwhile;

            echo '</ul>';
            echo '</div>';

            // Display the pagination
            $big = 999999999; // need an unlikely integer

            echo '<div class="du-newslist-paging">';
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $recent_posts->max_num_pages,
            ));
            echo '</div>';

            wp_reset_postdata();

            ?>
        <?php

        else:
            echo '<p>' . __('No posts found', 'du-elem') . '</p>';
        endif;
    }


}