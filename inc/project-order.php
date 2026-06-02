<?php
declare( strict_types=1 );

/**
 * "Order Projects" admin page.
 *
 * A drag-and-drop screen under Projects that lets editors:
 *   - reorder the project categories (stored in the `_tbc_term_order` term meta)
 *   - reorder projects within each category (stored as each post's menu_order)
 *
 * The Gallery block reads both: tbc_project_category_terms() for the filter
 * buttons, and the menu_order query in blocks/gallery/render.php for the grid.
 */

const TBC_ORDER_PAGE_SLUG = 'tbc-order-projects';

/** Hook suffix of our screen, captured at registration for a reliable asset check. */
function tbc_order_page_hook( ?string $set = null ): string {
    static $hook = '';
    if ( null !== $set ) {
        $hook = $set;
    }
    return $hook;
}

/** Register the submenu page under the Projects CPT menu. */
add_action( 'admin_menu', static function (): void {
    $hook = add_submenu_page(
        'edit.php?post_type=tbc_project',
        __( 'Order Projects', 'tbone-construction' ),
        __( 'Order Projects', 'tbone-construction' ),
        'edit_posts',
        TBC_ORDER_PAGE_SLUG,
        'tbc_render_order_page'
    );
    tbc_order_page_hook( (string) $hook );
} );

/** Projects bucketed by their primary (first) category, each list in menu_order. */
function tbc_order_grouped_projects(): array {
    $cats = tbc_project_category_terms( false ); // include empty categories so they can be ordered

    $groups = [];
    foreach ( $cats as $term ) {
        $groups[ $term->term_id ] = [ 'term' => $term, 'projects' => [] ];
    }
    $groups[0] = [ 'term' => null, 'projects' => [] ]; // uncategorised bucket

    $projects = get_posts( [
        'post_type'      => 'tbc_project',
        'posts_per_page' => -1,
        'orderby'        => [ 'menu_order' => 'ASC', 'title' => 'ASC' ],
        'post_status'    => [ 'publish', 'draft', 'pending', 'future', 'private' ],
    ] );

    foreach ( $projects as $p ) {
        $terms   = get_the_terms( $p->ID, 'tbc_project_category' );
        $term_id = ( $terms && ! is_wp_error( $terms ) ) ? (int) $terms[0]->term_id : 0;
        if ( ! isset( $groups[ $term_id ] ) ) {
            $term_id = 0;
        }
        $groups[ $term_id ]['projects'][] = $p;
    }

    // Drop the uncategorised bucket if it's empty.
    if ( empty( $groups[0]['projects'] ) ) {
        unset( $groups[0] );
    }

    return $groups;
}

