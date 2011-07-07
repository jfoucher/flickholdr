<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('flickr_model');
        $this->cache_time=365*24*5; //cache time in hours

        if (!empty($_POST) && isset($_POST['width']) && isset($_POST['height'])){
            $tags=(isset($_POST['tags']) ? '/'.$_POST['tags'] : '');
            redirect('/'.$_POST['width'].'/'.$_POST['height'].$tags);
        }

	}

	function index()
	{
        //$this->output->enable_profiler(TRUE);
        $width=$this->uri->segment(1);
        $height=$this->uri->segment(2);
        $tags=$this->uri->segment(3);
        $bw=$this->uri->segment(4);
        $offset=$this->uri->segment(5);
        if ($tags=='bw' && !$bw){
            $bw=$tags;
            $tags='';
        }
        if(is_numeric($bw) && !$offset){
            $offset=$bw;
        }

        if(is_numeric($tags) && !$offset){
            $offset=$tags;
        }
        
        //if not requesting an image, show home page
        if((!$width && !$height) || !is_numeric($width) || !is_numeric($height) ){


            $this->home();
            //exit();
        }else{
            $this->benchmark->mark('image_start');
            $image=$this->_get_image($width,$height,$tags,$bw,$offset);
            $this->benchmark->mark('image_end');
            header("Expires: Wed, 23 June 2021 05:00:00 GMT");
            header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()-3600*24*365*2) . " GMT");
            header('Cache-control: max-age='. 24*3600*365 .', public');
            header('Content-Type: image/jpeg');
            echo file_get_contents($image);
        }
        //var_dump($images);
	}

    function home(){
        $this->output->enable_profiler(TRUE);
        $this->load->view("home");
    }

    function mock(){
        $this->load->view("mock");
    }
    function about(){
        $this->load->view("about");
    }
    function donate(){
        $this->load->view("donate");
    }

    function ajax($w,$h,$t='',$num=''){
        echo '<p id="closeImg">X</p><img src="/'.$w.'/'.$h.'/'.$t.'/'.$num.'" />';
    }

    function _get_image($width,$height,$tags,$bw,$offset){

        //if cache exists, return
        $tmp_path=FCPATH.'assets/img/tmp/'.md5($width.$height.$tags.$bw.$offset).'.jpg';
        $che=FCPATH.'assets/img/cache/'.md5($width.$height.$tags.$bw.$offset).'.jpg';


        if (is_file($che) && filemtime($che) > time() - 3600 * $this->cache_time){
            return base_url().'assets/img/cache/'.md5($width.$height.$tags.$bw.$offset).'.jpg';

        }elseif(is_file($che) && filemtime($che) < time() - 3600 * $this->cache_time){
            unlink($che);
        }

        //no chache, ask from flickr
        $i=0;
        $flickr_image=false;
        $this->benchmark->mark('flickr_img_loop_start');
        while(!$flickr_image){
            $flickr_image=$this->_get_from_flickr($width,$height,$tags);
            if ($i>3){
                $flickr_image=$this->_get_from_flickr($width,$height);
                //break;
            }
            $i++;
        }
        $this->benchmark->mark('flickr_img_loop_end');
        $image=$flickr_image->source;

        $img_w=$flickr_image->width;
        $img_h=$flickr_image->height;



        //got first image biggger than requested
        //save image locally
        $this->benchmark->mark('scale_image_start');
        $this->benchmark->mark('file_get_contents_start');
        $img=file_get_contents($image);
        $this->benchmark->mark('file_get_contents_end');

        $f=fopen($tmp_path,'w+');
        $this->benchmark->mark('fwrite_start');
        fwrite($f,$img);
        $this->benchmark->mark('fwrite_end');
        //scale

        $config['image_library'] = 'gd2';
        $config['source_image'] = $tmp_path;
        $config['quality']="65%";

        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $che;

        $config['master_dim']=$this->_find_master_dim($width,$height,$img_w,$img_h);


        $this->load->library('image_lib', $config);
        $this->benchmark->mark('resize_start');
        $this->image_lib->resize();
        $this->benchmark->mark('resize_end');

        //crop
        //get_new image size
        $this->benchmark->mark('scale_image_end');
        $this->benchmark->mark('crop_image_start');
        $new_size=$this->_find_new_dims($width,$height,$img_w,$img_h);

        $cfg['image_library'] = 'gd2';
        $cfg['source_image'] = $che;
        $cfg['new_image'] = $che;
        //$cfg['source_image'] = $tmp_path;
        $cfg['x_axis'] = ($new_size['width']-$width)/2;
        $cfg['y_axis'] = ($new_size['height']-$height)/2;
        $cfg['width'] = $width;
        $cfg['height'] = $height;
        $cfg['maintain_ratio'] = false;


        $this->image_lib->initialize($cfg);

        if ( ! $this->image_lib->crop())
        {
            echo $this->image_lib->display_errors();
        }

        #TODO: author watermark if applicable
        $this->benchmark->mark('crop_image_end');
        $this->benchmark->mark('watermark_image_start');

        $config['source_image'] = $che;
        $config['wm_text'] = '© '.$flickr_image->owner;
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = FCPATH.'assets/fonts/Aller_Lt.ttf';
        $config['wm_font_size'] = ($width/16>12 ? 12 : $width/16);
        $config['wm_font_color'] = 'ffffff';
        $config['wm_shadow_color'] = '000000';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'left';
        $config['wm_padding'] = '20';
        $config['wm_vrt_offset']='-20';
        $config['wm_hor_offset']='-15';
        $config['wm_shadow_distance']='1';
        $this->image_lib->initialize($config);

        $this->image_lib->watermark();
        $this->benchmark->mark('watermark_image_end');
        if ($bw=='bw'){
            $this->benchmark->mark('bw_image_start');
            if ( ! $this->image_lib->greyscale())
            {
                echo $this->image_lib->display_errors();
            }
            $this->benchmark->mark('bw_image_end');
        }

        if (is_file($tmp_path))
            unlink($tmp_path);
        return base_url().'assets/img/cache/'.md5($width.$height.$tags.$bw.$offset).'.jpg';
    }

    function _get_from_flickr($width,$height,$tags=''){

        $image=$this->flickr_model->search($tags,$width,$height);
        if (!empty($image)){

            return $image;

        }
        return false;
    }

    function _find_master_dim($width,$height,$img_w,$img_h){
        if ($width/$img_w > $height/$img_h)
            return 'width';
        else
            return 'height';


    }

    function _find_new_dims($width,$height,$img_w,$img_h){
        if ($width/$img_w > $height/$img_h)
            return array('width'=>$width,'height'=>$img_h*$width/$img_w);
        else
            return array('width'=>$img_w*$height/$img_h,'height'=>$height);


    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */