<? get_header() ?>
<div id="content">
    <? $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
            <? get_sidebar(); ?>
        </section>
        <section id="main-content">
            <div class="random-games complete-block">
                <div class="blue-head-block">
                    <?php if ( is_day() ) : ?>
                    <?php printf( __( 'Daily Archives: %s', 'twentyeleven' ), '<span>' . get_the_date() . '</span>' ); ?>
                    <?php elseif ( is_month() ) : ?>
                    <?php printf( __( 'Monthly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
                    <?php elseif ( is_year() ) : ?>
                    <?php printf( __( 'Yearly Archives: %s', 'twentyeleven' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'twentyeleven' ) ) . '</span>' ); ?>
                    <? elseif (is_category()): single_cat_title();?>
                    <? elseif(is_tag()): single_tag_title();?>
                    <? else: echo 'Архив';?>
                    <? endif; ?>
                </div>
                <div class="block-content">
                            <? while (have_posts()) : the_post(); ?>
                                <div class="game-item">
                                    <header class="head-orange">
                                        <h3><a href="<? the_permalink(); ?>"><? the_title(); ?></a></h3>
                                    </header>
                                    <div class="item-content">
                                        <div class="item-image">
                                            <a href="<? the_permalink(); ?>">
                                                <img src="<? contentPart('url'); ?>" alt="<? contentPart('alt'); ?>" width="176" height="120">
                                            </a>
                                        </div>
                                        <div class="item-decription">
                                            <p><? contentPart('rev'); ?></p>
                                        </div>                                        
                                    </div>
                                    <footer class="item-info">
                                            <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <span class="rating"><?= $post->post_rating; ?></span>
                                            </span>
                                            <span class="item-more">
                                                <a href="<? the_permalink(); ?>">Подробнее</a>
                                            </span>
                                    </footer>
                                </div>
                            <? endwhile; ?>
                    <div class="clear-both"></div>
                </div>
            </div>

            <? if (function_exists('wp_corenavi')) wp_corenavi(); ?>
            <div class="clear-both"></div>
            <div class="site-review">
                <p>
                    <?php echo category_description(); ?>
                </p>
            </div>
        </section>
        <div class="clear-both"></div>

    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<? get_footer() ?>