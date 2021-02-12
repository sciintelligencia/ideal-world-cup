<?php
if ( file_exists( dirname( __FILE__, 5) . "/wp-load.php" ) )
{
	require_once dirname( __FILE__, 5 ) . "/wp-load.php";
}

$title = $_POST['title'];
?>
<div class="tournament-ranking" style="display: block;">
	<h3>Ranking</h3>
	<ul class="Ranking_list">
		<?php
		$i = 1;
		$winners = ideal_get_winner_from_table($title);
		foreach ( $winners as $key => $winner):
			if ( $winner->votes == ideal_get_max_votes_by_title($title) ): ?>
				<li>
					<span class="medal gold"></span>
					<span class="rank"><?= $i ?></span>
					<span class="name"><?= $winner->name ?>
                            </span><span class="vote"><?= $winner->votes ?></span>
				</li>
			<?  else: ?>
				<li>
					<span class="medal"></span>
					<span class="rank"><?= $i ?></span>
					<span class="name"><?= $winner->name ?>
                        </span><span class="vote"><?= $winner->votes ?></span>
				</li>
			<?php endif;
			$i++; endforeach; ?>
	</ul>
</div>