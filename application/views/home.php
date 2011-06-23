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
                    <?php /*
                    <div id="share">
                        <ul>

                            <li><a href="http://www.delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=http%3A%2F%2Fflickholdr.com&amp;title=Image placeholders from Flickr" title="Save flickholdr on Delicious"><img src="/assets/img/delicious.png" alt="logo de Delicious" /><span>Delicious</span></a></li>
                            <li><a href="http://www.facebook.com/share.php?u=http%3A%2F%2Fflickholdr.com" title="Share flickholdr on Facebook"><img src="/assets/img/facebook.png" alt="logo de Facebook" /><span>Facebook</span></a></li>
                            <li><a href="http://digg.com/submit?phase=2&amp;url=http%3A%2F%2Fflickholdr.com" title="Share flickholdr.com on Digg"><img src="/assets/img/digg.png" alt="logo de Digg" /><span>Digg</span></a></li>
                            <li><a href="http://twitter.com/share?url=http%3A%2F%2Fflickholdr.com&text=Get%20image%20placeholders%20from%20Flickr,%20by%20tags" title="Share flickholdr.com on Twitter"><img src="/assets/img/twitter.png" alt="logo de Twitter" /><span>Twitter</span></a></li>
                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=http%3A%2F%2Fflickholdr.com&title=Get%20image%20placeholders%20from%20Flickr,%20by%20tags" title="Share flickholdr.com on LinkedIn"><img src="/assets/img/linkedin.png" alt="logo de LinkedIn" /><span>LinkedIn</span></a></li>
                            <li><a href="http://www.stumbleupon.com/submit?url=http%3A%2F%2Fwww.flickholdr.com" title="Share flickholdr.com on stumbleupon"><img src="/assets/img/stumbleupon.png" alt="logo de stumbleupon" /><span>LinkedIn</span></a></li>

                        </ul>
                    </div>*/?>

                    <div id="share2">
                        <div>
                            <a href="http://twitter.com/share" class="twitter-share-button"
                               data-count="vertical">Tweet</a>
                        </div>


                        <g:plusone size="tall" count="true"></g:plusone>

                        <iframe src="http://www.facebook.com/plugins/like.php?app_id=228358510507833&amp;href=http%3A%2Fflickholdr.com&amp;send=false&amp;layout=box_count&amp;width=55&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=segoe+ui&amp;height=60" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:55px; height:60px;" allowTransparency="true"></iframe>
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

                    <img id="image-0" src="480/273/forest,tree,mountain/bw" width="470" height="273" alt="sunset,mountain">
                </div>
            </div>
			
<?php $this->load->view('sub/image_grid')?>

			
		</div><!-- /#primary-content -->
        <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = 'flickholdr'; // required: replace example with your forum shortname

                    // The following are highly recommended additional parameters. Remove the slashes in front to use.
                    // var disqus_identifier = 'unique_dynamic_id_1234';
                    // var disqus_url = 'http://example.com/permalink-to-page.html';

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

<?php $this->load->view('sub/footer')?>