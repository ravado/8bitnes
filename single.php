<? get_header() ?>
<div id="content">
    <? $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
            <? get_sidebar(); ?>
        </section>
        <section id="main-content">
            <? if (have_posts()) : while (have_posts()) : the_post(); ?>
            <? increaseViews();
                if(get_post_format($post->ID) == 'image') {
                    get_template_part('game_review');
                } else {
                    get_template_part('default_post');
                }?>
                <input type="hidden" id="post_id" value="<?= get_the_ID() ?>">
            <? endwhile; ?>
            <? endif; ?>

            <div class="random-games complete-block">
                <div class="blue-head-block">Случайные игры</div>
                <div class="block-content">
                            <? $counter = 1; $arg = array(
                            'post_type'=> 'post',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'orderby' => 'rand',
                            'posts_per_page' => 4,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'post_format',
                                    'field' => 'slug',
                                    'terms' => array( 'post-format-image' )
                                )
                            ));?>
                            <? query_posts($arg); ?>
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
                                            <span class="item-more">
                                                <a href="<? the_permalink(); ?>" class="lnk-more">Подробнее</a>
                                            </span>
                                            <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <span class="rating"><?= $post->post_rating; ?></span>
                                            </span>
                                    </footer>
                                </div>
                            <? endwhile; ?>
                    <div class="clear-both"></div>
                </div>
            </div>
            <div class="comments complete-block">
                <div class="blue-head-block">Комментарии</div>
                <div class="block-content"  id="vk_comments">
                </div>
            </div>
            <div class="clear-both"></div>
        </section>
    </div>
    <div class="empty"></div>
</div>
<? get_footer() ?>