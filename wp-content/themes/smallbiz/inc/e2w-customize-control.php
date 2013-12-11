<?php
/**
 * Custom control class for SmallBiz and hooks.
 *
 * @package WordPress
 * @subpackage Expand2Web SmallBiz
 * @since Expand2Web SmallBiz 3.8.5 alpha
 */
 if(class_exists("WP_Customize_Control")){
    class e2w_Customize_Smallbiz_Control extends WP_Customize_Control {
        public function render_content() {
            $dir = dirname ( __FILE__ );
            $url = admin_url().'/themes.php?page=/'.substr($dir, 0, strlen($dir) - 3)."/functions.php";
            // always true: ($this->manager->is_preview()) 
                ?>
                <div id='e2w_Customize_Smallbiz_Control_text'>
                For more Customization Options visit the 
                <a id='e2w_Customize_Smallbiz_Control_link' href='<?php echo $url; ?>'>
                    SmallBiz Options Panel
                </a>.
                </div>
                <script type='text/javascript'>
                    jQuery(document).ready(function($) { 
                        var link = $('#e2w_Customize_Smallbiz_Control_link');
                        var button = $('#save');
                        if(String(button.val()).indexOf('Activate') >= 0){
                            $('#e2w_Customize_Smallbiz_Control_text').html('Please activate the theme to see all options.');
                        } else {
                            link.parent().parent().parent().parent().click(function(){
                                link.parent().parent().parent().hide();
                                window.location=(link.attr('href'));                            
                            });
                        }
                    });
                </script>
                <?php
        }
    }
    
    
    // hook in to the new wp3.4 custom options:
    add_action( 'customize_register', 'e2w_customize_page_options' );
    function e2w_customize_page_options($wp_customize)
    {
        $wp_customize->add_section( 'smallbiz_section', array(
            'title'          => __( 'More Customization Options', 'smallbiz' ),
            'description'    => 'For more Customization Options visit the SmallBiz Options Panel',
            'priority'       => 135,
        ) );   
        $wp_customize->add_setting( 'smallbiz_theme_options[more_options]', array(
            'default'        => '',
            'type'           => 'option',
            'capability'     => 'edit_theme_options',
        ) );
        
        $wp_customize->add_control( new e2w_Customize_Smallbiz_Control( $wp_customize, 'link_color', array(
            'label'      => __( '', 'themename' ),
            'section'    => 'smallbiz_section',
            'settings'   => 'smallbiz_theme_options[more_options]'
        ) ) );    
        
    }
    
 }
