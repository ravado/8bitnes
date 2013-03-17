<? get_header(); ?>
<div id="content">
    <? $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <section id="sidebar-left">
            <? get_sidebar(); ?>
        </section>
        <section id="main-content">
            <div class="alphabet-block white-block">
                <ul class="english-alphabet alphabet "  data-alphabet="en">
                    <li><a>#</a></li>
                    <li><a>a</a></li>
                    <li><a>b</a></li>
                    <li><a>c</a></li>
                    <li><a>d</a></li>
                    <li><a>e</a></li>
                    <li><a>f</a></li>
                    <li><a>g</a></li>
                    <li><a>h</a></li>
                    <li><a>i</a></li>
                    <li><a>j</a></li>
                    <li><a>k</a></li>
                    <li><a>l</a></li>
                    <li><a>m</a></li>
                    <li><a>n</a></li>
                    <li><a>o</a></li>
                    <li><a>p</a></li>
                    <li><a>r</a></li>
                    <li><a>s</a></li>
                    <li><a>t</a></li>
                    <li><a>u</a></li>
                    <li><a>v</a></li>
                    <li><a>w</a></li>
                    <li><a>x</a></li>
                    <li><a>y</a></li>
                    <li><a>z</a></li>
                    <li class="helper"></li>
                </ul>
                <ul class="russian-alphabet alphabet hidden" data-alphabet="ru">
                    <li><a>#</a></li>
                    <li><a>а</a></li>
                    <li><a>б</a></li>
                    <li><a>в</a></li>
                    <li><a>г</a></li>
                    <li><a>д</a></li>
                    <li><a>е</a></li>
                    <li><a>ж</a></li>
                    <li><a>з</a></li>
                    <li><a>и</a></li>
                    <li><a>й</a></li>
                    <li><a>к</a></li>
                    <li><a>л</a></li>
                    <li><a>м</a></li>
                    <li><a>н</a></li>
                    <li><a>о</a></li>
                    <li><a>п</a></li>
                    <li><a>р</a></li>
                    <li><a>с</a></li>
                    <li><a>т</a></li>
                    <li><a>у</a></li>
                    <li><a>ф</a></li>
                    <li><a>х</a></li>
                    <li><a>ц</a></li>
                    <li><a>ч</a></li>
                    <li><a>ш</a></li>
                    <li><a>щ</a></li>
                    <li><a>э</a></li>
                    <li><a>ю</a></li>
                    <li><a>я</a></li>
                    <li class="helper"></li>
                </ul>
                <div class="switch-alphabet">
                    <a class="switcher" data-switch-alphabet="ru">
                        <span class="lang-icon-ru disabled icon"></span>
                    </a>
                    <a class="switcher" data-switch-alphabet="en">
                        <span class="lang-icon-en icon"></span>
                    </a>
                </div>
                <div style="clear: both;"></div>
            </div>
            <!--<div class="alphabet-block white-block">
                # а б в г д е ж з и й к л м н о п р с т у ф х ц ч ш щ э ю я
            </div>-->

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