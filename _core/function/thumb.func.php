<?php
@ini_set('memory_limit', '128M');

function ResizeWidth($picture,$smallfile,$rewidth)
{
    $picsize=getimagesize($picture);

	if ($picsize[0] <= $rewidth)
	{
		copy($picture,$smallfile);
	}
	else {

		$reheight = intval(($rewidth * $picsize[1]) / $picsize[0]);
		if($picsize[0]>$rewidth)
		{
			$width=$picsize[0]-$rewidth;
			$aa=$width/$picsize[0];
			$picsize[0]=intval($picsize[0]-$picsize[0]*$aa);
			$picsize[1]=intval($picsize[1]-$picsize[1]*$aa);
		}
		if($picsize[1]>$reheight)
		{
			$height=$picsize[1]-$reheight;
			$bb=$heigh/$picsize[1];
			$picsize[0]=intval($picsize[0]-$picsize[0]*$bb);
			$picsize[1]=intval($picsize[1]-$picsize[1]*$bb);
		}
		if($picsize[2]==1)
		{
			//@header("Content-Type: imgage/gif");
			$dstimg=ImageCreatetruecolor($rewidth,$reheight);
			$srcimg=@ImageCreateFromGIF($picture);
			ImageCopyResized($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
			Imagegif($dstimg,$smallfile,100);
		}
		elseif($picsize[2]==2)
		{
			//@header("Content-Type: images/jpeg");
			$dstimg=ImageCreatetruecolor($rewidth,$reheight);
			$srcimg=ImageCreateFromJPEG($picture);
			imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
			Imagejpeg($dstimg,$smallfile,100);
		}
		elseif($picsize[2]==3)
		{
			//@header("Content-Type: images/png");
      $srcimg=ImageCreateFromPNG($picture);
      $dstimg = imagecreatetruecolor($rewidth, $reheight);
      imagealphablending($dstimg, false);
      imagesavealpha($dstimg,true);
      $transparent = imagecolorallocatealpha($dstimg, 255, 255, 255, 127);
      imagefilledrectangle($dstimg, 0, 0, $rewidth, $reheight, $transparent);
      imagecopyresampled($dstimg, $srcimg, 0, 0, 0, 0, $rewidth, $reheight, ImageSX($srcimg),ImageSY($srcimg));
      Imagepng($dstimg,$smallfile,0);

		}
		@ImageDestroy($dstimg);
		@ImageDestroy($srcimg);
	}
}

function ResizeHeight($picture,$smallfile,$reheight)
{
    $picsize=getimagesize($picture);

	if ($picsize[1] <= $reheight)
	{
		copy($picture,$smallfile);
	}
	else {

		$rewidth = intval(($reheight * $picsize[0]) / $picsize[1]);
		if($picsize[0]>$rewidth)
		{
			$width=$picsize[0]-$rewidth;
			$aa=$width/$picsize[0];
			$picsize[0]=intval($picsize[0]-$picsize[0]*$aa);
			$picsize[1]=intval($picsize[1]-$picsize[1]*$aa);
		}
		if($picsize[1]>$reheight)
		{
			$height=$picsize[1]-$reheight;
			$bb=$heigh/$picsize[1];
			$picsize[0]=intval($picsize[0]-$picsize[0]*$bb);
			$picsize[1]=intval($picsize[1]-$picsize[1]*$bb);
		}
		if($picsize[2]==1)
		{
			//@header("Content-Type: imgage/gif");
			$dstimg=ImageCreatetruecolor($rewidth,$reheight);
			$srcimg=@ImageCreateFromGIF($picture);
			ImageCopyResized($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
			Imagegif($dstimg,$smallfile,100);
		}
		elseif($picsize[2]==2)
		{
			//@header("Content-Type: images/jpeg");
			$dstimg=ImageCreatetruecolor($rewidth,$reheight);
			$srcimg=ImageCreateFromJPEG($picture);
			imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
			Imagejpeg($dstimg,$smallfile,100);
		}
		elseif($picsize[2]==3)
		{
			//@header("Content-Type: images/png");
			$srcimg=ImageCreateFromPNG($picture);
			$dstimg=imagecreate($rewidth,$reheight);
			$black = imagecolorallocate($dstimg, 0x00, 0x00, 0x00);
			$white = imagecolorallocate($dstimg, 0xFF, 0xFF, 0xFF);
			$magenta = imagecolorallocate($dstimg, 0xFF, 0x00, 0xFF);
			imagecolortransparent($dstimg,$black);
			imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
			Imagepng($dstimg,$smallfile,0);
		}
		@ImageDestroy($dstimg);
		@ImageDestroy($srcimg);
	}
}

function ResizeWidthHeight($picture,$smallfile,$rewidth,$reheight)
{
    $picsize=getimagesize($picture);

    if($picsize[2]==1)
	{
		//@header("Content-Type: imgage/gif");
		$dstimg=ImageCreatetruecolor($rewidth,$reheight);
		$srcimg=@ImageCreateFromGIF($picture);
		ImageCopyResized($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
		Imagegif($dstimg,$smallfile,100);
    }
    elseif($picsize[2]==2)
	{
		//@header("Content-Type: images/jpeg");
		$dstimg=ImageCreatetruecolor($rewidth,$reheight);
		$srcimg=ImageCreateFromJPEG($picture);
		imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
		Imagejpeg($dstimg,$smallfile,100);
    }
    elseif($picsize[2]==3)
	{
		//@header("Content-Type: images/png");
		$srcimg=ImageCreateFromPNG($picture);
		$dstimg=imagecreate($rewidth,$reheight);
		$black = imagecolorallocate($dstimg, 0x00, 0x00, 0x00);
		$white = imagecolorallocate($dstimg, 0xFF, 0xFF, 0xFF);
		$magenta = imagecolorallocate($dstimg, 0xFF, 0x00, 0xFF);
		imagecolortransparent($dstimg,$black);
		imagecopyresampled($dstimg, $srcimg,0,0,0,0,$rewidth,$reheight,ImageSX($srcimg),ImageSY($srcimg));
		Imagepng($dstimg,$smallfile,0);
    }
    @ImageDestroy($dstimg);
    @ImageDestroy($srcimg);
}

function overlay($backpic,$overpic,$x,$y,$w,$h)
{
    $backsize=getimagesize($backpic);
    $oversize=getimagesize($overpic);

	if ($backsize[2] == 1)
	{
		$dstimg=ImageCreateFromGIF($backpic);
	}
	elseif ($backsize[2] == 2)
	{
		$dstimg=ImageCreateFromJPEG($backpic);
	}
	elseif ($backsize[2] == 3)
	{
		$dstimg=ImageCreateFromPNG($backpic);
	}
	if ($oversize[2] == 1)
	{
		$srcimg=ImageCreateFromGIF($overpic);
	}
	elseif ($oversize[2] == 2)
	{
		$srcimg=ImageCreateFromJPEG($overpic);
	}
	elseif ($oversize[2] == 3)
	{
		$srcimg=ImageCreateFromPNG($overpic);
	}
	Imagecopymerge($dstimg, $srcimg, $x, $y, 0, 0, $w, $h, 100);
	if ($backsize[2] == 1)
	{
		Imagegif($dstimg,$backpic,100);
	}
	elseif ($backsize[2] == 2)
	{
		Imagejpeg($dstimg,$backpic,100);
	}
	elseif ($backsize[2] == 3)
	{
		Imagepng($dstimg,$backpic,0);
	}
    @ImageDestroy($dstimg);
    @ImageDestroy($srcimg);
}

// 이미지 가로/세로 교정
function exifRotate($picture)
{
	$exifData = @exif_read_data($picture);
	if($exifData['Orientation'] == 6) {
		$degree = 270; // 시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨
	}
	else if($exifData['Orientation'] == 8) {
		$degree = 90; // 반시계방향으로 90도 돌려줘야 정상
	}
	else if($exifData['Orientation'] == 3) {
		$degree = 180;
	}
	if($degree) {
		if($exifData['FileType'] == 1) {
			$source = imagecreatefromgif($picture);
			$source = imagerotate ($source , $degree, 0);
			imagegif($source, $picture);
		}
		else if($exifData['FileType'] == 2) {
			$source = imagecreatefromjpeg($picture);
			$source = imagerotate ($source , $degree, 0);
			imagejpeg($source, $picture);
		}
		else if($exifData['FileType'] == 3) {
			$source = imagecreatefrompng($picture);
			$source = imagerotate ($source , $degree, 0);
			imagepng($source, $picture);
		}
    @ImageDestroy($source);
    @ImageDestroy($source);
	}
}
?>
