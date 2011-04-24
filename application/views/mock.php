<?php
$data=array('title'=>'Placeholder images from flickr - flickholdr.com');
$this->load->view('sub/head',$data)?>
<body>

	<div id="container">

		<div id="primary-content" role="main">
            <div id="left">
                <header id="header">
                    <h1><a href="/">flickhold<span class="lastr">r</span></a></h1>
                    <p title="A last, useful placeholders!" class="description">
                        Get <strong>placeholders</strong> related to the site you are developing, by pulling images from
                        <a href="http://flickr.com" title="visit flickr.com">flick<span class="lastr">r</span></a> based on tags
                    </p>
                    <div id="share">
                    <ul>

                        <li><a href="http://www.delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=http%3A%2F%2Fflickholdr.com&amp;title=Image placeholders from Flickr" title="Save flickholdr on Delicious"><img src="assets/img/delicious.png" alt="logo de Delicious" /><span>Delicious</span></a></li>
                        <li><a href="http://www.facebook.com/share.php?u=http%3A%2F%2Fflickholdr.com" title="Share flickholdr on Facebook"><img src="assets/img/facebook.png" alt="logo de Facebook" /><span>Facebook</span></a></li>
                        <li><a href="http://digg.com/submit?phase=2&amp;url=http%3A%2F%2Fflickholdr.com" title="Share flickholdr.com on Digg"><img src="assets/img/digg.png" alt="logo de Digg" /><span>Digg</span></a></li>
                        <li><a href="http://twitter.com/share?url=http%3A%2F%2Fflickholdr.com&text=Get%20image%20placeholders%20from%20Flickr,%20by%20tags" title="Share flickholdr.com on Twitter"><img src="assets/img/twitter.png" alt="logo de Twitter" /><span>Twitter</span></a></li>
                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fflickholdr.com&title=Get%20image%20placeholders%20from%20Flickr,%20by%20tags" title="Share flickholdr.com on LinkedIn"><img src="assets/img/linkedin.png" alt="logo de LinkedIn" /><span>LinkedIn</span></a></li>
                        <li><a href="http://www.stumbleupon.com/submit?url=http%3A%2F%2Fwww.flickholdr.com" title="Share flickholdr.com on stumbleupon"><img src="assets/img/stumbleupon.png" alt="logo de stumbleupon" /><span>LinkedIn</span></a></li>

                    </ul>
                </div>

                </header>
                <h2 id="donate"><a href="/donate" title="If you like it click here!">donate</a></h2>
                <h2 id="howto">Use It</h2>
                <p class="links">

                    Like this: <a href="/200/300"><?php echo base_url()?>200/300</a><br />
                    or with tags: <a href="/200/300/sea,sun"><?php echo base_url()?>200/300/sea,sun</a><br />
                    <strong>New</strong>, in B&W: <a href="/200/300/sea,sun/bw"><?php echo base_url()?>200/300/sea,sun/bw</a><br />
                    <strong>New</strong>, offsets: <a href="/200/300/sea,sun/1"><?php echo base_url()?>200/300/sea,sun/1</a><br />



                </p>

                <p>
                    <?php echo form_open('/image',array("id"=>"generate"))?>
                        <fieldset>
                        <legend>Create your own</legend>
                        <ul>

                            <li>
                                <label for="width" id="width_label">Width</label>
                                http://flickholdr.com/<input type="text" name="width" id="width" placeholder="220" />/
                            </li>
                            <li>
                                <label for="height">Height</label>
                                <input type="text" name="height" id="height" placeholder="170" />/
                            </li>
                            <li>
                                <label for="tags">Tags</label>
                                <input type="text" name="tags" id="tags" placeholder="sunrise" />
                            </li>

                        </ul>
                        <button type="submit" id="generate_button">Generate</button>
                        </fieldset>
                    </form>
                </p>
                <div id="generated_image">

                    <img id="image-0" src="480/250/sunset,sea/bw" width="470" height="250" alt="sunset,mountain">
                </div>
            </div>
			
<div id="image-grid">
				<img id="image-1" src="/250/300/city" alt="city" width="250" height="300">
				<img id="image-2" src="/assets/img/ad.png" width="200" height="152" alt="influads">
				<img id="image-3" src="/100/138/city,sunrise" width="100" height="138" alt="city,sunrise">
				<img id="image-4" src="/90/138/city,sunset" width="90" height="138" alt="city,sunset">
				<img id="image-5" src="/460/200/city,sunset" width="460" height="200" alt="city,sunset">
				<img id="image-6" src="/230/400/sunset,nature" width="230" height="400" alt="sunset,nature">
				<img id="image-7" src="/220/130/sunset,mountain" width="220" height="130" alt="sunset,mountain">
                <img id="image-8" src="/220/260/sunset,mountain" width="220" height="260" alt="sunset,mountain">
			</div>

			
		</div><!-- /#primary-content -->
<?php $this->load->view('sub/footer')?>