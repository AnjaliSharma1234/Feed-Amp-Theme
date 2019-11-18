<?php
function twimcast_carousel()
{
    register_widget('twimcast_carousel_widget');
}
add_action('widgets_init', 'twimcast_carousel');

// Creating the widget 
class twimcast_carousel_widget extends WP_Widget
{

    function __construct()
    {
        parent::__construct(

            // Base ID of your widget
            'twimcast_carousel',

            // Widget name will appear in UI
            __('Carousel Widget', 'twimcast_carousel_widget_domain'),

            // Widget description
            array('description' => __('A carousel widget', 'twimcast_carousel_widget_domain'),)
        );
    }

    // Creating widget front-end

    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title))
            $posts = get_posts(array('post_type' => 'post'));
        foreach ($posts as $val) {
            echo $val->post_content;
        }
    }

    // Widget Backend 
    public function form($instance)
    {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __('New title', 'twimcast_carousel_widget_domain');
        }

        if (isset($instance['posts'])) {
            $title = $instance['name'];
        } else {
            $title = __('Enter name', 'twimcast_carousel_widget_domain');
        }
        // Widget admin form
        $args = array('post_type' => 'post');
        $posts = get_posts($args);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label>Select posts</label>

            <Select data-placeholder="select posts for carousel.." name='posts' id="form_id" multiple class="chosen-select">
                <option value=""></option>
                <?php foreach ($posts as $val) {
                            ?>
                    <option value="<?php echo $val->ID ?>"><?php echo $val->post_title ?></option>
                <?php
                        } ?>
            </Select>
            <script type="text/javascript">
                $(".chosen-select").chosen({
                    no_results_text: "Oops, nothing found!"
                })
            </script>
        </p>

<?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class twimcast_carousel_widget ends here
