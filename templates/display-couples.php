<input type="hidden" value="<?php echo plugin_dir_url( __FILE__ ) ?>" id="plugin_dir_url">
<input type="hidden" value="<?php echo $title ?>" id="title">
<link rel="stylesheet" href="https://www.kpopmap.com/wp-content/plugins/kpopmap-quiz/css/tournament.css">
<div id="fwm_cont">
    <div class="tournament-wrap" style="width: 70%; float: left">
        <div class="tournament-win">
            <div class="bg" style="left: -100%;">
                <div class="bg1"></div>
                <div class="bg2"></div>
                <div class="bg3"></div>
            </div>
            <div class="tournament">
                <div class="start">
                    <div>
                        <h6 style="color: #fff;"><?php echo $title; ?></h6>
                        <button type="button" id="ideal-start-btn" class="btn-start">Start</button>
                    </div>
                </div>
                <div class="process first-process" style="opacity: 1;">
                    <button type="button" class="btn-lineup"></button>
<!--                    <h3 class="process_round">The round of --><?//= $m ?><!--<br><span>Match 1 / 8</span></h3>-->
                    <?php
                    $max = count(ideal_get_tournament_by_title($title));
                    $counter = 0;
                    $c = 0;

                    while ( $counter < $max ):
	                    $tournament = ideal_create_tournament( $c, $title );
	                    $data = $tournament['data'];
	                    $c = $tournament['i'];
	                    if (!$data[0] == "" || !$data[1] == ""): ?>
                            <div style="margin-top: 60px; " class="item-wrap first-level left-100" id="data-<?php echo $counter ?>">
                                <h3 style="position: relative;z-index: 100;top: -45px;"> <?= $max ?> out of <?= $counter ?>/<?= round($max/2)?></h3>
                                <div class="item left wleft clickChk-l clickChk-l-f" float-id="<?php echo $data[0]['id'] ?>" data-id="<?php echo $counter ?>">
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
                                <div class="item right wright clickChk-r clickChk-r-f" float-id="<?php echo $data[1]['id'] ?>" data-id="<?php echo $counter ?>">
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
	                    $counter++;
                    endwhile;
                    ?>
                </div>

<!--        SECOND AND LAST        -->

            <div id="play-level-2" class="process second-process" style="display: none;opacity: 1;margin-top: 60px">
<!--                <button class="btn-lineup"></button>-->

<!--                <div id="play-level-2"></div>-->
            </div>

<!--        SECOND AND LAST        -->

            </div>
        </div>
        <div style="clear:both;"></div>
        <div id="ranking-list"></div>
    </div>
    <div style="width: 30%;float: right">
        <div id="lineup" class="partici single-side" style="">
            <h5 class="widget-title" align="center">Line-ups</h5>
            <ul class="lineup_ul">
                <?php $all = ideal_get_all_tournament();
                foreach ($all as $item) { ?>
                    <li style="list-style: none"><?= $item['name'] ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div style="content: '';clear: both;display: table"></div>
</div>