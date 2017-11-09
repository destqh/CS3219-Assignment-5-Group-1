<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/cir/view/import/import.php'); ?>
<link rel="stylesheet" href="/cir/view/css/index.css">

<!-- Navbar (sit on top) -->
<div class="w3-top">
  <div class="w3-bar w3-white w3-card" id="myNavbar">
  <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=home"; ?>" "w3-bar-item w3-button w3-wide" class="w3-bar-item w3-button">Conference Information Retrieval</a>
    <!-- Right-sided navbar links -->
    <div class="w3-right w3-hide-small">
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=home_upload"; ?>" class="w3-bar-item w3-button">Upload</a>
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=home_visualization"; ?>" class="w3-bar-item w3-button"><i class="fa fa-th"></i> Visualization</a>
      <a href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo "option=home_help"; ?>" class="w3-bar-item w3-button"><i class="fa fa-user"></i> Help</a>
    
    <!-- Hide right-floated links on small screens and replace them with a menu icon -->
    <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
      <i class="fa fa-bars"></i>
    </a>
  </div>
</div>
</div>