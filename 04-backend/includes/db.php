<?php

function connectDB() {
  $DB_HOST = 'dbpg.cs.ui.ac.id';
  $DB_PORT = '5432';
  $DB_NAME = 'a202';
  $DB_USER = 'a202';
  $DB_PASS = 'bda0222016';

  $conn =  pg_connect("host=$DB_HOST port=$DB_PORT dbname=$DB_NAME user=$DB_USER password=$DB_PASS");

  if (!$conn) {
         die("Connection failed: " + pg_last_error());
  }

  return $conn;
}