<?php
class BookWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'mbt_bookwidget',
            __( 'Books', 'my-book-task' ),
            __( 'My Books Widget', 'my-book-task' )
        );
    }

    public function form( $instance ) {

        $title       = isset( $instance['title'] ) ? $instance['title'] : '';
        $taxonomy    = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        $post_number = isset( $instance['post_number'] ) ? $instance['post_number'] : '';

        ?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'my-book-task' );?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
        name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<?php
$taxonomies = get_categories( array(
            'taxonomy' => 'book_cat',
            'orderby'  => 'name',
            'order'    => 'ASC',

        ) );

        if ( $taxonomies ) {
            printf(
                '<p><label for="%1$s">%2$s</label>' .
                '<select class="widefat" id="%1$s" name="%3$s">',
                $this->get_field_id( 'taxonomy' ),
                __( 'Taxonomy:', 'my-book-task' ),
                $this->get_field_name( 'taxonomy' )
            );

            foreach ( $taxonomies as $value ) {

                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr( $value->slug ),
                    selected( $value->slug, $taxonomy, false ),
                    esc_html__( $value->name, 'my-book-task' )
                );

            }
            echo '</select></p>';
        } else {

            echo '<p><select class="widefat"><option>' . __( 'No Category Found', 'my-book-task' ) . '</option></select></p>';
        }

        ?>

<p>
    <label
        for="<?php echo $this->get_field_id( 'post_number' ); ?>"><?php esc_html_e( 'Number of Post:', 'my-book-task' );?></label>
    <input class="widefat" type="number" class="checkbox" id="<?php echo $this->get_field_id( 'post_number' ); ?>"
        name="<?php echo $this->get_field_name( 'post_number' ); ?>" value="<?php echo esc_attr( $post_number ); ?>" />

</p>
<?php
}

    public function widget( $args, $instance ) {

        $title = !empty( $instance['title'] ) ? $instance['title'] : __( 'Books', 'my-book-task' );
        echo $args['before_widget'];

        echo $args['before_title'];
        echo apply_filters( 'widget_title', $title );
        echo $args['after_title'];

        $this->mbt_widget_content( 'book', $instance );
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance                = $old_instance;
        $instance['title']       = sanitize_text_field( $new_instance['title'] );
        $instance['taxonomy']    = stripslashes( $new_instance['taxonomy'] );
        $instance['post_number'] = !empty( $new_instance['post_number'] ) ? $new_instance['post_number'] : false;

        return $instance;
    }

    public function mbt_widget_content( $post_type, $instance ) {
        global $post;
        add_image_size( 'book_widget_image', 85, 45, true );
        $cat_args = array(
            'post_type'      => $post_type,
            'posts_per_page' => $instance['post_number'],
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'book_cat',
                    'field'    => 'slug',
                    'terms'    => $instance['taxonomy'],

                ),

            ),

        );
        $cat_posts = new WP_Query( $cat_args );

        while ( $cat_posts->have_posts() ) {
            $cat_posts->the_post();
            $image = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail( $post->ID, 'book_widget_image' ) : '';
            ?>
<div class="sidebar-book">
    <div class="sidebar-book-image">
        <a href="<?php the_permalink();?>"><?php echo $image; ?></a>
    </div>
    <div class="sidebar-book-content">
        <h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
        <p><?php echo wp_trim_words( get_the_content(), 8 ); ?></p>
    </div>
</div>
<?php
}
        wp_reset_query();
    }

}

// Register Widget

function mbt_register_bookwidget() {
    register_widget( 'BookWidget' );
}
