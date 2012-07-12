<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 12.07.12
 * Time: 18:19
 * To change this template use File | Settings | File Templates.
 */
?>


<?php get_header() ?>
<div id="content">
    <?php $theme_dir = get_template_directory_uri();?>
    <div id="fixed-content">
        <?php get_sidebar(); ?>
        <div id="main-content">
            <input type="hidden" id="search-query" value="<?php echo $_GET['s']; ?>">
            <div class="random-games complete-block">
                <div class="blue-head-block">Поиск</div>
                <div class="block-content" id="search-box">

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