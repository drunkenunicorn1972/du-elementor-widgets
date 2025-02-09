<?php
/**
 * Slider Widget
 */

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Slider_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'DU_slider';
    }

    public function get_title()
    {
        return __('Responsive Slider', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-slides';
    }

    public function get_keywords()
    {
        return ['Rvr', 'slider', 'responsive', 'splide'];
    }

    public function get_categories()
    {
        return ['du_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'DU_event',
            [
                'label' => __('Responsive Slider', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_slides_list',
            [
                'label' => __('Slides', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'du_slide_large_image',
                        'label' => esc_html__( 'Desktop Image', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'media_types' => ['image']
                    ],
                    [
                        'name' => 'du_slide_small_image',
                        'label' => esc_html__( 'Mobile Image', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'media_types' => ['image']
                    ],
                    [
                        'name' => 'du_slide_title',
                        'label' => esc_html__( 'Title', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Title text' , 'du-elem' ),
                    ],
                    [
                        'name' => 'du_slide_subtitle',
                        'label' => esc_html__( 'Subtitle', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( 'Subtitle' , 'du-elem' ),
                    ],
                    [
                        'name' => 'du_slide_buttontext',
                        'label' => esc_html__( 'Button Text', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__( '' , 'du-elem' ),
                    ],
                    [
                        'name' => 'du_slide_button',
                        'label' => esc_html__( 'Button', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::URL,
                        'options' => [ 'url', 'is_external', 'nofollow' ],
                        'default' => [
                            'url' => '',
                            'is_external' => true,
                            'nofollow' => true,
                        ],
                        'label_block' => true,
                    ],
                    [
                        'name' => 'du_slide_startdate',
                        'label' => esc_html__( 'Startdate', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::DATE_TIME,
                    ],
                    [
                        'name' => 'du_slide_enddate',
                        'label' => esc_html__( 'Enddate', 'du-elem' ),
                        'type' => \Elementor\Controls_Manager::DATE_TIME,
                    ],
                ]

            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $elem_id = $this->get_id();
        $today = date_i18n('Y-m-d H:i');
        $inline_css_mobile = '';
        $inline_css_desktop = '';

        echo '<section class="du-splide splide" id="splide-' . $elem_id . '">';
        echo '<div class="du-splide__track splide__track">';
        echo '<ul class="splide__list">';

        foreach($settings['du_slides_list'] as $slide) {

            // check if the publication period of this slide is still valid
            $fromdate = $slide['du_slide_startdate'];
            $untildate = $slide['du_slide_enddate'];
            if ($fromdate == '') { $fromdate = '1900-01-01 00:00'; }
            if ($untildate == '') { $untildate = '2900-12-31 23:59'; }

            if ($fromdate <= $today && $untildate >= $today) {
                $target = $slide['du_slide_button']['is_external'] ? ' target="_blank"' : '';
                $nofollow = $slide['du_slide_button']['nofollow'] ? ' rel="nofollow"' : '';

                $large_image = $slide['du_slide_large_image']['url'];
                $small_image = $slide['du_slide_small_image']['url'];
                $item_id = $slide['_id'];

                $inline_css_mobile .= ".du-slide-id-" . $item_id . " { background-image: url('" . $small_image . "'); }\r\n";
                $inline_css_desktop .= ".du-slide-id-" . $item_id . " { background-image: url('" . $large_image . "'); }\r\n";

                echo '<li class="du-slide splide__slide du-slide-id-' . $item_id . '">';
                echo '<div class="du-slide-content">';
                echo '<h2>' . $slide['du_slide_title'] . '</h2>';
                echo '<h3>' . $slide['du_slide_subtitle'] . '</h3>';
                if (isset($slide['du_slide_buttontext'])) {
                    if (strlen(trim($slide['du_slide_buttontext'])) > 0) {
                        echo '<a href="' . $slide['du_slide_button']['url'] . '" ' . $target . $nofollow . '>' . trim($slide['du_slide_buttontext']) . '</a>';
                    }
                }
                echo '</li>';
            }
        }

        // Build inline css:
        $inline_css = "<style>" . $inline_css_mobile . "\r\n\r\n@media screen and (min-width: 900px) {" . $inline_css_desktop . "}\r\n</style>";

        ?>
        </ul>
        </div>
        </section>
        <?php echo $inline_css; ?>
        <script>
        // document.addEventListener( 'DOMContentLoaded', function() {
            let elementId_<?php echo $elem_id; ?> = '#splide-<?php echo $elem_id; ?>';
            console.log('Starting slider ' + elementId_<?php echo $elem_id; ?>);
            // bind it to splide
            let slider_<?php echo $elem_id; ?> = new Splide(elementId_<?php echo $elem_id; ?>, {
                type: 'fade',
                autoplay: 'play',
                perPage: 1,
                perMove: 1,
                interval: 5000,
                pagination: true,
                autoWidth: false,
                rewind: true
            }).mount();
        // });
        </script>
        <?php
    }

    protected function content_template() {
        $elem_id = $this->get_id();
        ?>
        <script>
            let elementId_<?php echo $elem_id; ?> = '#splide-<?php echo $elem_id; ?>';
            slider_<?php echo $elem_id; ?>.refresh();
        </script>
        <?php
    }
}