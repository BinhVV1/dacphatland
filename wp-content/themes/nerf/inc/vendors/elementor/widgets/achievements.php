<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Nerf_Elementor_Achievements extends Widget_Base {

	public function get_name() {
        return 'apus_element_achievements';
    }

	public function get_title() {
        return esc_html__( 'Apus Achievements', 'nerf' );
    }

	public function get_icon() {
        return 'eicon-image-box';
    }

	public function get_categories() {
        return [ 'nerf-elements' ];
    }

	protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Achievements', 'nerf' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_icon',
            [
                'label' => esc_html__( 'Image or Icon', 'nerf' ),
                'type' => Controls_Manager::SELECT,
                'options' => array(
                    'icon' => esc_html__('Icon', 'nerf'),
                    'image' => esc_html__('Image', 'nerf'),
                ),
                'default' => 'image'
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'nerf' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'image_icon' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'nerf' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'image_icon' => 'image',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'nerf' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'This is the heading', 'nerf' ),
                'placeholder' => esc_html__( 'Enter your title', 'nerf' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__( 'Content', 'nerf' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'nerf' ),
                'placeholder' => esc_html__( 'Enter your description', 'nerf' ),
                'separator' => 'none',
                'rows' => 10,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link to', 'nerf' ),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'nerf' ),
                'separator' => 'before',
            ]
        );


        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'nerf' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'nerf' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'nerf' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'nerf' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'nerf' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .item-inner' => 'text-align: {{VALUE}};',
                ],
            ]
        );

   		$this->add_control(
            'el_class',
            [
                'label'         => esc_html__( 'Extra class name', 'nerf' ),
                'type'          => Controls_Manager::TEXT,
                'placeholder'   => esc_html__( 'If you wish to style particular content element differently, please add a class name to this field and refer to it in your custom CSS file.', 'nerf' ),
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__( 'Style', 'nerf' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'nerf' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .inner-left' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Icon Typography', 'nerf' ),
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .inner-left',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'nerf' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Title Typography', 'nerf' ),
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .title',
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => esc_html__( 'Description Color', 'nerf' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}} .description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__( 'Description Typography', 'nerf' ),
                'name' => 'desc_typography',
                'selector' => '{{WRAPPER}} .description',
            ]
        );

        $this->end_controls_section();

    }

	protected function render() {

        $settings = $this->get_settings();

        extract( $settings ); ?>
        <div class="widget-achievements flex-bottom justify-content-center <?php echo esc_attr($el_class); ?>">
            <?php if ( $image_icon == 'image' ) { ?>
                <?php if ( !empty($image_icon['id']) ) { ?>
                    <div class="inner-left">
                        <?php echo nerf_get_attachment_thumbnail($image_icon['id'], 'full'); ?>
                        <span class="verify"><i class="fa fa-check"></i></span>
                    </div>
                <?php } ?>
            <?php } elseif ( $image_icon == 'icon' && !empty($icon) ){ ?>
                <div class="inner-left">
                    <i class="<?php echo esc_attr($icon); ?>"></i> 
                    <span class="verify"><i class="fa fa-check"></i></span>
                </div>
            <?php } ?>
            <div class="info-right">
                <?php if( !empty($title) ) { ?>
                    <h2 class="title" >
                       <?php echo esc_attr( $title ); ?>
                    </h2>
                <?php } ?>
                <?php if ( !empty($description) ) { ?>
                    <div class="description">
                        <?php
                            echo trim( $description );
                        ?>
                    </div>
                <?php } ?>
            </div>
        </div> 
        <?php 
    }
}

if ( version_compare(ELEMENTOR_VERSION, '3.5.0', '<') ) {
    Plugin::instance()->widgets_manager->register_widget_type( new Nerf_Elementor_Achievements );
} else {
    Plugin::instance()->widgets_manager->register( new Nerf_Elementor_Achievements );
}