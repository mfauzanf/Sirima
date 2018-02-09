<?php

function connectDB() {
  $DB_HOST = 'localhost';
  $DB_PORT = '5432';
  $DB_NAME = 'rakha.kanz';
  $DB_USER = 'rakha.kanz';
  $DB_PASS = '';

  $conn =  pg_connect("host=$DB_HOST port=$DB_PORT dbname=$DB_NAME user=$DB_USER password=$DB_PASS");

  if (!$conn) {
         die("Connection failed: " + pg_last_error());
  }

  return $conn;
}