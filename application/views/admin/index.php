<?= form_open_multipart($form_url, '', $hidden ?? null); ?>
	<input type="text" name="brand">
	<input type="submit" name="Submit" value="submit">
		<input type="file" name="file">
<?= form_close(); ?>