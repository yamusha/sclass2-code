<?php
/**
 * E_ALL = เปิด error ทั้งหมด
 * 0 = ปิด error ทั้งหมด
 */
error_reporting(E_ALL); 
/**
 * เรียกใช้งาน autoload สำหรับดึง class และ function ต่างๆ มาใช้งาน
 */
require_once __DIR__.'/../vendor/autoload.php';
/**
 * เรียกใช้งาน Routes สำหรับดึง เส้นทาง Api ทั้งหมด มาใช้งาน
 */
require_once 'Routes/Index.php';