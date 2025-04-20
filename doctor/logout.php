<?php
 session_start();

 unset($_SESSION['docid']);
 session_destroy();

 header('Location: login.php');