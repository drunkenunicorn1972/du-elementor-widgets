<?php
/**
 * Responsive Image Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class DU_Responsive_Image_Widget extends \Elementor\Widget_Base
{


    public function get_name()
    {
        return 'du_responsive_image';
    }

    public function get_title()
    {
        return __('Responsive Image', 'du-elem');
    }

    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_keywords()
    {
        return ['DU', 'image', 'responsive', 'image'];
    }

    public function get_categories()
    {
        return ['du_category'];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(
            'du_responsive_image',
            [
                'label' => __('Responsive Image', 'du-elem'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'du_responsive_image_desktop',
            [
                'label' => esc_html__('Choose Desktop Image', 'du-elem'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'du_responsive_image_mobile',
            [
                'label' => esc_html__('Choose Mobile Image', 'du-elem'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->add_control(
            'du_responsive_image_alt',
            [
                'label' => __('Alternative text', 'du-elem'),
                'label_block' => true,
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('', 'du-elem'),
            ]
        );

        $this->add_control(
            'du_responsive_image_link',
            [
                'label' => esc_html__( 'Link', 'du-elem' ),
                'type' => \Elementor\Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'show_label' => true,
            ]
        );

        $this->add_control(
            'du_responsive_image_fullwidth',
            [
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Full width', 'du-elem' ),
                'label_on' => esc_html__( 'Full', 'du-elem' ),
                'label_off' => esc_html__( 'Normal', 'du-elem' ),
                'description' => esc_html__( 'Show the image full width inside its container', 'du-elem' ),
                'show_label' => true,
            ]
        );

        $this->add_responsive_control(
            'du_responsive_image_borderradius',
            [
                'label' => esc_html__( 'Border Radius', 'du-elem' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if ($settings['du_responsive_image_fullwidth'] == 'yes') {
            $fwclass = 'fullwidth';
        } else {
            $fwclass = 'originalwidth';
        }

        if (isset($settings['du_responsive_image_borderradius'])) {
            $borderradius = 'border-radius: ' . $settings['du_responsive_image_borderradius']['top'] . $settings['du_responsive_image_borderradius']['unit'] . ', ' . $settings['du_responsive_image_borderradius']['right'] . $settings['du_responsive_image_borderradius']['unit'] . ', ' . $settings['du_responsive_image_borderradius']['bottom'] . $settings['du_responsive_image_borderradius']['unit'] . ', ' . $settings['du_responsive_image_borderradius']['left'] . $settings['du_responsive_image_borderradius']['unit'] . ';';
        }

        // Don't use the full image size, but load the appropriate sizes for the different screens
        if (!empty($settings["du_responsive_image_desktop"]["id"])) { $img_desktop = wp_get_attachment_image_src($settings["du_responsive_image_desktop"]["id"], 'large'); }
        if (!empty($settings["du_responsive_image_mobile"]["id"])) { $img_mobile = wp_get_attachment_image_src($settings["du_responsive_image_mobile"]["id"], 'medium'); } else { $img_mobile = $img_desktop; }

        echo '<div class="du-responsive-image ' . $fwclass . '">';
        if (isset($settings["du_responsive_image_link"]["url"])) {
            echo '<a href="' . $settings["du_responsive_image_link"]["url"] . '" target="' . $this->get_target($settings["du_responsive_image_link"]["is_external"]) . '" >';
        }
        echo '<picture style="' . $borderradius . '">';
        echo '<source srcset="' . $img_desktop["0"] . '" media="(min-width: 400px)">';
        echo '<source srcset="' . $img_mobile["0"] . '" media="(max-width: 399px)">';
        echo '<img src="' . $img_desktop["0"] . '" alt="' . $settings["du_responsive_image_alt"] . '">';
        echo '</picture>';
        if (isset($settings["du_responsive_image_link"]["url"])) {
            echo '</a>';
        }
        echo '</div>';

    }

    public function content_template() {
        ?>

        <# if ( settings.du_responsive_image_desktop.url ) {
        var du_responsive_image_desktop = {
        id: settings.du_responsive_image_desktop.id,
        url: settings.du_responsive_image_desktop.url,
        size: settings.du_responsive_image_desktop.size,
        };

        var image_url = elementor.imagesManager.getImageUrl( du_responsive_image_desktop );

        if ( ! image_url ) {
            return;
        }

        var link_url;

        if ( 'custom' === settings.link_to ) {
            link_url = settings.link.url;
        }

        if ( 'file' === settings.link_to ) {
            link_url = settings.image.url;
        }

        var imgClass = '';

        if ( link_url ) {
        #><a href="{{ elementor.helpers.sanitizeUrl( link_url ) }}"><#
            }
            #><img src="{{ image_url }}" class="{{ imgClass }}" /><#

            if ( link_url ) {
            #></a><#
        }

        } #>

        <?php
    }

    /**
     * Determines the target attribute value based on the provided external parameter.
     *
     * @param string $external A string indicating whether the link is external ('on') or not.
     * @return string Returns '_blank' if the link is external, otherwise returns '_self'.
     */
    private function get_target($external){
        if($external == 'on'){
            return '_blank';
        }
        return '_self';
    }

}