/** Render the drag-and-drop ordering screen. */
function tbc_render_order_page(): void {
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }
    $groups = tbc_order_grouped_projects();
    ?>
    <div class="wrap tbc-order">
        <h1><?php esc_html_e( 'Order Projects', 'tbone-construction' ); ?></h1>
        <p class="description"><?php esc_html_e( 'Drag (or use the up/down arrows) to reorder categories and the projects within them. Collapse a category with the caret. The Gallery follows this order.', 'tbone-construction' ); ?></p>

        <p>
            <button type="button" class="button button-primary" id="tbc-order-save"><?php esc_html_e( 'Save Order', 'tbone-construction' ); ?></button>
            <span class="tbc-order-status" id="tbc-order-status" aria-live="polite"></span>
        </p>

        <div id="tbc-order-cats">
            <?php foreach ( $groups as $term_id => $group ) :
                $name = $group['term'] ? $group['term']->name : __( 'Uncategorised', 'tbone-construction' );
                ?>
                <div class="tbc-order-cat" data-term-id="<?php echo (int) $term_id; ?>">
                    <div class="tbc-order-cat__head">
                        <button type="button" class="tbc-order-toggle" aria-expanded="true" title="<?php esc_attr_e( 'Collapse / expand', 'tbone-construction' ); ?>">
                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </button>
                        <span class="tbc-order-handle dashicons dashicons-move" title="<?php esc_attr_e( 'Drag to reorder category', 'tbone-construction' ); ?>"></span>
                        <strong class="tbc-order-cat__name"><?php echo esc_html( $name ); ?></strong>
                        <span class="tbc-order-cat__count"><?php echo (int) count( $group['projects'] ); ?></span>
                        <span class="tbc-order-moves">
                            <button type="button" class="button tbc-order-up" title="<?php esc_attr_e( 'Move category up', 'tbone-construction' ); ?>"><span class="dashicons dashicons-arrow-up-alt2"></span></button>
                            <button type="button" class="button tbc-order-down" title="<?php esc_attr_e( 'Move category down', 'tbone-construction' ); ?>"><span class="dashicons dashicons-arrow-down-alt2"></span></button>
                        </span>
                    </div>
                    <ul class="tbc-order-projects">
                        <?php foreach ( $group['projects'] as $p ) :
                            $thumb = get_the_post_thumbnail_url( $p->ID, 'thumbnail' );
                            if ( ! $thumb ) {
                                $thumb = (string) get_post_meta( $p->ID, '_tbc_remote_image_url', true );
                            }
                            ?>
                            <li class="tbc-order-project" data-post-id="<?php echo (int) $p->ID; ?>">
                                <span class="tbc-order-handle dashicons dashicons-menu-alt2"></span>
                                <?php if ( $thumb ) : ?>
                                    <img src="<?php echo esc_url( $thumb ); ?>" alt="" class="tbc-order-thumb" />
                                <?php else : ?>
                                    <span class="tbc-order-thumb tbc-order-thumb--empty dashicons dashicons-format-image"></span>
                                <?php endif; ?>
                                <span class="tbc-order-title"><?php echo esc_html( get_the_title( $p->ID ) ?: __( '(no title)', 'tbone-construction' ) ); ?></span>
                                <?php if ( 'publish' !== $p->post_status ) : ?>
                                    <span class="tbc-order-badge"><?php echo esc_html( $p->post_status ); ?></span>
                                <?php endif; ?>
                                <span class="tbc-order-moves">
                                    <button type="button" class="button tbc-order-up" title="<?php esc_attr_e( 'Move up', 'tbone-construction' ); ?>"><span class="dashicons dashicons-arrow-up-alt2"></span></button>
                                    <button type="button" class="button tbc-order-down" title="<?php esc_attr_e( 'Move down', 'tbone-construction' ); ?>"><span class="dashicons dashicons-arrow-down-alt2"></span></button>
                                </span>
                            </li>
                        <?php endforeach; ?>
                        <?php if ( ! $group['projects'] ) : ?>
                            <li class="tbc-order-empty"><?php esc_html_e( 'No projects in this category yet.', 'tbone-construction' ); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/** Enqueue jQuery UI Sortable + inline styles/script on our page only. */
