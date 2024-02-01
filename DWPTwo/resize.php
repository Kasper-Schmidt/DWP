<?php 

class Resize{
    protected $image; //Protected mens that only this and it's children can access it
    protected $image_type;

    public function load($filename) {
        $image_info = getimagesize($filename); //returns file info, height and width and more, check online

        $this->image_type = $image_info[2];

        if($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        } 
    }

    public function save($filename, $imageType = IMAGETYPE_JPEG, $compression = 100) {
        if($imageType == IMAGETYPE_JPEG){
            imagejpeg($this->image, $filename, $compression);
        } elseif ($imageType == IMAGETYPE_GIF){
            imagegif($this->image, $filename);
        } elseif ($imageType == IMAGETYPE_PNG){
            imagepng($this->image, $filename);
        }
    }



    protected function getWidth(){
        return imagesx($this->image);
    }

    protected function getHeight(){
        return imagesy($this->image);
    }




    // resize by Height
    public function resizeToHeight($height){
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    // resize by Width
    public function resizeToWidth($width){
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize($width, $height);
    }

    // scale the image by width and height
    public function resizeToScale($scale){
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getHeight() * $scale / 100;
        $this->resize($width, $height);
    }
  



    public function resize($width, $height){
        $newImage = imagecreatetruecolor($width, $height);
                //destination, source, ??, destination width, destination height, ??, ??
        imagecopyresampled($newImage , $this->image, 0,0,0,0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $newImage;
    }
}






function doStuff($value, $sql){
// Assuming $db is your database connection
$result = $sql->query("SELECT * FROM Comment");

while ($row = $result->fetch_assoc()) {
    // Lav en ny Resize-instans for hver række
    $size = new Resize();
    
    // Antager, at 'URL' er en kolonne i din tabel Comment
    $url = $row['URL'];
    
    // Brug dine Resize-funktioner på hver URL
    $size->load($row['URL']);
    $size->resizeToWidth($value);
    // Du kan tilpasse dette efter dine behov, f.eks. ved at ændre bredden og højden dynamisk.
    
    // Gem det ændrede billede til samme URL (du kan også gemme det et andet sted, afhængigt af dine krav)
    $size->save($url);
}

}
doStuff(200, $sql);




/* 
function doStuff($value){
    $size = new Resize();
    $size->load("$row['URL']");
    $size->resizeToWidth($value);
    // $size->resizeToDimensions($width, $height);
    $size->save("$row['URL']");
}
doStuff(324); 
*/