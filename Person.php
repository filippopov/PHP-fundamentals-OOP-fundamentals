<?php
class Box
{
    private $length;

    private $width;

    private $height;

    public function __construct($length, $width, $height)
    {
        $this->setLength($length);
        $this->setWidth($width);
        $this->setHeight($height);
    }

    private function setLength($length)
    {
        if ($length <= 0) {
            throw new Exception('Length cannot be zero or negative.');
        }
        $this->length = $length;
    }

    private function setWidth($width)
    {
        if ($width <= 0) {
            throw new Exception('Width cannot be zero or negative.');
        }
        $this->width = $width;
    }

    private function setHeight($height)
    {
        if ($height <= 0) {
            throw new Exception('Height cannot be zero or negative.');
        }
        $this->height = $height;
    }

    public function getSurfaceArea()
    {
        $surfaceArea = (2 * $this->length * $this->width) + (2 * $this->length * $this->height) + (2 * $this->height * $this->width);

        return number_format($surfaceArea, 2, '.', '');
    }

    public function getLateralSurfaceArea()
    {
        $lateralSurfaceArea = (2 * $this->length * $this->height) + (2 * $this->height * $this->width);

        return number_format($lateralSurfaceArea, 2, '.', '');
    }

    public function getVolume()
    {
        $volume = $this->length * $this->width * $this->height;

        return number_format($volume, 2, '.', '');
    }
}

$length = (float) fgets(STDIN);
$width = (float) fgets(STDIN);
$height = (float) fgets(STDIN);

try {
    $box = new Box($length, $width, $height);

    $surfaceArea = $box->getSurfaceArea();
    $lateralSurfaceArea = $box->getLateralSurfaceArea();
    $volume = $box->getVolume();

    echo "Surface Area - $surfaceArea" . PHP_EOL;
    echo "Lateral Surface Area - $lateralSurfaceArea" . PHP_EOL;
    echo "Volume - $volume";
} catch (Exception $e) {
    echo $e->getMessage();
}

?>

