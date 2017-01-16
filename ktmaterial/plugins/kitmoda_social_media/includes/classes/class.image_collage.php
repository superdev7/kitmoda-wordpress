<?php

class ksm_imageCollage {
    
    
    
    public $collage_width,
            $collage_height,
            $offY,
            $yield,
            $lastAnalyzedIndex,
            $buildingRow,
            $entries,
            $rowHeight,
            $margin,
            $justifyThreshold,
            $maxRowHeight = 0,
            $name,
            $collage_image;
    
    
    function __construct($args) {
        
        
        $this->buildingRow = new stdClass();
        $this->buildingRow->entriesBuff = array();
        $this->buildingRow->width = 0;
        $this->buildingRow->aspectRatio = 0;
        $this->lastAnalyzedIndex = -1;
        $this->yield = new stdClass();
                
        $this->yield->every =  2; /* do a flush every context.yield.every flushes (
                  * must be greater than 1, else the analyzeImages will loop */
        $this->yield->flushed = 0; //flushed rows without a yield
          
        $this->collage_width = $args['width'];
        $this->margin = $args['margins'];
        $this->offY = $args['margins'];
        $this->name = $args['name'];
        
        $this->rowHeight = 196;
        
        $this->justifyThreshold = 0.75;
        
        $this->rows = array();
        
        
        $entries = array();
        foreach($args['entries'] as $e) {
            $e_metadata = get_post_meta($e->ID, '_wp_attachment_metadata');
            $e_metadata = $e_metadata[0];
            $ent = new stdClass();
            $ent->ID = $e->ID;
            $ent->width = $e_metadata['width'];
            $ent->height = $e_metadata['height'];
            $ent->file = get_attached_file( $e->ID );
            $entries[] = $ent;
        }
        $this->entries = $entries;
        if (count($this->entries) === 0) return;
        
        
        
        $this->analyzeImages();
        
        $this->generate();
        
    }
    
    private function analyzeImages() {
        
        
        for ($i = $this->lastAnalyzedIndex + 1; $i < count($this->entries); $i++) {
            $entry = $this->entries[$i];
            $isLastRow = $i >= count($this->entries) - 1 ? true : false;
            $availableWidth = $this->collage_width  - (
                               (count($this->buildingRow->entriesBuff) - 1) * $this->margins);
            $imgAspectRatio = $entry->width / $entry->height;
            
            if ($availableWidth / ($this->buildingRow->aspectRatio + $imgAspectRatio) < $this->rowHeight) {
                $this->flushRow(isLastRow);
            }
            $this->buildingRow->entriesBuff[] = $entry;
            $this->buildingRow->aspectRatio += $imgAspectRatio;
            $this->buildingRow->width += $imgAspectRatio * $this->rowHeight;
            $this->lastAnalyzedIndex = $i;
        }

        // Last row flush (the row is not full)
        if (count($this->buildingRow->entriesBuff) > 0) {
            $this->flushRow(true);
        }

    }
    
    
    
    private function flushRow($isLastRow=false) {
        
        $offX = $this->margin;
        $buildingRowRes = $this->prepareBuildingRow($isLastRow);
        $minHeight = $buildingRowRes->minHeight;
      

      //if (settings.maxRowHeight > 0 && settings.maxRowHeight < minHeight)
      //  minHeight = settings.maxRowHeight;
      //else 
      if ((1.5 * $this->rowHeight) < $minHeight) {
          $minHeight = 1.5 * $this->rowHeight;
      }
      
      
      
      for ($i = 0; $i < count($this->buildingRow->entriesBuff); $i++) {
          $entry = $this->buildingRow->entriesBuff[$i];
          $entry->x = $offX;
          $entry->y = $this->offY;
          $this->rows[$entry->ID] = $entry;
        
        //displayEntry($entry, offX, context.offY, $image.data('jg.jimgw'), 
        //             $image.data('jg.jimgh'), $image.data('jg.jimgh'), context);
        $offX += $entry->new_width + $this->margin;
      }
      

      $this->collage_height = $this->offY + $minHeight + $this->margin;
      //context.$gallery.height(context.offY + minHeight + settings.margins + 
      //  (context.spinner.active ? context.spinner.$el.innerHeight() : 0)
      //);

      if (!$isLastRow || ($minHeight <= $this->rowHeight && $buildingRowRes->justify)) {
        
        $this->offY += $minHeight + $this->margin;

        
        $this->buildingRow->entriesBuff = array();
        $this->buildingRow->aspectRatio = 0;
        $this->buildingRow->width = 0;
        
      }
    }
    
    
    
    
    private function prepareBuildingRow($isLastRow=false) {
      
      $justify = true;
      $minHeight = 0;
      $availableWidth = $this->collage_width - (
                            (count($this->buildingRow->entriesBuff) + 1) * $this->margin);
      $rowHeight = $availableWidth / $this->buildingRow->aspectRatio;
      $justificable = $this->buildingRow->width / $availableWidth > $this->justifyThreshold;

      
      if ($isLastRow && !$justificable) $justify = false;

      for ($i = 0; $i < count($this->buildingRow->entriesBuff); $i++) {
          $image = $this->buildingRow->entriesBuff[$i];
          $imgAspectRatio = $image->width / $image->height;
          
          if ($justify) {
              $newImgW = ($i === count($this->buildingRow->entriesBuff) - 1) ? $availableWidth 
                      : $rowHeight * $imgAspectRatio;
              $newImgH = $rowHeight;
          } else {
              $newImgW = $this->rowHeight * $imgAspectRatio;
              $newImgH = $this->rowHeight;
          }
        
        
        

        $availableWidth -= round($newImgW);
        $image->new_width = round($newImgW);
        $image->new_height = ceil($newImgH);
        if ($i === 0 || $minHeight > $newImgH) {
            $minHeight = $newImgH;
        }
        
        $this->buildingRow->entriesBuff[$i] = $image;
        //pr($image);
      }

      
      return ((object) array('minHeight'=> $minHeight, 'justify'=> $justify));
    }
    
    
    





