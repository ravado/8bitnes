<?php get_header() ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">


            <div class="error-404 complete-block">
                <div class="blue-head-block">Страница не найдена</div>
                <div class="block-content">
                    <div class="not-found">
                        <h3>Страница не найдена (ошибка 404)</h3>
                        <p>Не волнуйтесь она не могла далеко уйти :)</p>
                        <p>Вы можете начать поиски с <a href="/">главной страницы</a>,
                        <p>либо воспользоваться нашей <a class="btn-action ">формой поиска</a><!-- для того что бы найти пропажу--></p></div>
                </div>
            </div>

            <div class="clear-both"></div>
        </div>
        <div class="clear-both"></div>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<?php get_footer() ?>