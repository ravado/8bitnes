
// Слайдер
$(function(){
    $('#slides').slides({
        preload: true,
        preloadImage: '../img/loading.gif',
        play: 5000,
        pause: 2500,
        hoverPause: true,
        generateNextPrev: false,
        animationStart: function(current){
            $('.caption').animate({bottom:-35},100);
            if (window.console && console.log) {
                // example return of current slide number
                console.log('animationStart on slide: ', current);
            }
        },
        animationComplete: function(current){
            $('.caption').animate({bottom:0},200);
            if (window.console && console.log) {
                // example return of current slide number
                console.log('animationComplete on slide: ', current);
            }
        },
        slidesLoaded: function() {
            $('.caption').animate({bottom:0},200);
        }
    });
});

function setRatingBar() {
    var total_raiting, star_widht;
    total_raiting = $("#raiting_info h5 .rating-value").text(); // итоговый ретинг
    star_widht = Math.ceil(total_raiting*30);
    $('#raiting_votes').width(star_widht);
}

$(document).ready(function() {

    // Выставление правильного колчества сердечек рейтинга
    setRatingBar();
    // Проверка куков голосовал ли человек за этот пост уже
    if(($.cookies.get('article'+$("#post_id").val())) == null){
        $('#raiting').hover(function() {
                $('#raiting_votes, #raiting_hover').toggle();
            },
            function() {
                $('#raiting_votes, #raiting_hover').toggle();
            });
        var margin_doc = $("#raiting").offset();
        $("#raiting").mousemove(function(e){
            var widht_votes = e.pageX - margin_doc.left;
            if (widht_votes == 0) widht_votes = 1 ;
            user_votes = Math.ceil(widht_votes/30);
            // обратите внимание переменная  user_votes должна задаваться без var, т.к. в этом случае она будет глобальной и мы сможем к ней обратиться из другой ф-ции (нужна будет при клике на оценке.
            $('#raiting_hover').width(user_votes*30);
        });
        // отправка
        $('#raiting').click(function(){
            $('#raiting_info h5, #raiting_info img').toggle();
            $.post('/wp-admin/admin-ajax.php', {
                action: 'change_rating',
                post_id: $("#post_id").val(),
                mark: user_votes
            }, function(data) {
                $('#raiting').css('cursor','default');
                $("#raiting_info h5 .rating-value").html(data.rating);
                $('#raiting_votes').width(Math.ceil((data.rating*30)));
                $('#raiting_votes').show();
                $('#raiting_info h5, #raiting_info img').toggle();
                $.cookies.set('article'+$("#post_id").val(), 123, {expires: 7}); // создаем куку
                $("#raiting").unbind();
                $('#raiting_hover').hide();
            },"json");
        });
    }
    else {
        $("#raiting").live('click', function() {
            $("#raiting_info h5 .already-voted").fadeIn(500).delay(2000).fadeOut(1000);
        });
        console.log('already voted');
    }
});