    private function generate() {

        
        $canvas_width = $this->collage_width;
        $canvas_height = $this->collage_height;
        $image_canvas = imagecreatetruecolor($canvas_width, $canvas_height);
        
        //imagecolortransparent($image_canvas, imagecolorallocate($image_canvas, 0, 0, 0));

        imagefill($image_canvas, 0, 0, imagecolorallocate($image_canvas, 255, 255, 255));
        
        $border = 1;
        
        foreach($this->rows as $img) {
            $pathinfo = pathinfo($img->file);
            $src_img = '';
            if($pathinfo['extension'] == 'jpg' || $pathinfo['extension'] == 'jpeg') {
                $src_img = imagecreatefromjpeg($img->file);
            } else if($pathinfo['extension'] == 'png') {
                $src_img = imagecreatefrompng($img->file);
            }
            
            
            
            if($src_img) {

                $img_adj_width= $img->new_width+(2*$border);
                $img_adj_height= $img->new_height+(2*$border);
                $imageResized = imagecreatetruecolor($img_adj_width, $img_adj_height);
                
                

                $border_color = imagecolorallocate($imageResized, 115, 115, 115);
                imagefilledrectangle($imageResized,0,0,$img_adj_width,$img_adj_height,$border_color);
                
                
                
                
                
                
                imagecopyresampled($imageResized, $src_img, $border, $border, 0, 0, $img->new_width, $img->new_height, imagesx($src_img), imagesy($src_img));
                //$this->imageCreateCorners($src_img, 9);
                imagecopy($image_canvas, $imageResized, $img->x, $img->y, 0, 0, $img_adj_width, $img_adj_height);
                
                imagedestroy($src_img);
                
                //
                //imagejpeg($imageResized, null, 100);
                //exit;

            }

            

        }

        $upload_dir = wp_upload_dir();
        $path = $upload_dir['path'] . '/' . $this->name.'.jpg';
        
        imagejpeg($image_canvas, $path, 100);
        $this->collage_image = $upload_dir['url'] . '/' . $this->name.'.jpg';


    }
    
    
    
    
    
    private function imageCreateCorners($src, $radius) {
        $w = imagesx($src);
        $h = imagesy($src);
        
        if ($src) {
            
            $q = 10; # change this if you want
            $radius *= $q;

      
            do {
              $r = rand(0, 255);
              $g = rand(0, 255);
              $b = rand(0, 255);
              }
            while (imagecolorexact($src, $r, $g, $b) < 0);

            $nw = $w*$q;
            $nh = $h*$q;

            $img = imagecreatetruecolor($nw, $nh);
            $alphacolor = imagecolorallocatealpha($img, $r, $g, $b, 127);
            imagealphablending($img, false);
            imagesavealpha($img, true);
            imagefilledrectangle($img, 0, 0, $nw, $nh, $alphacolor);

            imagefill($img, 0, 0, $alphacolor);
            imagecopyresampled($img, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);

            imagearc($img, $radius-1, $radius-1, $radius*2, $radius*2, 180, 270, $alphacolor);
            imagefilltoborder($img, 0, 0, $alphacolor, $alphacolor);
            imagearc($img, $nw-$radius, $radius-1, $radius*2, $radius*2, 270, 0, $alphacolor);
            imagefilltoborder($img, $nw-1, 0, $alphacolor, $alphacolor);
            imagearc($img, $radius-1, $nh-$radius, $radius*2, $radius*2, 90, 180, $alphacolor);
            imagefilltoborder($img, 0, $nh-1, $alphacolor, $alphacolor);
            imagearc($img, $nw-$radius, $nh-$radius, $radius*2, $radius*2, 0, 90, $alphacolor);
            imagefilltoborder($img, $nw-1, $nh-1, $alphacolor, $alphacolor);
            imagealphablending($img, true);
            imagecolortransparent($img, $alphacolor);

            # resize image down
            $dest = imagecreatetruecolor($w, $h);
            imagealphablending($dest, false);
            imagesavealpha($dest, true);
            imagefilledrectangle($dest, 0, 0, $w, $h, $alphacolor);
            imagecopyresampled($dest, $img, 0, 0, 0, 0, $w, $h, $nw, $nh);

            # output image
            $res = $dest;
            
            $name = 'G:\earth'.  rand(1111, 99999).'.jpg';
            imagejpeg($src, $name, 100);
            
            //imagedestroy($src);
            imagedestroy($img);
      }

    return $res;
    }

    
    
    
    
    
}

?>