<?php
if ($_GET['option'] == 'home') {
	header("Location: /index.php");
} elseif ($_GET['option'] == 'home_upload') {
	header("Location: /index.php#upload");
} elseif ($_GET['option'] == 'home_visualization') {
	header("Location: /index.php#visualization");
} elseif ($_GET['option'] == 'home_help') {
	header("Location: /index.php#help");
} elseif ($_GET['option'] == 'viz_timeline_trend') {
	header("Location: /cir/view/site/viz_timeline_trend.php");
} elseif ($_GET['option'] == 'viz_top_n_x_of_y') {
	header("Location: /cir/view/site/viz_top_n_x_of_y.php");
} elseif ($_GET['option'] == 'viz_citation_network') {
	header("Location: /cir/view/site/viz_citation_network.php");
} elseif ($_GET['option'] == 'upload_file_format') {
	header("Location: /cir/view/site/upload_file_format.php");
}
?>