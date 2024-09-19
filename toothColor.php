<?php

require_once __DIR__ . '/vendor/autoload.php';

use SVG\SVG;

/**
 * Colors specific elements (teeth) in an SVG file by their ID and outputs or saves the modified SVG.
 *
 * @param string $svgFile The path to the SVG file to be processed.
 * @param string $outputMode The output mode. Use 'O' for direct output to the browser, or 'F' to save the file.
 * @param string ...$args IDs of the teeth elements to be colored.
 *
 * @return string If the output mode is 'F', returns the path to the saved file. If 'O', outputs the SVG directly and returns void.
 *
 * @throws FileNotFoundException If the SVG file is not found at the specified path.
 * @throws FileNotValidException If the specified file is not a valid SVG.
 * @throws OutputModeNotValidException If the output mode is not valid (accepted values are 'O' or 'F').
 * @throws Exception If there is an error saving the file in 'F' mode.
 */
function toothColor(string $svgFile, string $outputMode, ...$args): string
{
    // Check if the file exists
    if (!file_exists($svgFile)) {
        throw new FileNotFoundException('SVG file not found');
    }

    // Check if it's an SVG
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Ottiene solo il MIME type
    $mimeType = finfo_file($finfo, $svgFile);
    finfo_close($finfo);
    if ($mimeType !== 'image/svg+xml') {
        throw new FileNotValidException('The file is not an SVG');
    }

    // Check if the output mode is supported
    $modes = ['O', 'F'];
    if (!in_array($outputMode, $modes)) {
        throw new OutputModeNotValidException('Output mode is invalid. Accepted values are [O, F]');
    }

    // Create the SVG object
    $image = SVG::fromFile($svgFile);

    // Get the elements with the given IDs
    foreach ($args as $toothID) {
        $tooth = $image->getDocument()->getElementById('Tooth' . $toothID);
        if ($tooth) {
            // Check for children node
            $children = array_merge(
                $tooth->getElementsByTagName('polygon'),
                $tooth->getElementsByTagName('path'),
            );
            if (count($children) > 0) {
                $children[0]->setStyle('fill', '#dddddd');
            }
            // Otherwise, color the node itself
            else {
                $tooth->setStyle('fill', '#dddddd');
            }
        }
    }

    if ($outputMode === 'O') {
        header('Content-Type: image/svg+xml');
        echo $image;
    }
    else {
        $fileName = __DIR__ . '/storage/filled/' . uniqid() . '.svg';
        if (!file_put_contents($fileName, $image)) {
            throw new Exception('Cannot save the file');
        }
        return $fileName;
    }

    // Should never reach here
    return false;
}