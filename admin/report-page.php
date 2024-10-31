<div class="stats_range">
        <?php
    $types = array(
        'cart' => __('Abandoned Carts', 'recover-woocommerce-abandoned-cart'),
        'product' => __('Abandoned Products', 'recover-woocommerce-abandoned-cart'),
    );
    $current_type = ! empty( $_GET['type'] ) ? sanitize_text_field( wp_unslash( $_GET['type'] ) ) : 'cart';
    ?>
    <ul class="nav nav-tabs">
        <?php
        foreach ($types as $type => $name) {
            echo '<li class=" nav-item"><a class="nav-link  ' . ( $current_type == $type ? 'active' : '' ) . '" href="' . esc_url(remove_query_arg(array('start_date', 'end_date'), add_query_arg('type', $type))) . '">' . esc_html($name) . '</a></li>';
        }
        ?>
    </ul>
    <p></p>
    <?php
    $ranges = array(
        'today' => __('Today', 'recover-woocommerce-abandoned-cart'),
        'week' => __('Last Week', 'recover-woocommerce-abandoned-cart'),
        'month' => __('Last Month', 'recover-woocommerce-abandoned-cart'),
    );
    
    
    $current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( wp_unslash( $_GET['range'] ) ) : 'today';

    if ( ! in_array( $current_range, array( 'today', 'week', 'month',) ) ) {
            $current_range = 'today';
    }
    
    
    ?>
    <ul class="nav nav-tabs">
        <?php
        foreach ($ranges as $range => $name) {
            echo '<li class=" nav-item"><a class="nav-link  ' . ( $current_range == $range ? 'active' : '' ) . '" href="' . esc_url(remove_query_arg(array('start_date', 'end_date'), add_query_arg('range', $range))) . '">' . esc_html($name) . '</a></li>';
        }
        ?>
    </ul>
</div>