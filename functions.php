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

    // Вывод информации о первой картинке найденной в посте
    // $kind = 'url' - ссылка на изображение, 'alt' - ее альтернативная подпись
    function contentPart($kind) {
        global $post;
        $img = '';
        $theme_url = get_bloginfo('template_directory');
        if($kind == 'url') {
            preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $url);
            $img = $url[1];
            if(empty($img)) {
                $img = $theme_url ."/img/img-not-found.jpeg";
            }
        } elseif ($kind == 'alt') {
            preg_match('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $alt);
            $img = $alt[1];
            if(empty($img)) {
                $img = 'game slide';
            }
        } elseif ('rev') {
            preg_match('|<div class="gameReview">(.*)</div>|isU', $post->post_content, $reviews);
            $img = strip_tags(mb_substr($reviews[1],0,100)).'...';
            if(empty($img)) {
                $img = 'Нет описания :(';
            }
        }
        echo $img;
    }


?>