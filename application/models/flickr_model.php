<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jonathan
 * Date: 3/4/11
 * Time: 3:50 PM
 * To change this template use File | Settings | File Templates.
 */
 
class Flickr_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->api_key='23f847df130df11da00349276579f9be';
        $this->format='json';
    }

    function search($tags,$width,$height){

        $tag_mode='all';
        $tags=urlencode($tags);
        $sort='interestingness-desc';
        $media='photo';
        $license='4,2,1,5,7';
        $url="http://api.flickr.com/services/rest/?method=flickr.photos.search&per_page=1&page=1&api_key=$this->api_key&tags=$tags&sort=$sort&media=$media&license=$license&format=$this->format&tag_mode=$tag_mode";
        //echo $url;
        $f=file_get_contents($url);
        //var_dump($f);
        $r1=json_decode($this->_clean($f));
        //var_dump($r1);
        $total=($r1->photos->pages > 50 ? 50 : $r1->photos->pages);
        if ($total==0)
            return false;
        $page=rand(1,$total);

        //echo $page;
        //flush();
        
        $res=file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.search&per_page=1&page=$page&api_key=$this->api_key&tags=$tags&sort=$sort&media=$media&license=$license&format=$this->format&tag_mode=$tag_mode");

        $images = json_decode($this->_clean($res));
        $data=array();
        foreach($images->photos->photo as $image){
            $image->sizes=$this->_get_sizes($image)->sizes;
            //var_dump($this->_get_author($image));

            foreach($image->sizes->size as $size){
                if ($size->width>=$width && $size->height>=$height){
                    $image->owner=$this->_get_author($image)->photo->owner;
                    //$data[]=$image;
                    return $image;
                }
            }

        }
        //var_dump($data);
        //return $data;
    }

    private function _get_sizes($photo){
        $res=file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getSizes&api_key=$this->api_key&format=$this->format&photo_id=".$photo->id);
        return json_decode($this->_clean($res));
    }

    private function _get_author($photo){
        $res=file_get_contents("http://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key=$this->api_key&format=$this->format&photo_id=".$photo->id);
        return json_decode($this->_clean($res));
    }

    private function _clean($res){
        return str_ireplace('jsonFlickrApi(','',rtrim($res,')'));
    }

}