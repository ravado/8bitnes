<? /* Template Name: Main Page */ ?> <? get_header(); ?>
<div id="content"
     xmlns="http://www.w3.org/1999/html">     <? $theme_dir =
    get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left"><? get_sidebar(); ?></section>
        <section id="main-content">
            <div id="container">
                <div id="example">
                    <div id="slides">
                        <div class="slide-border">
                            <div
                                    class="slides_container">                                 <? foreach
                            (getTopGames(10) as $top_game):?>
                                <div
                                        class="slide"><a href="<? echo
                                get_permalink($top_game->ID); ?>" title="<? echo $top_game->post_title; ?>">
                                    <img src="<? contentPart('url', $top_game->post_content) ?>" width="700"
                                         height="380" alt="<? contentPart('alt', $top_game->post_content); ?>">
                                </a>

                                    <div class="caption">
                                        <a href="<?= get_permalink($top_game->ID); ?>">
                                            <p><? $title = explode("/", $top_game->post_title); echo $title[0]; ?></p>
                                        </a></div>
                                </div>                                 <? endforeach;?>
                            </div>
                        </div>
                        <a href="#"
                           class="prev"></a> <a href="#" class="next"></a>
                    </div>
                </div>
            </div>
            <!--end slider-->

            <div class="popular-games complete-block">
                <header class="blue-head-block">Популярные игры</header>
                <div class="block-content">
                    <? foreach (getPopularGames(8) as $popular_game): ?>
                    <div class="game-item">
                        <header class="head-orange">
                            <h3>
                                <a href="<? echo get_permalink($popular_game->ID); ?>"><? $title = explode("/", $popular_game->post_title); echo $title[0];?></a>
                            </h3>
                        </header>
                        <div class="item-content">
                            <div class="item-image">
                                <a href="<?=get_permalink($popular_game->ID); ?>">
                                    <img src="<? contentPart('url', $popular_game->post_content); ?>"
                                         alt="<? contentPart('alt', $popular_game->post_content); ?>" width="176"
                                         height="120">
                                </a>
                            </div>
                            <div class="item-decription">
                                <p><? contentPart('rev', $popular_game->post_content); ?></p>
                            </div>
                        </div>
                        <footer class="item-info">
                                <span class="item-rating">
                                    <span class="item-rating-icon"></span>
                                    <span class="rating"><?=round($popular_game->post_rating, 2)?></span>
                                </span>
                                <span class="item-more">
                                    <a href="<?=get_permalink($popular_game->ID); ?>" class="lnk-more">Подробнее</a>
                                </span>

                            <div class="clear-both"></div>
                        </footer>
                    </div>
                    <? endforeach; ?>
                    <div class="clear-both"></div>
                </div>
            </div>

            <div class="random-games complete-block" style="margin-bottom: 10px !important;">
                <div class="blue-head-block">Случайные игры</div>
                <div class="block-content">
                    <?
                    $arg = array(
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'order' => 'DESC',
                        'orderby' => 'rand',
                        'posts_per_page' => 8,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'post_format',
                                'field' => 'slug',
                                'terms' => array('post-format-image')
                            )))
                    ?>
                    <? query_posts($arg); ?>
                    <? while (have_posts()) : the_post(); ?>
                    <div class="game-item">
                        <header class="head-orange">
                            <h3>
                                <a href="<? the_permalink(); ?>"><?$title = explode("/", get_the_title()); echo $title[0]; ?></a>
                            </h3>
                        </header>
                        <div class="item-content">
                            <div class="item-image">
                                <a href="<? the_permalink(); ?>">
                                    <img src="<? contentPart('url'); ?>" alt="<? contentPart('alt'); ?>" width="176"
                                         height="120">
                                </a>
                            </div>
                            <div class="item-decription"><p><? contentPart('rev'); ?></p></div>
                        </div>
                        <footer class="item-info">
                                <span class="item-rating">
                                    <span class="item-rating-icon"></span>
                                    <span class="rating"><?=round($post->post_rating, 2)?></span>
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
            <div>
                <a href="/all" class="btn-all-games">Все игры</a>

                <div class="clear-both"></div>
            </div>
            <div class="complete-block useful">
                <header class="blue-head-block">Это может быть полезно</header>
                <div class="block-content ">
                    <div class="useful-item">
                        <div class="useful-icon"><img src="<?=$theme_dir?>/img/ask2.png" alt=""></div>
                        <div class="useful-descr">
                            <h5><a href="http://www.emulroom.com/how-to-play/">Как играть?</a></h5>

                            <p>Статья для тех, кто хочет сыграть в старые добрые <strong>Денди игры</strong>, но еще не
                                знает, как это сделать. В статье есть подробное описание основных необходимых действий,
                                чтобы начать игру. </p>
                        </div>
                    </div>
                    <div class="useful-item">
                        <div class="useful-icon"><img src="<?=$theme_dir?>/img/emul3.png" alt=""></div>
                        <div class="useful-descr">
                            <h5><a href="http://www.emulroom.com/category/emulators/">Эмуляторы для Денди</a></h5>

                            <p>Без <strong>эмулятора</strong> сыграть на компьютере в старые игры
                                (<strong>Денди</strong>, <strong>Сега</strong> и т.д.) едва получится, поэтому перед тем
                                как играть, обзаведитесь необходимым эмулятором.</p>
                        </div>
                    </div>
                    <div class="useful-item">
                        <div class="useful-icon"><img src="<?=$theme_dir?>/img/lan2.png" alt=""></div>
                        <div class="useful-descr">
                            <h5><a href="http://www.emulroom.com/lan-play/">Настройка игры по локальной сети</a></h5>

                            <p>Часто игра в одиночку очень быстро надоедает. Что же делать? Есть выход. Можно
                                <strong>настроить сетевую игру</strong> между двумя, тремя или большим количеством
                                компьютеров, и сыграть в старые, добрые <strong>денди игры</strong>.</p>
                        </div>
                    </div>
                    <div class="useful-item">
                        <div class="useful-icon"><img src="<?=$theme_dir?>/img/web2.png" alt=""></div>
                        <div class="useful-descr">
                            <h5>
                                <a href="http://www.emulroom.com/emulators/dendy-emulators/nestopia-dendy-emulators/nestopia-online/">Настройка
                                    игры по сети Интернет</a></h5>

                            <p>Хочется сыграть в Денди с живым человеком, а не компьютером, но все ваши друзья заняты? А
                                вам играть ой как охота? Тогда можно поискать игроков на уже созданных игровых
                                серверах.</p>
                        </div>
                    </div>
                    <div class="clear-both"></div>
                </div>
            </div>
            <div class="site-review">

            </div>
        </section>
        <div class="clear-both"></div>
    </div>

    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<? get_footer(); ?>