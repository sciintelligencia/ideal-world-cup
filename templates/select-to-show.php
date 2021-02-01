<div id="license-tester" class="wrap">
<?php
if (isset($_GET['action']))
{
    $id = $_GET['id'];
    ideal_remove_image_by_id( $id );
}

if (isset($_POST['submit']))
{
    $ids = $_POST['id'];

    foreach ( $ids as $id ):
        $image = ideal_get_images_by_id( $id );
        ideal_insert_images_to_tournament( $image, $_POST['title'] );
        ideal_create_winner( $image['name'], $_POST['title'] );
    endforeach;
	ideal_create_tournament_shortcode( $_POST['title'] );

	echo '
    <div id="message" class="updated notice is-dismissible"><p>Quiz has been created successfully. <br>Use this in <b>post</b> or <b>page</b> to display the quiz<b>[display_pairs title="'.$_POST['title'].'"]</b></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
    ';
}
?>
	<h3>Select Maximum 16 Rows</h3>
	<?php
	$details = ideal_get_all_images();
	if (!empty($details)): ?>
        <form action="admin.php?page=ideal-world-cup-select-to-show" method="post">
            <table class="form-table">
                <tr>
                    <th>
                        <label for="title">Enter Title</label>
                        <input type="text" name="title" id="title">
                    </th>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <th>Select</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                    <?php foreach ( $details as $detail): ?>
                        <tr align="center">
                            <td><input type="checkbox" name="id[]" value="<?php print $detail['id'];?>" id="id-<?php echo $detail['id'] ?>"></td>
                            <td><label for="id-<?php echo $detail['id'] ?>"><?php print $detail['id'] ?></label> </td>
                            <td><label for="id-<?php echo $detail['id'] ?>"><?php print $detail['name'] ?></label> </td>
                            <td><label for="id-<?php echo $detail['id'] ?>"><img src="<?php print $detail['image'] ?>" alt="Left Image" width="100px"></label> </td>

                            <td><a href="admin.php?page=ideal-world-cup-select-to-show&action=delete&id=<?php echo $detail['id'] ?>">Delete</a> </td>
                        </tr>
                    <?php endforeach; ?>
            </table>
	        <?php submit_button(); ?>
        </form>
	<?php else: echo "No Details Found"; endif; ?>
</div>