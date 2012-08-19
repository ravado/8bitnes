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
    <div id="fixed-content">
        <section id="sidebar-left">
            <?php get_sidebar(); ?>
        </section>
        <section id="main-content">
            <input type="hidden" id="search-query" value="<?php echo $_POST['s']; ?>">
            <div class="random-games complete-block">
                <div class="blue-head-block">Поиск</div>
                <div class="block-content" id="search-box"></div>
                <img class="pull-right" style="margin-top: 5px;" src="<?= get_template_directory_uri()?>/img/google.gif" alt="google logo">
            </div>
        </section>
    </div>
    <div class="empty"></div>
    <div class="clear-both"></div>
</div>
<?php get_footer() ?>