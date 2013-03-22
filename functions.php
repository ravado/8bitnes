<?php

    // Добавляем в тему поддержку форматов записей
    add_theme_support( 'post-formats', array( 'image', 'games' ) );

    // Добавление екшенов для работы аякс запроса
    add_action('wp_ajax_change_rating', 'change_post_rating'); // только для залогиненых пользователей
    add_action('wp_ajax_nopriv_change_rating', 'change_post_rating'); // если не важно залогинен пользователь или нет
    // Изменение результатов голосования администратором
    add_action('wp_ajax_change_voting_result', 'change_voting_result');

    // Изменение рейтинга записи пользователем
    // Формула расчета: (количество голосов * оценка в базе + новая оценка) / (всего голосов + новый голос)
    function change_post_rating() {
        $post_id = $_POST['post_id'];
        $new_mark = $_POST['mark'];
        global $wpdb;
        $post_record = $wpdb->get_results( "SELECT post_rating, votes_count FROM $wpdb->posts WHERE ID=".$post_id);
        $rating = $post_record[0]->post_rating;
        $votes_count = $post_record[0]->votes_count;;
        $new_rating = round(($votes_count * $rating + $new_mark) / ($votes_count + 1), 5);
        $wpdb->query("UPDATE $wpdb->posts SET post_rating = " .$new_rating ." , votes_count = " .($votes_count + 1) ." WHERE ID =".$post_id);
        $data['rating'] = round($new_rating,2);
        $data['votes_count'] = $votes_count + 1;
        echo json_encode($data);
        die();
    }

    // Изменяем результаты голосования (и количество проголосовавших и оценку итоговую) админом
    function change_voting_result() {
        $post_id = $_POST['post_id'];
        $rating_fractional_part = rand(10,100)/100;
        $votes_count_fractional_part = rand(0,100);
        $new_rating = (int)$_POST['rating'] + $rating_fractional_part;
        $new_votes_count = (int)$_POST['votes_count'] + $votes_count_fractional_part;
        global $wpdb;
        $wpdb->query("UPDATE $wpdb->posts SET post_rating = " .$new_rating ." , votes_count = " .$new_votes_count ." WHERE ID =".$post_id);
        echo json_encode(array(
            "status" => "ok",
            "new_rating" => $new_rating,
            "new_votes_count" => $new_votes_count
        ));
        die();
    }

    // Переопределение вывода главного меню
    class mainMenuWalker extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n$indent<ul class=\"sub-menu\"><div class='menu-triangle'></div><div class='white-block submenu-content'>\n";
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
            'after_widget' => '</nav></div></div>',
            'before_title' => '<header class="blue-head-block">',
            'after_title' => '</header><div class="block-content "><nav class="sidebar-menu">',
        ));
    }

    // Проверка существует ли файл по заданому URL (довольно длиельная операция)
    function isUrlFileExist($url) {
        $handle = @fopen($url,'r');
        if($handle !== false) {
            return true;
        }
        else {
            return false;
        }
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
            // Указываем путь к уменьшеной копии картинки
            $img = dirname($img) ."/thumb.png";
            if(empty($img)) {
                $img = $theme_url ."/img/img-not-found.jpeg";
            }
        }
        elseif ($kind == 'alt') {
            preg_match('/<img.+alt=[\'"]([^\'"]+)[\'"].*>/i', $post_content, $alt);
            $img = $alt[1];
            if(empty($img)) {
                $img = 'game slide';
            }
        } elseif ($kind == 'rev') {
            preg_match('|<div class="gameReview">(.*?)</div>|isU', $post_content, $reviews);
            $clear = strip_tags($reviews[1]);
            $img = mb_substr($clear,0,100) .'...';
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
        preg_match_all('/<img(?:\\s[^<>]*?)?\\bsrc\\s*=\\s*(?|"([^"]*)"|\'([^\']*)\'|([^<>\'"\\s]*))[^<>]*>/i', $post->post_content, $images, PREG_SET_ORDER);
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

    // Список букв английского алфавита
    function getEnAlphabet() {
        return array(
            '#' => '#',
            'a' => 'a',
            'b' => 'b',
            'c' => 'c',
            'd' => 'd',
            'e' => 'e',
            'f' => 'f',
            'g' => 'g',
            'h' => 'h',
            'i' => 'i',
            'j' => 'j',
            'k' => 'k',
            'l' => 'l',
            'm' => 'm',
            'n' => 'n',
            'o' => 'o',
            'p' => 'p',
            'r' => 'r',
            's' => 's',
            't' => 't',
            'u' => 'u',
            'v' => 'v',
            'w' => 'w',
            'x' => 'x',
            'y' => 'y',
            'z' => 'z');
    }

    // Список букв русского алфавита
    function getRuAlphabet() {
        return array(
            '#' => '#',
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'и' => 'i',
            'й' => 'j',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shh',
            'э' => 'je',
            'ю' => 'ju',
            'я' => 'ja');
    }

    // Проверка есть ли буква руского алфавита
    function isRusLetter($str) {
        if (strpos($str, 'й') !== false) {
            echo "true";
        } else {
            echo "false";
        }
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
        $rating = round($newtable[0]->post_rating,2);
        return $rating;
    }

    // Получение количества голосований
    function getRatingCount() {
        global $wpdb;
        $newtable = $wpdb->get_results( "SELECT votes_count FROM $wpdb->posts WHERE ID=".get_the_ID());
        $votes_count = $newtable[0]->votes_count;
        return $votes_count;
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

        if ($max > 1) {
            echo '<div class="navigation"><ul>';
            echo '<li>' . paginate_links($a) .'</li>';
            echo '</ul></div>';
        }

    }

?>