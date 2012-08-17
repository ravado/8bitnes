<?
/*
Template Name: Main Page
*/
?>
<? get_header(); ?>
<div id="content">
    <? $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
        <? get_sidebar(); ?>
        </section>
        <section id="main-content">
            <? if (is_home()){ get_template_part('main_page');} else { ?>

            <div id="container">
                <div id="example">
                    <div id="slides">
                        <div class="slide-border">
                            <div class="slides_container">
                                <? foreach (getTopGames(5) as $top_game ):?>
                                <div class="slide">
                                    <a href="<? echo get_permalink($top_game->ID); ?>" title="<? echo $top_game->post_title; ?>" >
                                        <img src="<? contentPart('url',$top_game->post_content) ?>" width="700" height="380" alt="<? contentPart('alt',$top_game->post_content); ?>">
                                    </a>
                                    <div class="caption">
                                        <a href="<? echo get_permalink($top_game->ID); ?>">
                                            <p><? echo $top_game->post_title; ?></p>
                                        </a>
                                    </div>
                                </div>
                                <? endforeach;?>
                            </div>
                        </div>
                        <a href="#" class="prev"></a>
                        <a href="#" class="next"></a>
                    </div>
                </div>
            </div><!--end slider-->



            <div class="popular-games complete-block">
                <header class="blue-head-block">Популярные игры</header>
                <div class="block-content">
                            <? foreach(getPopularGames(8) as $popular_game): ?>
                                <div class="game-item">

                                    <header class="head-orange">
                                        <h3>
                                            <a href="<? echo get_permalink($popular_game->ID); ?>"><? echo $popular_game->post_title; ?></a>
                                        </h3>
                                    </header>
                                    <div class="item-content">
                                        <div class="item-image">
                                            <a href="<?=get_permalink($popular_game->ID); ?>">
                                                <img src="<? contentPart('url',$popular_game->post_content); ?>" alt="<? contentPart('alt',$popular_game->post_content); ?>" width="176" height="120">
                                            </a>
                                        </div>
                                        <div class="item-decription">
                                            <p>
                                                <? contentPart('rev',$popular_game->post_content); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <footer class="item-info">
                                        <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <span class="rating"><? echo $popular_game->post_rating ?></span>
                                        </span>
                                        <span class="item-more">
                                            <a href="<?=get_permalink($popular_game->ID); ?>" class="lnk-more">Подробнее</a>
                                        </span>
                                        <div style="clear: both;"></div>
                                    </footer>
                                </div>
                            <? endforeach; ?>
                    <div class="clear-both"></div>
                </div>
            </div>



            <div class="random-games complete-block">
                <div class="blue-head-block">Случайные игры</div>
                <div class="block-content">

                            <? $counter = 1;
                            $arg = array(
                                'post_type'=> 'post',
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'orderby' => 'rand',
                                'posts_per_page' => 8,
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
                                        <div class="item-decription"><p><? contentPart('rev'); ?></p></div>
                                    </div>
                                    <footer class="item-info">
                                            <span class="item-rating">
                                                <span class="item-rating-icon"></span>
                                                <span class="rating"><? echo $post->post_rating; ?></span>
                                            </span>
                                            <span class="item-more">
                                                <a class="lnk-more" href="<? the_permalink(); ?>">Подробнее</a>
                                            </span>
                                        <div class="clear-both"></div>
                                    </footer>
                                </div>
                            <? endwhile; ?>
                    <div class="clear-both"></div>
                </div>
            </div>
            <div class="">
                <a href="/all" class="btn-all-games">Все игры</a>
            </div>

            <div class="clear-both"></div>
            <? }; ?>
        </section>
        <div class="clear-both"></div>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<? get_footer(); ?>