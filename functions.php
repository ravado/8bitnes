<?php

    // Добавляем в тему поддержку форматов записей
    add_theme_support( 'post-formats', array( 'image' ) );

    // Добавление екшенов для работы аякс запроса
    add_action('wp_ajax_change_rating', 'change_post_rating');
    add_action('wp_ajax_nopriv_change_rating', 'change_post_rating');

    // Изменение рейтинга записи
    function change_post_rating() {
        $post_id = $_POST['post_id'];
        $new_mark = $_POST['mark'];
        global $wpdb;
        $newtable = $wpdb->get_results( "SELECT post_rating, votes_count FROM $wpdb->posts WHERE ID=".$post_id);
        $rating = $newtable[0]->post_rating;
        $votes_count = $newtable[0]->votes_count;
        $new_rating = round(($votes_count * $rating + $new_mark) / ($votes_count + 1), 3);
        $wpdb->query("UPDATE $wpdb->posts SET post_rating = " .$new_rating ." , votes_count = " .($votes_count + 1) ." WHERE ID =".$post_id);
        $temp['rating'] = round($new_rating,1);
        $temp['votes_count'] = $votes_count;
        echo json_encode($temp);
        die();
    }

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
    function contentPart($kind, $content = 'none') {
        global $post;
        if($content != 'none') {
            $post_content = $content;
        } else {
            $post_content = $post->post_content;
        }

        $img = '';
        $theme_url = get_bloginfo('template_directory');
        if($kind == 'url') {
            preg_match('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $url);
            $img = $url[1];
            if(empty($img)) {
                $img = $theme_url ."/img/img-not-found.jpeg";
            }
        } elseif ($kind == 'alt') {
            preg_match('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $alt);
            $img = $alt[1];
            if(empty($img)) {
                $img = 'game slide';
            }
        } elseif ($kind == 'rev') {
            preg_match('|<div class="gameReview">(.*)</div>|isU', $post_content, $reviews);
            $img = strip_tags(mb_substr($reviews[1],0,100)).'...';
            if(empty($img)) {
                $img = 'Нет описания :(';
            }
        }
        echo $img;
    }

    // Получение всех найденных в посте изображений, их ссылок и альтов
    function getPostImages() {
        global $post;
        $temp = array();
        $img_data = array();
        preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $images, PREG_SET_ORDER);
        if(empty($images)) {
            $img['url'] = false;
        } else {
            foreach($images as $img) {
                $img_data['url'] = $img[1];
                preg_match('/alt=[\'"]([^\'"]+)[\'"].*/i', $img[0], $alt);
                $img_data['alt'] = $alt[1];
                array_push($temp,$img_data);
            }
        }
        return $temp;
    }

    // Вывод поста без изображений
    function postWithoutImages() {
        global $post;
        $content = preg_replace("/<img[^>]+\>/i", "", $post->post_content);
        echo $content;
    }


    // Получение рейтинга поста по его  ID
    function getPostRating() {
        global $wpdb;
        $newtable = $wpdb->get_results( "SELECT post_rating FROM $wpdb->posts WHERE ID=".get_the_ID());
        $rating = round($newtable[0]->post_rating,1);
        return $rating;
    }

    // Выборка игр с самым большим рейтингом
    function getTopGames($count) {
        global $wpdb;
        $top_games = $wpdb->get_results("SELECT wp_posts.ID,
                    wp_posts.post_author,
                    wp_posts.post_content,
                    wp_posts.post_title,
                    wp_posts.post_status,
                    wp_posts.post_name,
                    wp_posts.post_type,
                    wp_posts.post_rating,
                    wp_posts.votes_count,
                    wp_posts.post_views,
                    wp_terms.name
                FROM wp_posts INNER JOIN wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id
                     INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                     INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
                WHERE wp_posts.post_status = 'publish' and wp_posts.post_type='post' AND wp_terms.name='post-format-image'
                ORDER BY wp_posts.post_rating DESC
                LIMIT ".$count);
        return $top_games;
    }

    // Выборка пяти игр с самым большим рейтингом
    function getPopularGames($count) {
        global $wpdb;
        $popular_games = $wpdb->get_results("SELECT wp_posts.ID,
                    wp_posts.post_author,
                    wp_posts.post_content,
                    wp_posts.post_title,
                    wp_posts.post_status,
                    wp_posts.post_name,
                    wp_posts.post_type,
                    wp_posts.post_rating,
                    wp_posts.votes_count,
                    wp_posts.post_views,
                    wp_terms.name
                FROM wp_posts INNER JOIN wp_term_relationships ON wp_posts.ID = wp_term_relationships.object_id
                     INNER JOIN wp_term_taxonomy ON wp_term_relationships.term_taxonomy_id = wp_term_taxonomy.term_taxonomy_id
                     INNER JOIN wp_terms ON wp_term_taxonomy.term_id = wp_terms.term_id
                WHERE wp_posts.post_status = 'publish' and wp_posts.post_type='post' AND wp_terms.name='post-format-image'
                ORDER BY wp_posts.post_views DESC
                LIMIT ".$count);
        return $popular_games;
    }

    // Увеличение количества просмотров поста
    function increaseViews() {
        global $post, $wpdb;
        $wpdb->query(
            "UPDATE $wpdb->posts
                SET post_views=post_views+1
                WHERE ID = ".$post->ID);
    }


function wp_corenavi() {
    global $wp_query, $wp_rewrite;
    $max = $wp_query->max_num_pages;
    if (!$current = get_query_var('paged')) $current = 1;
    $a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    $a['total'] = $max;
    $a['current'] = $current;

    $total = 1; //1 - выводить текст "Страница N из N", 0 - не выводить
    $a['mid_size'] = 3; //сколько ссылок показывать слева и справа от текущей
    $a['end_size'] = 1; //сколько ссылок показывать в начале и в конце
    $a['prev_text'] = '&laquo;'; //текст ссылки "Предыдущая страница"
    $a['next_text'] = '&raquo;'; //текст ссылки "Следующая страница"

    if ($max > 1) echo '<div class="navigation"><ul>';


    echo '<li>' . paginate_links($a) .'</li>';
    if ($max > 1) echo '</ul></div>';
}

?>