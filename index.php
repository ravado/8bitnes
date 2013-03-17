<? get_header(); ?>
<div id="content">
    <? $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
            <? get_sidebar(); ?>
        </section>
        <section id="main-content">
            <? get_template_part('alphabet') ?>
            <div class="random-games complete-block">
                <?
                $paged = get_query_var('paged');
                if(have_posts()):
                    ?>
                    <header class="blue-head-block">Все игры</header>
                    <div class="block-content">
                        <? query_posts('tag=dendy-games&paged='.$paged)?>
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
                                        <? if(has_post_format('image')): ?>
                                            <span class="item-rating-icon"></span>
                                            <span class="rating"><?=round($post->post_rating, 2)?></span>
                                        <? endif; ?>
                                    </span>
                                    <span class="item-more">
                                        <a href="<? the_permalink(); ?>" class="lnk-more">Подробнее</a>
                                    </span>
                                </footer>
                            </div>
                        <? endwhile; ?>
                        <div class="clear-both"></div>
                    </div>
                    <nav style="margin-top: 10px;">
                        <? if (function_exists('wp_corenavi')) wp_corenavi(); ?>
                    </nav>
                <?else:?>

                <header class="blue-head-block">Ошибка: страница не найдена</header>
                <div class="block-content">
                    <div class="not-found">
                        <h3>Страница не найдена (ошибка 404)</h3>
                        <p>Не волнуйтесь она не могла далеко уйти :)</p>
                        <p>Вы можете начать поиски с <a href="/">главной страницы</a>,
                        <p>либо воспользоваться нашей <a class="btn-action ">формой поиска</a></p>
                    </div>
                </div>
                <? endif; ?>
            </div>
        </section>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<? get_footer(); ?>