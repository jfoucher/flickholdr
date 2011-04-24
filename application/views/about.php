<?php
$data=array('title'=>'About flickholdr');
$this->load->view('sub/head',$data)?>
<body>

	<div id="container">

		<div id="primary-content" role="main">
            <div id="left">
                <header id="header" class="about-header">
                    <h1><a href="/">flickhold<span class="lastr">r</span></a></h1>

                </header>
                <h2 id="about">About</h2>
                <p class="about">
                    I built this in <strike>five</strike> eleven hours, by the clock. I really liked <a href="http://placekitten.com">placekitten.com</a>,
                    but would not see myself using it on a client site.
                </p>
                <p class="about">
                    With this little app, you can get images from <a href="http://flickr.com">flickr</a> based on the tags you choose.
                    It's generally pretty accurate, so you should get images closely related to the subject matter
                    of the website you're building.
                </p>

                <p class="about">
                    The photos are pulled from <a href="http://flickr.com">flickr</a> using its <a href="http://www.flickr.com/services/api/flickr.photos.search.html">search api</a>,
                    searching only creative commons material, and watermarking them with the name of the author, to be
                    in accordance with the <a href="http://creativecommons.org/licenses/">creative commons licences</a>, which all require attribution
                </p>

                <p class="about">
                    <strong>New feature!</strong> In about 1 hour I got this new feature working : by appending `bw` to
                    the image url, you're getting an image converted to black and white, for those cases where you need
                    to tone down slightly your placeholders.<br />
                    B&W with tags: <a href="<?php echo base_url()?>500/700/portrait/bw"><?php echo base_url()?>500/700/portrait/bw</a><br />
                    B&W without tags: <a href="<?php echo base_url()?>400/500/bw"><?php echo base_url()?>400/500/bw</a>
                </p>

                <p class="about">
                    <strong>New feature!</strong> Append a number to any url to get different images, even if they are the same size and tags.<br />
                    This image: <a href="<?php echo base_url()?>500/700/portrait/1"><?php echo base_url()?>500/700/portrait/1</a><br />
                    is different to this one: <a href="<?php echo base_url()?>500/700/portrait/2"><?php echo base_url()?>500/700/portrait/2</a>
                </p>
                <p class="about">
                    <strong>New feature!</strong> I just changed the author copyright watermark to be semi transparent. I think the images look much better that way.
                </p>

            </div>
			

            <?php $this->load->view('sub/image_grid')?>
			
		</div><!-- /#primary-content -->

<?php $this->load->view('sub/footer')?>