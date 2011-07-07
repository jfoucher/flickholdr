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

    function search($tags,$width,$height,$offset=1){


        $page=floor($offset/20)+1;

        $tag_mode='all';
        $tags=urlencode($tags);
        $sort='interestingness-desc';
        $media='photo';
        $license='4,2,1,5,7';
        $url="http://api.flickr.com/services/rest/?method=flickr.photos.search&per_page=20&page=$page&api_key=$this->api_key&tags=$tags&sort=$sort&media=$media&license=$license&format=$this->format&tag_mode=$tag_mode&extras=owner_nam,o_dims,url_o";
        $res=file_get_contents($url);
        $images = json_decode($this->_clean($res));

        //exit();
        $images=$images->photos->photo;
        shuffle($images);
        foreach($images as $image){
            if ((isset($image->o_width) && $image->o_height) && ($image->o_width>=$width && $image->o_height>=$height)){
                $image->width=$image->o_width;
                $image->height=$image->o_height;
                $image->source=$image->url_o;
                if (isset($image->ownername))
                    $image->owner=$image->ownername;
                else{
                    $image->owner=$this->_get_owner($image->owner);
                }
                //var_dump($image);
                //flush();
                return $image;
            }

        }
    }

    private function _get_owner($user_id){
        $url="http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key=$this->api_key&user_id=$user_id&format=json";
        $res=file_get_contents($url);

        $user = json_decode($this->_clean($res));
        //var_dump($user);
        return (isset($user->person->realname->_content) ? $user->person->realname->_content : $user->person->username->_content);
    }
    private function _clean($res){
        return str_ireplace('jsonFlickrApi(','',rtrim($res,')'));
    }

}