add_action( 'admin_enqueue_scripts', static function ( string $hook ): void {
    if ( $hook !== tbc_order_page_hook() ) {
        return;
    }
    wp_enqueue_script( 'jquery-ui-sortable' );
    wp_enqueue_style( 'dashicons' );

    $css = '
        .tbc-order-cat{background:#fff;border:1px solid #dcdcde;margin:0 0 14px;border-radius:4px}
        .tbc-order-cat__head{display:flex;align-items:center;gap:8px;padding:10px 14px;background:#f6f7f7;border-bottom:1px solid #dcdcde;border-radius:4px 4px 0 0}
        .tbc-order-cat__name{font-size:14px;flex:1 1 auto}
        .tbc-order-cat__count{color:#646970;font-size:12px;background:#fff;border:1px solid #dcdcde;border-radius:10px;padding:1px 8px}
        .tbc-order-toggle{display:inline-flex;align-items:center;justify-content:center;background:none;border:0;padding:0;cursor:pointer;color:#646970}
        .tbc-order-toggle .dashicons{transition:transform .15s ease}
        .tbc-order-cat.is-collapsed .tbc-order-toggle .dashicons{transform:rotate(-90deg)}
        .tbc-order-cat.is-collapsed .tbc-order-projects{display:none}
        .tbc-order-cat.is-collapsed .tbc-order-cat__head{border-bottom:0;border-radius:4px}
        .tbc-order-projects{margin:0;padding:8px;min-height:38px;list-style:none}
        .tbc-order-project{display:flex;align-items:center;gap:10px;padding:8px 10px;border:1px solid #e0e0e0;border-radius:3px;background:#fff;margin:6px 0;cursor:default}
        .tbc-order-project:hover{border-color:#c3c4c7;background:#fafafa}
        .tbc-order-thumb{width:40px;height:40px;object-fit:cover;border-radius:3px;background:#f0f0f1;display:inline-flex;align-items:center;justify-content:center;color:#a7aaad;flex:0 0 auto}
        .tbc-order-thumb--empty:before{font-size:20px}
        .tbc-order-title{font-weight:600;flex:1 1 auto}
        .tbc-order-badge{text-transform:uppercase;font-size:10px;letter-spacing:.05em;color:#996800;background:#fcf3cd;border-radius:3px;padding:2px 6px}
        .tbc-order-handle{cursor:grab;color:#a7aaad}
        .tbc-order-handle:active{cursor:grabbing}
        .tbc-order-moves{display:inline-flex;gap:2px;flex:0 0 auto}
        .tbc-order-moves .button{min-height:26px;height:26px;padding:0 5px;display:inline-flex;align-items:center;justify-content:center}
        .tbc-order-moves .dashicons{font-size:16px;width:16px;height:16px;line-height:16px}
        .tbc-order-empty{color:#a7aaad;font-style:italic;padding:6px 10px;margin:0}
        .tbc-order-placeholder{border:1px dashed #c25e24;background:#fff7f0;border-radius:3px;margin:6px 0;height:58px;list-style:none}
        .tbc-order-status{margin-left:10px;font-weight:600}
        .tbc-order-status.is-ok{color:#007017}
        .tbc-order-status.is-err{color:#b32d2e}
    ';
    wp_add_inline_style( 'dashicons', $css );

    $js = "
    jQuery(function($){
        var \$cats = $('#tbc-order-cats');
        \$cats.sortable({
            items: '> .tbc-order-cat',
            handle: '.tbc-order-cat__head .tbc-order-handle',
            placeholder: 'tbc-order-placeholder',
            forcePlaceholderSize: true,
            axis: 'y',
            tolerance: 'pointer'
        });
        $('.tbc-order-projects').sortable({
            items: '> .tbc-order-project',
            handle: '.tbc-order-handle',
            placeholder: 'tbc-order-placeholder',
            forcePlaceholderSize: true,
            axis: 'y',
            tolerance: 'pointer'
        });

        // Collapse / expand categories, remembering state per category in localStorage.
        var STORE = 'tbcOrderCollapsed';
        function saveCollapsed(){
            var ids = [];
            \$cats.children('.tbc-order-cat.is-collapsed').each(function(){ ids.push(String($(this).data('term-id'))); });
            try { localStorage.setItem(STORE, JSON.stringify(ids)); } catch(e){}
        }
        (function restoreCollapsed(){
            var ids = [];
            try { ids = JSON.parse(localStorage.getItem(STORE) || '[]') || []; } catch(e){}
            \$cats.children('.tbc-order-cat').each(function(){
                if (ids.indexOf(String($(this).data('term-id'))) > -1) {
                    $(this).addClass('is-collapsed').find('.tbc-order-toggle').attr('aria-expanded', 'false');
                }
            });
        })();
        \$cats.on('click', '.tbc-order-toggle', function(){
            var \$cat = $(this).closest('.tbc-order-cat');
            var collapsed = \$cat.toggleClass('is-collapsed').hasClass('is-collapsed');
            $(this).attr('aria-expanded', collapsed ? 'false' : 'true');
            saveCollapsed();
        });

        // Up / down arrows for categories and for projects within a list.
        \$cats.on('click', '.tbc-order-cat__head > .tbc-order-moves .tbc-order-up', function(){
            var \$cat = $(this).closest('.tbc-order-cat'), \$prev = \$cat.prev('.tbc-order-cat');
            if (\$prev.length) \$cat.insertBefore(\$prev);
        });
        \$cats.on('click', '.tbc-order-cat__head > .tbc-order-moves .tbc-order-down', function(){
            var \$cat = $(this).closest('.tbc-order-cat'), \$next = \$cat.next('.tbc-order-cat');
            if (\$next.length) \$cat.insertAfter(\$next);
        });
        \$cats.on('click', '.tbc-order-project .tbc-order-up', function(){
            var \$li = $(this).closest('.tbc-order-project'), \$prev = \$li.prev('.tbc-order-project');
            if (\$prev.length) \$li.insertBefore(\$prev);
        });
        \$cats.on('click', '.tbc-order-project .tbc-order-down', function(){
            var \$li = $(this).closest('.tbc-order-project'), \$next = \$li.next('.tbc-order-project');
            if (\$next.length) \$li.insertAfter(\$next);
        });

        $('#tbc-order-save').on('click', function(){
            var \$btn = $(this), \$status = $('#tbc-order-status');
            var order = [];
            \$cats.children('.tbc-order-cat').each(function(){
                var posts = [];
                $(this).find('.tbc-order-project').each(function(){ posts.push($(this).data('post-id')); });
                order.push({ term_id: $(this).data('term-id'), posts: posts });
            });
            \$btn.prop('disabled', true);
            \$status.removeClass('is-ok is-err').text('Saving…');
            $.post(ajaxurl, {
                action: 'tbc_save_project_order',
                nonce: '" . esc_js( wp_create_nonce( 'tbc_order_projects' ) ) . "',
                order: JSON.stringify(order)
            }).done(function(res){
                if (res && res.success) { \$status.addClass('is-ok').text('Saved.'); }
                else { \$status.addClass('is-err').text((res && res.data) ? res.data : 'Save failed.'); }
            }).fail(function(){
                \$status.addClass('is-err').text('Save failed.');
            }).always(function(){
                \$btn.prop('disabled', false);
                setTimeout(function(){ \$status.text('').removeClass('is-ok is-err'); }, 4000);
            });
        });
    });
    ";
    wp_add_inline_script( 'jquery-ui-sortable', $js );
} );

/** Apply the manual order to the project archive + category archive front-end queries. */
add_action( 'pre_get_posts', static function ( WP_Query $q ): void {
    if ( is_admin() || ! $q->is_main_query() ) {
        return;
    }
    if ( $q->is_post_type_archive( 'tbc_project' ) || $q->is_tax( 'tbc_project_category' ) ) {
        $q->set( 'orderby', [ 'menu_order' => 'ASC', 'date' => 'DESC' ] );
    }
} );

/** AJAX: persist category order (term meta) + project order (menu_order). */
add_action( 'wp_ajax_tbc_save_project_order', static function (): void {
    if ( ! check_ajax_referer( 'tbc_order_projects', 'nonce', false ) || ! current_user_can( 'edit_posts' ) ) {
        wp_send_json_error( 'Permission denied.', 403 );
    }

    $raw = isset( $_POST['order'] ) ? wp_unslash( $_POST['order'] ) : '';
    $order = json_decode( (string) $raw, true );
    if ( ! is_array( $order ) ) {
        wp_send_json_error( 'Malformed payload.', 400 );
    }

    $cat_pos   = 0; // category display order
    $menu_pos  = 0; // global project order, walking categories top-to-bottom

    foreach ( $order as $group ) {
        $term_id = isset( $group['term_id'] ) ? (int) $group['term_id'] : 0;
        if ( $term_id > 0 && current_user_can( 'manage_categories' ) ) {
            update_term_meta( $term_id, '_tbc_term_order', $cat_pos );
        }
        $cat_pos++;

        $posts = isset( $group['posts'] ) && is_array( $group['posts'] ) ? $group['posts'] : [];
        foreach ( $posts as $pid ) {
            $pid = (int) $pid;
            if ( $pid > 0 && current_user_can( 'edit_post', $pid ) ) {
                wp_update_post( [ 'ID' => $pid, 'menu_order' => $menu_pos ] );
            }
            $menu_pos++;
        }
    }

    wp_send_json_success();
} );
