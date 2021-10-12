<?php

require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$baseDir = './';
$inputDir = "{$baseDir}/input/";
$outputDir = "{$baseDir}/output/";
$imageExtensions = ['jpg', 'jpeg', 'png'];
$labelTitleMapping = [
    1 => 'reader',
    2 => 'calling',
];
$labelColorMapping = [
    0 => 'rgba(255, 157, 151, 0.5)',
    1 => 'rgba(145, 205, 49, 0.5)',
    2 => 'rgba(51, 67, 145, 0.5)',
    3 => 'rgba(145, 205, 49, 0.5)',
    4 => 'rgba(255, 48, 195, 0.5)',
];

$labeledCount = 0;

$manager = new ImageManager(['driver' => 'gd']);

$files = array_filter(scandir($inputDir), function ($file) {
    return substr($file, 0, 1) !== '.';
});

foreach ($files as $file) {

    $fileName = getFileName($file);

    $fileExtension = getFileExtension($file);

    if (!$fileExtension) {
        continue;
    }

    if (strtolower($fileExtension) !== 'txt') {
        continue;
    }

    $imageFiles = array_filter($files, function ($file) use ($fileName, $imageExtensions) {
        return getFileName($file) === $fileName && in_array(strtolower(getFileExtension($file)), $imageExtensions);
    });

    $content = file_get_contents("{$inputDir}/{$file}");

    $yoloLabels = parseYoloLabels($content);

    $labeledCount += count($imageFiles);

    foreach ($imageFiles as $imageFile) {
        $image = $manager->make("{$inputDir}/{$imageFile}");

        $labels = array_map(function ($yoloLabel) use ($image) {
            $position = yoloToPosition($yoloLabel['x'], $yoloLabel['y'], $yoloLabel['w'], $yoloLabel['h'], $image->width(), $image->height());

            return array_merge($position, ['name' => $yoloLabel['name']]);
        }, $yoloLabels);

        foreach ($labels as $label) {
            $color = !empty($labelColorMapping[$label['name']]) ? $labelColorMapping[$label['name']] : 'rgba(172, 41, 38, 0.5)';
            $title = !empty($labelTitleMapping[$label['name']]) ? $labelTitleMapping[$label['name']] : '';

            $image->rectangle($label['x1'], $label['y1'], $label['x2'], $label['y2'], function ($draw) use ($color) {
                $draw->background($color);
                $draw->border(1, $color);
            });

            if ($title) {
                $image->text($title, $label['x1'], $label['y1'], function ($font) {
                    $font->file('./font/OpenSans.ttf');
                    $font->size(18);
                    $font->color('#fdf6e3');
                    $font->valign('top');
                });
            }
        }

        $image->save("{$outputDir}/{$fileName}-labeled.jpg");
        $image->destroy();

        copy("{$inputDir}/{$imageFile}","{$outputDir}/{$imageFile}");
    }

    copy("{$inputDir}/{$file}","{$outputDir}/{$file}");
}

echo "Labeled {$labeledCount} photos." . PHP_EOL;
