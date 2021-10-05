<?php

function parseYoloLabels($content)
{
    $yoloContents = explode("\n", $content);

    $yoloLabels = [];

    foreach ($yoloContents as $yoloContent) {
        $yoloContentArray = explode(' ', $yoloContent);

        $yoloLabels[] = [
            'name' => $yoloContentArray[0],
            'x' => $yoloContentArray[1],
            'y' => $yoloContentArray[2],
            'w' => $yoloContentArray[3],
            'h' => $yoloContentArray[4],
        ];
    }

    return $yoloLabels;
}

function yoloToPosition($yoloX, $yoloY, $yoloW, $yoloH, $width, $height)
{
    $x1 = ($yoloX - $yoloW / 2) * $width;

    $y1 = ($yoloY - $yoloH / 2) * $height;

    $x2 = ($yoloX + $yoloW / 2) * $width;

    $y2 = ($yoloY + $yoloH / 2) * $height;

    return compact('x1', 'y1', 'x2', 'y2');
}

function getFileExtension($file)
{
    $fileArray = explode('.', $file);

    if (count($fileArray) === 1) {
        return '';
    }

    return end($fileArray);
}

function getFileName($file)
{
    $fileArray = explode('.', $file);

    return $fileArray[0];
}