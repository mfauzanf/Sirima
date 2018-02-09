<?php

include './includes/auth.php';

redirect_if_logged_in();

header('Location: ./login/');