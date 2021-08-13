<?= form_open_multipart($form_url, '', $hidden ?? null); ?>
	<input type="text" name="brand">
	<input type="file" name="file">
	<input type="submit" name="Submit" value="submit">
<?= form_close(); ?>