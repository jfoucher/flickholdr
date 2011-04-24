<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Image Manipulation class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Image_lib
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/image_lib.html
 */
class MY_Image_lib extends CI_Image_lib{

	function greyscale(){
        
        //  Create the image handle
		if ( ! ($src_img = $this->image_create_gd()))
		{
			return FALSE;
		}
        if ( ! ($dst_img = $this->image_create_gd()))
		{
			return FALSE;
		}
        for ($x=0;$x<256;$x++) {

            $palette[$x] = imagecolorallocate($dst_img,$x,$x,$x);

        }
        for ($y=0;$y<$this->height;$y++)
        {
            for ($x=0;$x<$this->width;$x++)
            {
                $rgb = imagecolorat($src_img,$x,$y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                //This is where we actually use yiq to modify our rbg values, and then convert them to our grayscale palette
                $val = (($r*0.299)+($g*0.587)+($b*0.114));
                imagesetpixel($dst_img,$x,$y,$palette[$val]);
            }
        }

        //  Save the Image
		if ($this->dynamic_output == TRUE)
		{
			$this->image_display_gd($dst_img);
		}
		else
		{
			// Or save it
			if ( ! $this->image_save_gd($dst_img))
			{
				return FALSE;
			}
		}

		//  Kill the file handles
		imagedestroy($dst_img);
		imagedestroy($src_img);

    }

}
// END Image_lib Class

/* End of file Image_lib.php */
/* Location: ./system/libraries/Image_lib.php */