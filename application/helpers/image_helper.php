<?php

function image_thumb($image_path, $height, $width)
{
    // Get the CodeIgniter super object
    $CI =& get_instance();

    // Path to image thumbnail
    $image_thumb = dirname($image_path) . '/' . $height . '_' . $width . '.jpg';

    if( ! file_exists($image_thumb))
    {
        // LOAD LIBRARY
        $CI->load->library('image_lib');

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize($config);
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return '<img src="' . dirname($_SERVER['SCRIPT_NAME']) . '/' . $image_thumb . '" />';
}


function ImageCR($source, $crop = null, $scale = null, $destination = null)
{
    $source = @ImageCreateFromString(@file_get_contents($source));

    if (is_resource($source) === true)
    {
        $size = array(ImageSX($source), ImageSY($source));

        if (isset($crop) === true)
        {
                $crop = array_filter(explode('/', $crop), 'is_numeric');

                if (count($crop) == 2)
                {
                        $crop = array($size[0] / $size[1], $crop[0] / $crop[1]);

                        if ($crop[0] > $crop[1])
                        {
                                $size[0] = $size[1] * $crop[1];
                        }

                        else if ($crop[0] < $crop[1])
                        {
                                $size[1] = $size[0] / $crop[1];
                        }

                        $crop = array(ImageSX($source) - $size[0], ImageSY($source) - $size[1]);
                }

                else
                {
                        $crop = array(0, 0);
                }
        }

        else
        {
                $crop = array(0, 0);
        }

        if (isset($scale) === true)
        {
                $scale = array_filter(explode('*', $scale), 'is_numeric');

                if (count($scale) >= 1)
                {
                        if (empty($scale[0]) === true)
                        {
                                $scale[0] = $scale[1] * $size[0] / $size[1];
                        }

                        else if (empty($scale[1]) === true)
                        {
                                $scale[1] = $scale[0] * $size[1] / $size[0];
                        }
                }

                else
                {
                        $scale = array($size[0], $size[1]);
                }
        }

        else
        {
                $scale = array($size[0], $size[1]);
        }

        $result = ImageCreateTrueColor($scale[0], $scale[1]);

        if (is_resource($result) === true)
        {
                ImageFill($result, 0, 0, IMG_COLOR_TRANSPARENT);
                ImageSaveAlpha($result, true);
                ImageAlphaBlending($result, true);

                if (ImageCopyResampled($result, $source, 0, 0, $crop[0] / 2, $crop[1] / 2, $scale[0], $scale[1], $size[0], $size[1]) === true)
                {
                        if (preg_match('~gif$~i', $destination) >= 1)
                        {
                                return ImageGIF($result, $destination);
                        }

                        else if (preg_match('~png$~i', $destination) >= 1)
                        {
                                return ImagePNG($result, $destination, 9);
                        }

                        else if (preg_match('~jpe?g$~i', $destination) >= 1)
                        {
                                return ImageJPEG($result, $destination, 90);
                        }
                }
        }
    }

	/*
	// resize to 400x400 px 
	ImageCR('path/to/sourceImg.jpg', null, '400*400', 'path/to/outputImg.jpg');
	
	// crop to a 1:1 ratio (square) from the center
	ImageCR('path/to/sourceImg.jpg', '1/1', null, 'path/to/outputImg.jpg');
	
	// crop to a 1:1 ratio (square) from the center AND resize to 400x400 px 
	ImageCR('path/to/sourceImg.jpg', '1/1', '400*400', 'path/to/outputImg.jpg');
	
	// crop to a 1:1 ratio (square) from the center AND resize to 400 px width AND maintain aspect ratio 
	ImageCR('path/to/sourceImg.jpg', '1/1', '400*', 'path/to/outputImg.jpg');
	
	// crop to a 1:1 ratio (square) from the center AND resize to 400 px height AND maintain aspect ratio 
	ImageCR('path/to/sourceImg.jpg', '1/1', '*400', 'path/to/outputImg.jpg');
	*/

    return false;
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */