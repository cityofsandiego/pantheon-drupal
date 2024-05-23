<?php

use Drupal\file\Entity\File;
use Drupal\media\Entity\Media;

/**
 * Count of unmanaged files from dev.sandiego.gov on 01/24
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

$uid = 422; // programatic user id.
$mime_types = [
  'application/pdf',
  'image/jpeg',
  'image/png',
  'image/tiff',
  'image/vnd.dwg'
];

$database = \Drupal::database();
$managed_files = $database->query("SELECT uri, 1 FROM {file_managed}")->fetchAllKeyed(0,1);

chdir("sites/default/files");

/** @var \SplFileInfo $filename */
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator('.')) as $filename) {
  // filter out "." and ".."
  if ($filename->isDir()) continue;
  if (ignoreDir($filename->getPathname())) continue;

  // Build the uri so I can look in file_managed.
  $uri = 'public://' . substr($filename->getPathname(), 2);
//  $result = $database->query("SELECT fid FROM {file_managed} WHERE uri = :uri", [ ':uri' => $uri, ], )->fetchAll();

  // If it's empty then it's not managed.
  if (!isset($managed_files[$uri])) {
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

echo PHP_EOL . 'Peak real memory MB: ' . memory_get_peak_usage(TRUE) / 1024 / 1024 . PHP_EOL;

/**
 * Get/Map a mime type to it's media bundle name. Document or Image now.
 *
 * @param string $mime
 *
 * @return string
 */
function getBundle(string $mime): string {
  preg_match('#(.*)/(.*)#', $mime, $matches);
  return str_replace('application', 'document', $matches[1]);
}

/**
 * Return True if we should avoid this directory.
 *
 * @param string $haystack
 *
 * @return bool
 */
function ignoreDir(string $haystack): bool {
  $ignore = [ './.DS_Store', './.htaccess', './private/', './styles/', './css', './js/',  './media-youtube/', './vendor/', './php', './asset_injector/' ];
  foreach ($ignore as $ignore_path) {
    if (str_starts_with($haystack, $ignore_path)) {
      return TRUE;
    }
  }
  return FALSE;
}

/**
 * Create a file entity for a file that already exists.
 *
 * @param string $uri
 * @param \SplFileInfo $filename
 * @param $size
 * @param int $uid
 *
 * @return int
 * @throws \Drupal\Core\Entity\EntityStorageException
 */
function createFile(string $uri, SplFileInfo $filename, $size, int $uid): int {
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

/**
 * Create media entity of type document or image with file already existing.
 *
 * @param \SplFileInfo $filename
 * @param int $uid
 * @param int $fid
 * @param string $bundle
 *
 * @return int
 * @throws \Drupal\Core\Entity\EntityStorageException
 */
function createMedia(SplFileInfo $filename, int $uid, int $fid, string $bundle): int {

  $file = File::load($fid);
  // Note: We have just tested on pdf (document) and images (image) for bundles.
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
}
