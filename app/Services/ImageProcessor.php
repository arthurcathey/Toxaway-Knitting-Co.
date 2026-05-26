<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageProcessor
{
  /**
   * Process and optimize an uploaded image
   * - Resize to max dimensions
   * - Compress to reasonable quality
   * - Save as WebP format for smaller file size
   * 
   * @param UploadedFile $file
   * @param string $directory Directory within storage/app/public
   * @param int $maxWidth Maximum width in pixels
   * @param int $maxHeight Maximum height in pixels
   * @param int $quality JPEG/WebP quality (1-100)
   * @return string Relative path to stored file
   */
  public static function process(
    UploadedFile $file,
    string $directory = 'images',
    int $maxWidth = 1200,
    int $maxHeight = 1200,
    int $quality = 80
  ): string {
    // Generate secure filename with random string
    $filename = time() . '_' . Str::random(10) . '.webp';
    $storagePath = storage_path("app/public/{$directory}");

    // Create directory if it doesn't exist
    if (!is_dir($storagePath)) {
      mkdir($storagePath, 0755, true);
    }

    // Load the image
    $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

    if (!$image) {
      // Fallback: store original if GD fails
      $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
      $file->storeAs($directory, $filename, ['disk' => 'public']);
      return "{$directory}/{$filename}";
    }

    // Get original dimensions
    $origWidth = imagesx($image);
    $origHeight = imagesy($image);

    // Calculate new dimensions (maintain aspect ratio)
    $aspectRatio = $origWidth / $origHeight;
    $newWidth = $maxWidth;
    $newHeight = (int)($maxWidth / $aspectRatio);

    // Adjust if height exceeds max
    if ($newHeight > $maxHeight) {
      $newHeight = $maxHeight;
      $newWidth = (int)($maxHeight * $aspectRatio);
    }

    // Create resized image
    $resized = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG
    if ($file->getMimeType() === 'image/png') {
      imagealphablending($resized, false);
      imagesavealpha($resized, true);
    }

    // Resize image
    imagecopyresampled(
      $resized,
      $image,
      0,
      0,
      0,
      0,
      $newWidth,
      $newHeight,
      $origWidth,
      $origHeight
    );

    // Save as WebP
    imagewebp($resized, "{$storagePath}/{$filename}", $quality);

    // Free up memory
    imagedestroy($image);
    imagedestroy($resized);

    return "{$directory}/{$filename}";
  }
}
