# LBChecker
LBChecker is a tool to extract value from YOLO format data text files and draw bounding boxes in clean images.

---

## Purpose
- We want to detect objects from images and videos, we choose YOLO as the model
- To train this model, we will need a large of datasets
- Most of time, a dataset with good quality can take improve the models training results
- So, how can we ensure the quality of datasets and check whether we draw the bounding boxes correctly or not
- This tool can read the text files and convert the value to produce x_center y_center width height of the bounding boxes and draw it to the images

---

## Before we start

To use this tool, make sure you already install the following:
- PHP >=7.0
- Fileinfo Extension
- GD Library (>=2.0)

---

## Quick start

1. Move the images and text files into the input folder
2. Run main.php
3. Check the result in output folder

---

## Some tips to know

1. To change or add more classes of the labels
```
$labelTitleMapping = [
    0 => 'smoking',
    1 => 'reading',
    2 => 'calling',
    3 => 'drinking',
    4 => 'eating',
```

2. To change the color of the bounding boxes
```
$labelColorMapping = [
    0 => 'rgba(255, 157, 151, 0.5)',
    1 => 'rgba(145, 205, 49, 0.5)',
    2 => 'rgba(51, 67, 145, 0.5)',
    3 => 'rgba(145, 205, 49, 0.5)',
    4 => 'rgba(255, 48, 195, 0.5)',
```

---
