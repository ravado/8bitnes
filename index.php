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
                    <li><a href="">#</a></li>
                    <li><a href="">a</a></li>
                    <li><a href="">b</a></li>
                    <li><a href="">c</a></li>
                    <li><a href="">d</a></li>
                    <li><a href="">e</a></li>
                    <li><a href="">f</a></li>
                    <li><a href="">g</a></li>
                    <li><a href="">h</a></li>
                    <li><a href="">i</a></li>
                    <li><a href="">j</a></li>
                    <li><a href="">k</a></li>
                    <li><a href="">l</a></li>
                    <li><a href="">m</a></li>
                    <li><a href="">n</a></li>
                    <li><a href="">o</a></li>
                    <li><a href="">p</a></li>
                    <li><a href="">r</a></li>
                    <li><a href="">s</a></li>
                    <li><a href="">t</a></li>
                    <li><a href="">u</a></li>
                    <li><a href="">v</a></li>
                    <li><a href="">w</a></li>
                    <li><a href="">x</a></li>
                    <li><a href="">y</a></li>
                    <li><a href="">z</a></li>
                    <li class="helper"></li>
                </ul>
                <ul class="russian-alphabet alphabet hidden" data-alphabet="ru">
                    <li><a href="">#</a></li>
                    <li><a href="">а</a></li>
                    <li><a href="">б</a></li>
                    <li><a href="">в</a></li>
                    <li><a href="">г</a></li>
                    <li><a href="">д</a></li>
                    <li><a href="">е</a></li>
                    <li><a href="">ж</a></li>
                    <li><a href="">з</a></li>
                    <li><a href="">и</a></li>
                    <li><a href="">й</a></li>
                    <li><a href="">к</a></li>
                    <li><a href="">л</a></li>
                    <li><a href="">м</a></li>
                    <li><a href="">н</a></li>
                    <li><a href="">о</a></li>
                    <li><a href="">п</a></li>
                    <li><a href="">р</a></li>
                    <li><a href="">с</a></li>
                    <li><a href="">т</a></li>
                    <li><a href="">у</a></li>
                    <li><a href="">ф</a></li>
                    <li><a href="">х</a></li>
                    <li><a href="">ц</a></li>
                    <li><a href="">ч</a></li>
                    <li><a href="">ш</a></li>
                    <li><a href="">щ</a></li>
                    <li><a href="">э</a></li>
                    <li><a href="">ю</a></li>
                    <li><a href="">я</a></li>
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