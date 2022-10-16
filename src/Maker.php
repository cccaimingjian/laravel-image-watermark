<?php

namespace cccaimingjian\ImageWatermark;

use GdImage;

class Maker
{
    protected int $w_interval = 50;
    protected int $h_interval = 50;
    protected float $str_angel = 15.0;
    protected int $color = 0x30BEBEBE;
    protected int $pic_w = 0;
    protected int $pic_h = 0;
    protected ?GdImage $image = null;
    protected string $font_path = __DIR__.'/font/SourceHanSerifSC-Medium.otf';
    public string $file_path = '';
    public string $string = 'watermark';
    public float $font_size = 10.0;

    public function __construct(string $original_path = '')
    {
        if ($original_path) {
            $this->file_path = $original_path;
        }
    }

    /**
     * Set the image path (Original image)
     * 设置你要添加水印的那张图片的路径（原图）
     * @param string $file_path
     * @return $this
     */
    public function setInputFilePath(string $file_path): Maker
    {
        $this->file_path = $file_path;
        return $this;
    }

    /**
     * Set the angle of the watermark string
     * 设置水印字符的角度
     * @param float $angle
     * @return $this
     * The angle in degrees, with 0 degrees being left-to-right reading text.
     * Higher values represent a counter-clockwise rotation.
     * For example, a value of 90 would result in bottom-to-top reading text.
     */
    public function setAngle(float $angle): Maker
    {
        $this->str_angel = $angle;
        return $this;
    }

    /**
     * Set the font size of the watermark string
     * 设置水印字体大小
     * @param float $size
     * @return $this
     * The font size. Depending on your version of GD, this should be specified as the pixel size (GD1) or point size (GD2).
     */
    public function setFontSize(float $size)
    {
        $this->font_size = $size;
        return $this;
    }

    /**
     * Set the watermark string
     * 设置水印的内容
     * @param $string
     * the string you want to add.
     * @return $this
     *
     */
    public function setWatermarkString(string $string): Maker
    {
        $this->string = $string;
        return $this;
    }

    /**
     * Set the color of the watermark string
     * 设置水印内容的颜色
     * @param int $color
     * The color index. Using the negative of a color index has the effect of turning off antialiasing. See imagecolorallocate.
     * @return $this
     */
    public function setWatermarkColor(int $color): Maker
    {
        $this->color = $color;
        return $this;
    }

    /**
     * Set the interval of width
     * 设置水印横向的间隔
     * 注意是开头的间隔，间隔大小请根据水印的字符长度合理设置
     * @param $interval int
     * the pixel between watermark's START in horizontal direction
     * @return $this
     */
    public function setWatermarkWidthInterval(int $interval): Maker
    {
        $this->w_interval = $interval;
        return $this;
    }

    /**
     * Set the interval of height
     * 设置水印纵向的间隔
     * @param $interval
     * the pixel between watermark in vertical direction
     * @return $this
     */
    public function setWatermarkHeightInterval(int $interval): Maker
    {
        $this->h_interval = $interval;
        return $this;
    }

    /**
     * Set the font path
     * 设置水印字体文件
     * @param $font_path
     * the font file path
     * @return $this
     */
    public function setWatermarkFont(string $font_path): Maker
    {
        $this->font_path = $font_path;
        return $this;
    }

    /**
     * draw watermark
     * 画水印
     * @throws \Exception
     */
    public function drawWatermark(): Maker
    {
        if (!$this->image) {
            $this->loadPicture();
        }
        for ($i = 0; $i<=$this->pic_w; $i = $i + $this->w_interval) {
            for ($j = 0; $j<=$this->pic_h; $j = $j + $this->h_interval) {
                imagettftext(
                    $this->image,
                    $this->font_size,
                    $this->str_angel,
                    $i,
                    $j,
                    $this->color,
                    $this->font_path,
                    $this->string
                );
            }
        }
        return $this;
    }

    /**
     * encode the image to JPG
     * @param string $file_name [optional]
     * The path to save the file to. If not set or null, return the image content.
     * @return bool|string
     */
    public function encodeToJPG(string $file_name = '')
    {
        if (!$file_name) {
            ob_start();
            imagejpeg($this->image);
            return ob_get_clean();
        }
        return imagejpeg($this->image, $file_name);
    }

    /**
     * encode the image to PNG
     * @param string $file_name
     * @return bool|string
     */
    public function encodeToPNG(string $file_name = '')
    {
        if (!$file_name) {
            ob_start();
            imagepng($this->image);
            return ob_get_clean();
        }
        return imagepng($this->image, $file_name);
    }

    /**
     * @return null|GdImage
     */
    public function getGdImage()
    {
        return $this->image;
    }

    /**
     * Load the image into Memory
     * 读取图片
     * @return bool
     * @throws \Exception
     */
    protected function loadPicture(): bool
    {
        if (!file_exists($this->file_path)) {
            throw new \Exception('File: "'.$this->file_path.'" does not exist');
        }
        $image_data = file_get_contents($this->file_path);
        if (!$image_data) {
            throw new \Exception('file_get_contents() can NOT get the file:"'.$this->file_path.'"');
        }
        $this->image = imagecreatefromstring($image_data);
        if (!$this->image) {
            throw new \Exception('Can NOT Load the file:"'.$this->file_path.'", please confirm the file is an image');
        }
        $this->pic_w = imagesx($this->image);
        $this->pic_h = imagesy($this->image);
        return true;
    }

    /**
     * @return null|GdImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param GdImage|null $image
     * @return bool
     */
    public function setImage(?GdImage $image): bool
    {
        $this->image = $image;
        return true;
    }
}
