<?php

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Count from dev.sandiego.gov on 01/24
 *
 * 1 application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
 * 1 application/vnd.openxmlformats-officedocument.wordprocessingml.document
 * 1 application/x-dosexec
 * 1 image/tiff
 * 1 image/vnd.dwg
 * 1 image/vnd.microsoft.icon
 * 1 image/x-ms-bmp
 * 1 video/x-m4v
 * 2 application/octet-stream
 * 3 application/x-empty
 * 5 application/vnd.openxmlformats-officedocument.presentationml.presentation
 * 11 text/html
 * 24 text/x-asm
 * 25 image/png
 * 73 text/xml
 * 170 application/zip
 * 182 application/gzip
 * 273 text/plain
 * 948 application/pdf
 * 1040 text/csv
 * 6772 image/jpeg
 */

$database = \Drupal::database();


$uid = 422;
$mime_types = [
  'application/pdf',
  'image/jpeg',
  'image/png',
  'image/tiff',
  'image/vnd.dwg'
];

chdir("sites/default/files");

/** @var \SplFileInfo $filename */
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.')) as $filename) {
  // filter out "." and ".."
  if ($filename->isDir()) continue;
  if (ignoreDir($filename->getPathname())) continue;

  // Build the uri so I can look in file_managed.
  $uri = 'public://' . substr($filename->getPathname(), 2);
  $result = $database->query("SELECT fid FROM {file_managed} WHERE uri = :uri", [ ':uri' => $uri, ], )->fetchAll();

  // If it's empty then it's not managed.
  if (empty($result)) {
    $mime = mime_content_type($filename->getPathname());
    $size = filesize($filename->getPathname());

    // Add it only if it's a mime type we want to add.
    if (in_array($mime, $mime_types)) {
      $bundle = getBundle($mime);
      $fid = createFile($uri, $filename, $size, $uid);
      $mid = createMedia($filename, $uid, $fid, $bundle);
      echo $filename->getPathname() . PHP_EOL;
    }
  }
}


function getBundle($mime): string {
  preg_match('#(.*)/(.*)#', $mime, $matches);
  return str_replace('application', 'document', $matches[1]);
}

function ignoreDir($haystack) {
  $ignore = [ './.htaccess', './private/', './styles/', './css', './js/',  './media-youtube/', './vendor/', './php', './asset_injector/' ];
  foreach ($ignore as $ignore_path) {
    if (str_starts_with($haystack, $ignore_path)) {
      return TRUE;
    }
  }
  return FALSE;
}

function createFile($uri, $filename, $size, $uid): int {
  $file = File::create([
    'filename' => basename($filename->getFilename()),
    'uri' => $uri,
    'status' => 1,
    'filesize' => $size,
    'uid' => $uid,
  ]);
  $file->save();
  return $file->id();
}

function createMedia(SplFileInfo $filename, $uid, $fid, $bundle) {

  $file = File::load($fid);
  $fieldname = 'field_media_' . $bundle;

  if ($file) {
    $media = Media::create([
      'bundle' => $bundle,
      'name' => $file->getFilename(),
      'status' => 1,
      'uid' => $uid,
      'langcode' => 'en',
      $fieldname => [
        'target_id' => $file->id(),
      ],
    ]);
    $media->save();
    return $media->id();
  }

//  $image_media = Media::create([
//    'name' => $filename->getFilename(),
//    'bundle' => $bundle,
//    'uid' => $uid,
//    'langcode' => 'en',
//    'status' => 1,
//    'field_media_image' => [
//      'target_id' => $fid,
//    ],
//  ]);
//  $image_media->save();
}
