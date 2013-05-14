<?php
	header("Content-Type: application/atom+xml; utf-8");
	echo '<?xml version="1.0" encoding="utf-8" ?>';
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<?php echo $body; ?>
	</channel>
</rss>