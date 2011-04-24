<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Image extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('flickr_model');
        $this->cache_time=365*24; //cache time in hours
        if (!empty($_POST) && isset($_POST['width']) && isset($_POST['height'])){
            $tags=(isset($_POST['tags']) ? '/'.$_POST['tags'] : '');
            redirect('/'.$_POST['width'].'/'.$_POST['height'].$tags);
        }

	}

	function index()
	{
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
            $image=$this->_get_image($width,$height,$tags,$bw,$offset);

            header('Content-Type: image/jpeg');
            echo file_get_contents($image);
        }
        //var_dump($images);
	}

    function home(){
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
        while(!$flickr_image){
            $flickr_image=$this->_get_from_flickr($width,$height,$tags);
            if ($i>3){
                $flickr_image=$this->_get_from_flickr($width,$height);
                //break;
            }
            $i++;
        }
        $image=$flickr_image->source;

        $img_w=$flickr_image->width;
        $img_h=$flickr_image->height;



        //got first image biggger than requested
        //save image locally
        $img=file_get_contents($image);

        $f=fopen($tmp_path,'w+');
        fwrite($f,$img);
        //scale

        $config['image_library'] = 'gd2';
        $config['source_image'] = $tmp_path;

        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        $config['new_image'] = $che;
        $config['master_dim']=$this->_find_master_dim($width,$height,$img_w,$img_h);

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();

        //crop
        //get_new image size

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

        $config['source_image'] = $che;
        $config['wm_text'] = '© '.($flickr_image->owner->realname ? $flickr_image->owner->realname : $flickr_image->owner->username);
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

        if ($bw=='bw'){
            if ( ! $this->image_lib->greyscale())
            {
                echo $this->image_lib->display_errors();
            }
        }

        if (is_file($tmp_path))
            unlink($tmp_path);

        return base_url().'assets/img/cache/'.md5($width.$height.$tags.$bw.$offset).'.jpg';
    }

    function _get_from_flickr($width,$height,$tags=''){

        $image=$this->flickr_model->search($tags,$width,$height);
        if (!empty($image)){

            foreach($image->sizes->size as $size){
                if ($size->width>=$width && $size->height>=$height){
                    $size->owner=$image->owner;
                    return $size;
                }
            }
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