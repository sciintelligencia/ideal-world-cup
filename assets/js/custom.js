let array_data = [];
(function ($) {
    var leftImageMediaUploader;

    $("#ideal-media-uploader-1").on("click", function (e) {
        e.preventDefault();
        if (leftImageMediaUploader) {
            leftImageMediaUploader.open();
            return;
        }
        leftImageMediaUploader = wp.media.frames.file_name = wp.media({
            title: "Please Chose Left Image",
            button: {
                text: "Chose Picture"
            },
            multiple: false
        });
        leftImageMediaUploader.on("select", function () {
            let file = leftImageMediaUploader.state().get('selection').first().toJSON();
            $("#ideal-image-1").val(file.url);
        });
        leftImageMediaUploader.open();
    });

    $("#ideal-start-btn").on("click", function () {
        $(this).text("loading...");
        setTimeout(function () {
            $(".start").hide(1000);
        }, 1000);
            $("#data-0").show();
    });

    $(".clickChk-l-f").on("click", function () {
        var add = 1;
        let data_id = $(this).attr("data-id"),
            hide_id = "#data-" + data_id,
            id = parseInt(data_id)+ add,
            show_id = "#data-" + id,
            hide_new = "#s-" + data_id,
            show_new_id = "#s-" + id;
        $(hide_id).hide(1000);
        $(show_id).show();
        $(hide_new).hide(1000);
        $(show_new_id).show();

        var ajax_data = $(this).attr("float-id");
        array_data.push(ajax_data);
        console.dir(array_data);

        send_ajax(array_data, "first-level");
    });

    $(".clickChk-r-f").on("click", function () {
        var add = 1;
        let data_id = $(this).attr("data-id"),
            hide_id = "#data-" + data_id,
            id = parseInt(data_id)+ add,
            show_id = "#data-" + id,
            hide_new = "#s-" + data_id,
            show_new_id = "#s-" + id;
        $(hide_id).hide(1000);
        $(show_id).show();
        $(hide_new).hide(1000);
        $(show_new_id).show();
        var ajax_data = $(this).attr("float-id");
        array_data.push(ajax_data);
        console.dir(array_data);

        send_ajax(array_data, "first-level");
    });

    function send_ajax( array_data_, class_name ) {
        var a_alert = document.getElementsByClassName(class_name),
            data = array_data_.length;

        if (a_alert.length === data)
        {
            $.ajax({
                url: custom_ajax.ajaxurl,
                method: "post",
                data: "action=custom_ajax&method=get_more&ids="+array_data_,
                success:function(data){
                    array_data = [];
                    var obj = JSON.parse(data),
                        type = obj.type,
                        message = obj.message;

                    if (type === "success") {
                        $("#play-level-2").load($("#plugin_dir_url").val() + "../includes/ideal-play-second.php");
                        document.cookie = "ideal_game="+message+";expires=Thu, 18 Dec 2050 12:00:00 UTC;path=/";
                        $(".first-process").hide();
                        $(".second-process").show();
                        $("#s-0").show();
                    }
                }
            });
        }
    }
}(jQuery));