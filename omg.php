<?php
/**
 * Recursively add files and directories to a ZIP file
 *
 * @param string $source Source directory to zip
 * @param ZipArchive $zip ZIP archive object
 * @param string $subdir Subdirectory inside the ZIP file
 */
function zipDir($source, $zip, $subdir = '')
{
    $source = rtrim($source, DIRECTORY_SEPARATOR);
    if (!file_exists($source)) {
        return false;
    }

    $dir = opendir($source);
    while (false !== ($file = readdir($dir))) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        $filePath = $source . DIRECTORY_SEPARATOR . $file;
        $zipPath = $subdir ? $subdir . DIRECTORY_SEPARATOR . $file : $file;

        if (is_dir($filePath)) {
            // Add directory and recurse
            $zip->addEmptyDir($zipPath);
            zipDir($filePath, $zip, $zipPath);
        } else {
            // Add file
            $zip->addFile($filePath, $zipPath);
        }
    }

    closedir($dir);
}

/**
 * Create a ZIP file from a directory
 *
 * @param string $source Source directory to zip
 * @param string $destination Destination ZIP file
 * @return bool True on success, false on failure
 */
function createZip($source, $destination)
{
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();
    if (!$zip->open($destination, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        return false;
    }

    zipDir($source, $zip);

    return $zip->close();
}

// Usage
$sourceDir = './';
$destinationZip = './file.zip';

if (createZip($sourceDir, $destinationZip)) {
    echo "ZIP file created successfully.";
} else {
    echo "Failed to create ZIP file.";
}
?>
