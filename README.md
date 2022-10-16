laravel-image-watermark
---

Make the whole image full of watermarks

## Installing

```shell
composer require cccaimingjian/laravel-image-watermark -vvv
```

## Usage

```php
$maker = new Maker();
$maker->setInputFilePath('PATH_TO_YOUR_IMAGE');
```
or 
```php
$maker = new Maker('PATH_TO_YOUR_IMAGE');
``` 
or 
```php
$image = imagecreatefromstring($string);
$image = imagecreatefromjpeg($filename);
...
$maker = new Maker();
$maker->setImage($image);
``` 

### No.2
Set the watermark characters you want to add,and font file you want to use  
然后，设置你要添加的水印字符,并且指定字体文件
```php
$maker->setWatermarkString('WATERMARK_STRING_HERE');
$maker->setWatermarkFont('PATH_TO_YOUR_FONT_FILE');
```
or  
```php
$maker->setWatermarkString('WATERMARK_STRING_HERE')
->setWatermarkFont('PATH_TO_YOUR_FONT_FILE');
```

### No.3
Set the watermark style  
设置水印样式
+ Set angle, defult 15 degrees  
  设置角度
```php
$maker->setAngle(10); 
```  
+ Set font size, defult 10  
  设置字体大小
```php
$maker->setFontSize(50); 
```  
+ Set watermark color  
  设置水印颜色
```php
$maker->setWatermarkColor(0xFF0000);
```
+ Set the interval  
  设置间隔  
  When setting the horizontal interval, please evaluate the length of the watermark content  
  When setting the vertical interval, please evaluate the angle of the watermark content  
  在设置横向间隔的时候，请评估水印内容的长度  
  在设置纵向间隔的时候，请评估水印内容的角度
```php
$maker->setWatermarkWidthInterval(100);
$maker->setWatermarkHeightInterval(50);
```
### No.4
Draw watermark  
画水印
```php
$maker->drawWatermark();
```
### No.5
Get the watermarked image  
获取画了水印的图片
+ Get the watermarked image data directly  
  直接获取打了水印的图片

Get the watermarked image data content, JPG format  
获取带水印的图片数据内容，JPG格式  
```php
$content = $maker->encodeToJPG();
```

Get the watermarked image data content, PNG format  
获取带水印的图片数据内容，PNG格式  
```php
$content = $maker->encodeToPNG();
```

Save the watermarked image  
保存图片到指定路径  
```php
$maker->encodeToJPG('PATH_TO_SAVE');
``` 
```php
$maker->encodeToPNG('PATH_TO_SAVE');
```

Get the watermarked image before GD's function imageXXX()  
You can encode into other formats or perform other operations by yourself  
获取GD imageXXX()之前的资源，你可以自己编码成其他格式或进行其他操作
```php
$image   = $maker->getGdImage();
imagebmp($image,'PATH');  //encode to bmp.
...
```

## PHP 扩展包开发

> 想知道如何从零开始构建 PHP 扩展包？
>
> 请关注超哥的实战课程，
> 超哥在此课程中分享了一些扩展开发经验 —— [《PHP 扩展包实战教程 - 从入门到发布》](https://learnku.com/courses/creating-package?rf=81208)

## I bought a JetBrains license

Waiting for Jetbrains to sponsor me an open-source projects license

![](https://resources.jetbrains.com/storage/products/company/brand/logos/jb_beam.svg)

## License

MIT
