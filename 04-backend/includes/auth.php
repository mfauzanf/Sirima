<?php

function redirect_if_logged_in() {
  session_start();

  if (isset($_SESSION['user'])) {
    if ($_SESSION['admin'] === true) {
      header('Location: ../admin/');
    } else {
      header('Location: ../dashboard/');
    }
  }
}

function auth_guard() {
  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: ../login/');
  }
}

function auth_guard_admin() {
  session_start();

  if (!isset($_SESSION['user'])) {
    header('Location: ../login/');
  } else if ($_SESSION['admin'] === false) {
    header('Location: ../dashboard/');
  }
}