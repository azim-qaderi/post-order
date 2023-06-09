(function($) {
    "use strict";

    let keyupTimer;
    $(document).on('keyup', '.posts-wrapper .input-text', function(){
        clearTimeout(keyupTimer);
        var keyword = $(this).val();
        var lang = $(this).data('lang');
        var parentDiv = $(this).parent();

        var input_id = $(this).closest('.form-group').find('input[type=hidden]');

        if( keyword != '' && keyword.length > 5){

            document.querySelectorAll(".post-result-wrapper").forEach(el => el.remove());
            $('.post-result-wrapper').remove();
            keyupTimer = setTimeout(function () {
                var data = {
                    'action': 'get_posts_info',
                    'keyword': keyword,
                    'lang': lang
                };
                $.post(ajax_object.ajax_url, data, function(response) {
                    if( response != '[]' ){
                        var results = JSON.parse(response);
                        var html = '';
                        parentDiv.append('<div class="post-result-wrapper"></div>');
                        results.forEach(element => {
                            html = `
                                <div class="post-return-result" data-id="${element['ID']}">${element['post_title']}</div>
                            `;
                            $('.post-result-wrapper').append(html);
                        });   
                    }
                });
    
            }, 500);
        }
        else{
            document.querySelectorAll(".post-return-result").forEach(el => el.remove());
            input_id.val('');
        }

    });

    $(document).on('click', '.post-result-wrapper .post-return-result', function(){
        var post_id = $(this).data('id');
        var post_title = $(this).text();

        var input_field = $(this).closest('.form-group').find('input[type=text]');
        var input_id = $(this).closest('.form-group').find('input[type=hidden]');
        input_field.val(post_title);
        input_id.val(post_id);

        document.querySelectorAll(".post-result-wrapper").forEach(el => el.remove());
        $('.post-result-wrapper').remove();

    });

    $(document).on('click', function (e) {
        if ($(e.target).closest(".post-result-wrapper").length === 0) {
            document.querySelectorAll(".post-result-wrapper").forEach(el => el.remove());
            $('.post-result-wrapper').remove();
        }
    });


})(jQuery);