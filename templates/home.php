<div id="lisence-tester" class="wrap">

<?php
ob_start();

if (isset($_POST['submit']))
{
	$name = $_POST['name'];
	$image = $_POST['image'];

	ideal_insert_images_details( [ "name" => $name, "image"  =>  $image ] );
	echo '<div id="message" class="updated notice is-dismissible"><p>Image Added Successfully. </p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
}
?>


	<h1>Ideal World Cup Options</h1>
	<h2>Select Images And Enter Names</h2>

	<form action="admin.php?page=ideal-world-cup-home" method="post">

		<table class="form-table">
			<tr>
				<th><label for="name-1">Enter Name</label></th>
				<td>
                    <input type="text" name="name" placeholder="Enter Name" id="name-1">
                </td>
			</tr>

			<tr>
				<th><label for="image-1">Select Image</label></th>
				<td><button class="button button-secondary" type="button" id="ideal-media-uploader-1">Select Image</button></td>
				<input type="hidden" name="image" id="ideal-image-1">
			</tr>

		</table>

		<?php submit_button(); ?>
	</form>
</div>