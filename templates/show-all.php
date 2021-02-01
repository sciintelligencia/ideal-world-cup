<h1>Display All Shortcodes Of Tournament</h1>

<div class="wrap" id="license-tester">

			<?php $tournaments = ideal_get_tournament_shortcode();
			if (empty($tournaments))
			{
				echo "No Record Found";
			} else { ?>
    <table width="100%" class="form-table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Shortcode</th>
        </tr>
        </thead>
        <tbody>
        <?php
			$id = 1;
			foreach ( $tournaments as $tournament ): ?>
				<tr>
					<td><?= $id ?></td>
					<td><?= $tournament['title'];?></td>
					<td>[display_pairs title='<?= $tournament['title']?>']</td>
				</tr>
				<?php $id++; endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Shortcode</th>
        </tr>
        </tfoot>
    </table>

			<?php } ?>
</div>