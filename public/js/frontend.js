$(document).ready(function() {
    $(".subscribe-btn").click(function(e) {
        $(".subscribe-btn").text('processing...');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            email: $('#email').val(),
        };
        var type = "POST";
        var ajaxurl = 'subscribe';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function(data) {
                $('#success_message').text(data.message);
                $('input[name="email"]').val('');
                $(".subscribe-btn").text('Subscribe');
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });


    //post  discussion  parent comments

    $(".main_comment-btn").click(function(e) {
        $(".main_comment-btn").text('processing...');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            comment: $('#main_comment').val(),
            discussion_id: $('#discussion_id').val()
        };
        var type = "POST";
        var ajaxurl = 'parent_comment';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    setInterval(function() {
                        location.reload();
                    }, 5000);
                }
                $('#success_message').text(data.message);
                $('input[name="main_comment"]').val('');
                $(".main_comment-btn").text('Post Comment');
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });

    //end parent comment


});