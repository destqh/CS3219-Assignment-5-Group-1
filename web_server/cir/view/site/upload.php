<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/controller/front_end_controller.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Conference Information Retrieval</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="//d3plus.org/js/d3.js"></script>
    <script src="//d3plus.org/js/d3plus.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/bootstrap.php'); ?>
	<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/nav/navbar.php'); ?>
	<link rel="stylesheet" href="/cir/view/css/upload.css">
</head>

<body>
<div class="upload">
<form action="../upload/upload_checker.php" method="post" enctype="multipart/form-data">
    <h1>Select file to upload(JSON/XML format):</h1>
    <p></p>
    <input id="inp1" type="file" name="fileToUpload" class="btnBrowseFile" value="Upload" id="fileToUpload"/>
    <p></p>
    <input id="inp2" type="submit" name="submit" class="btnUpload" value="Upload" />
</form>
</div>
</body>
