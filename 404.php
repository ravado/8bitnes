<?php get_header() ?>
<div id="content">
    <div id="fixed-content">
        <section id="sidebar-left">
            <?php get_sidebar(); ?>
        </section>
        <section id="main-content">
            <div class="error-404 complete-block">
                <div class="blue-head-block">Страница не найдена</div>
                <div class="block-content">
                    <div class="not-found">
                        <h3>Страница не найдена (ошибка 404)</h3>
                        <p>Не волнуйтесь она не могла далеко уйти :)</p>
                        <p>Вы можете начать поиски с <a href="/">главной страницы</a>,</p>
                        <p>либо воспользоваться нашей <a class="btn-action ">формой поиска</a></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="empty"></div>
</div>
<?php get_footer() ?>