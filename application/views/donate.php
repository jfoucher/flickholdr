<?php
$data=array('title'=>'About flickholdr');
$this->load->view('sub/head',$data)?>
<body>

	<div id="container">

		<div id="primary-content" role="main">
            <div id="left" class="donate">
                <header id="header" class="about-header">
                    <h1><a href="<?php echo base_url()?>" title="placeholder images from flickr, by tags">flickhold<span class="lastr">r</span></a></h1>

                </header>
                <h2 id="about">Donate</h2>
                <p class="donate">
                    <a href="<?php echo base_url()?>" title="placeholder images from flickr, by tags">Flickhold<span class="lastr">r</span></a>
                    is free for everyone, and you are actually encouraged to hotlink to the images here.

                </p>
                <p class="donate">
                    To cover my hosting costs, and if you use this service and like it, it would be really awesome if you could send a few dollars or euros my way!</p>

                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="X8XFZTRDM5RQW">
                Use paypal to <input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/fr_FR/i/scr/pixel.gif" width="1" height="1">
                </form>
                <p class="donate">
                    or visit my 
                    <a href="http://www.amazon.com/registry/wishlist/2N9GV4ZF8G61T?reveal=unpurchased&filter=all&sort=priority&layout=standard&x=7&y=10" title="Jonathan's Amazon Wishlist">
                    Amazon wishlist</a>
                </p>

                <h3 class="about">
                    Thanks!
                <h3>


            </div>
            <?php $this->load->view('sub/image_grid')?>
			
		</div><!-- /#primary-content -->

<?php $this->load->view('sub/footer')?>