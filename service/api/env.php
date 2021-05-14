<?php
use Dotenv\Dotenv;

/** เรียกใช้งานตัวแปรที่เก็บไว้ใน .env */
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/** กำหนด timezone */
date_default_timezone_set('Asia/Bangkok');
