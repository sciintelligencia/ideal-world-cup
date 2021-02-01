<style type="text/css">
    .left-100:first-of-type{
        display: block !important;
    }
</style>
<?php
if ( file_exists( dirname( __FILE__, 5) . "/wp-load.php" ) )
{
    require_once dirname( __FILE__, 5 ) . "/wp-load.php";
}
$counter = 0;
$c = 0;
$max = count(ideal_get_tournament_by_ip());
if ($max <= 1)
{
    $result = ideal_create_tournament_by_ip( 0 );
    ideal_get_winner_by_name_and_title( $result['data'][0]['name'], $result['data'][0]['title'] );
    ?>
    <style type="text/css">
        #play-level-2 {
            margin-top: 0px !important;
        }
    </style>
    <div class="result" style="display: block">
        <a type="button" class="btn-restart" href=""></a>
        <div>
            <h3>Winner</h3>
            <div class="item">
                <div class="img result_img">
                    <img src="<?= $result['data'][0]['image'] ?>" alt="">
                </div>
                <div class="txt">
                    <p class="name result_name"><?= $result['data'][0]['name']?><!--<br><span>BTS</span>--></p>
                </div>
            </div>
        </div>
    </div>

<?php } else {
	while ( $counter <= $max )
	{
		$tournament = ideal_create_tournament_by_ip( $c );
		$data = $tournament['data'];
		if (!$data[0] == "" || !$data[1] == ""): ?>
            <div class="item-wraps second-level left-100" id="s-<?php echo $counter ?>">
                <h3 id="he-<?= $counter ?>" style="position: relative;z-index: 100;top: -72px;"> <?= $max ?> out of <?= $counter ?>/<?= round($max/2)?></h3>
                <div class="item left wleft clickChk-l clickChk-l-s" float-id="<?php echo $data[0]['id'] ?>" data-id="<?php echo $counter ?>">
                    <div class="img">
                        <img src="<?php echo $data[0]['image'] ?>" alt="">
                    </div>
                    <div class="load-bar">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <div class="txt">
                        <p class="name left_name">
							<?php echo $data[0]['name'] ?>
                        </p>
                    </div>
                </div>
                <div class="item right wright clickChk-r clickChk-r-s" float-id="<?php echo $data[1]['id'] ?>" data-id="<?php echo $counter ?>">
                    <div class="img">
                        <img src="<?php echo $data[1]['image'] ?>" alt="">
                    </div>
                    <div class="load-bar">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <div class="txt">
                        <p class="name right_name">
							<?php echo $data[1]['name'] ?>
                        </p>
                    </div>
                </div>
            </div>
		<?php else:
			break;
		endif;
		$c = $tournament['i'];
		$counter++;
	}
}
?>
<script type="text/javascript">
    array_data = [];
    (function($){
        $(".clickChk-l-s").on("click", function () {
            var add = 1;
            let data_id = $(this).attr("data-id"),
                id = parseInt(data_id)+ add,
                hide_new = "#s-" + data_id,
                show_new_id = "#s-" + id;
            $(hide_new).hide(1000);
            // $("#he"+data_id).hide();
            $("#he-0").css("display", "none");
            $(show_new_id).show();

            var ajax_data = $(this).attr("float-id");
            array_data.push(ajax_data);
            console.dir(array_data);

            send_ajax(array_data, "second-level");
        });

        $(".clickChk-r-s").on("click", function () {
            var add = 1;
            let data_id = $(this).attr("data-id"),
                id = parseInt(data_id)+ add,
                hide_new = "#s-" + data_id,
                show_new_id = "#s-" + id;
            $(hide_new).hide(1000);
            $(show_new_id).show();
            // $("#he"+data_id).hide();
            $("#he-0").css("display", "none");
            var ajax_data = $(this).attr("float-id");
            array_data.push(ajax_data);
            console.dir(array_data);

            send_ajax(array_data, "second-level");
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
</script>