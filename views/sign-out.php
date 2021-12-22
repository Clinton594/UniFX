<?php
session_destroy();
header("Location: {$uri->site}");
die();
?>