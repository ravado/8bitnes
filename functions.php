<?php

    // Переопределение вывода главного меню
    class mainMenuWalker extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\"><div class='menu-triangle'></div><div class='submenu-content'>\n";
        }
        function end_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</div></ul>\n";
        }
    }

    add_action('init', 'register_nav_menus_on_init');

    // Регистрируем наше главное меню
    function register_nav_menus_on_init() {
        register_nav_menus(array(
            'top' => 'Top Menu',
        ));
    }

    // Регистрируем наш сайдбар для возможности добавления виджетов из админки
    if ( function_exists ('register_sidebar') ) {
        register_sidebar (array (
            'name' => 'Левая боковая колонка',
            'before_widget' => '<div class="complete-block">',
            'after_widget' => '</ul></div></div>',
            'before_title' => '<div class="blue-head-block">',
            'after_title' => '</div><div class="block-content"><ul class="sidebar-menu">',
        ));
    }

    // Выбираем из поста первое изображение
    function catch_that_image() {
        global $post, $posts;
        $first_img = '';
        ob_start();
        ob_end_clean();
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $first_img = $matches [1] [0];
        if(empty($first_img)) {
            $first_img = "/images/default.jpg"; // Ссылка на изображение-заглушку, если в посте оно не найдено
        }
        return $first_img;
    }

    // Выбираем топ игр (заголовок, ссылку, первую картинку в посте)
    function getTopGames($count) {
        global $post;
        $theme_url = get_bloginfo('template_directory');
        /*$top_games = array();

        $top_posts = get_posts('numberposts=' .$count .' & orderby=rand');

        foreach($top_posts as $post) {
            $temp = array();
            $temp['permalink'] = get_post_permalink($post->ID);
            $temp['title'] = $post->post_title;
            preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
            $temp['img_url'] = $matches[1];
            if(empty($temp['img_url'])) {
                $temp['img_url'] = $theme_url ."/img/img-not-found.jpeg";
            }
            array_push($top_games, $temp);
        }*/
        preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        $img_url = $matches[1];
        if(empty($img_url)) {
            $img_url = $theme_url ."/img/img-not-found.jpeg";
        }
        return $img_url;
    }

    // Выбираем игры для превьюшек (картинка, краткое описание, заголовок, категория, рейтинг)
    // $count - количество необходимых записей
    // $kind  - по каким параметрам искать ('random','popular')
    function getPopularGames($kind, $count) {

        $popular_games = array();
        $theme_url = get_bloginfo('template_directory');
        $popular_posts = get_posts('numberposts=' .$count .' & orderby=rand');
        foreach($popular_posts as $post) {
            $temp = array();
            $post_categories = get_the_category($post->ID);
            $temp['cat_lnk'] = get_category_link($post_categories[0]->cat_ID);
            $temp['cat_name'] = $post_categories[0]->cat_name;
            $temp['permalink'] = get_post_permalink($post->ID);
            $temp['title'] = $post->post_title;
            preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $images);
            $temp['img_url'] = $images[1];
            if(empty($temp['img_url'])) {
                $temp['img_url'] = $theme_url ."/img/img-not-found.jpeg";
            }
            preg_match('|<div class="gameReview">(.*)</div>|isU', $post->post_content, $reviews);
            $temp['review'] = strip_tags(mb_substr($reviews[1],0,100)).'...';

            array_push($popular_games, $temp);
        }

        return $popular_games;
    }
?>