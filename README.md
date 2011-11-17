##flickholdr##

Flickholdr generates images on the fly, to be used as placeholders in html layouts.

##requirements##
To install flickholdr on your server, you will need to be running PHP5.3 with the GD library. Nowadays, it is included by default, so you shouldn't have a problem. Just make sure it is activated.

Also install/activate the rewrite module (mod_rewrite), which allows for clean image urls

##install##

Copy these files to a publicly accessible folder on your web server. Edit application/config/config.php and change $config['base_url'] to the url you will use to access fyour flickholdr installation. Open the corresponding url in your browser. You should be greeted with the home page, similar to the one curently viewable at http://flickholdr.com
