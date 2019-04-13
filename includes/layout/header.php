<?php ob_start(); ?>
 <?php if(!isset($layout_context)){ $layout_context = "Public";} ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Widget Corp <?php if($layout_context == "Admin"){ echo "Admin"; } ?> </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <!-- <link rel="stylesheet" href="css/"> -->
</head>
<body class="bg-light">

<div class="container-wrapper">
         <!-- NAVBAR -->
      <div class="navbar bg-success text-danger">
        <h1 class="p-3">Widget Corp <?php if($layout_context == "Admin"){ echo "Admin"; } ?> </h1>
      </div>
         <!-- MAIN -->
   <div class="main">
         