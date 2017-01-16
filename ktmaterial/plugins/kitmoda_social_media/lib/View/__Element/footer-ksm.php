<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package kitification
 */
?>
<?php 
/** JKane
Turning off social via variable JK
 */
 $socialOffSwitch="off";
 ?>
<div class="kit_footer_container_top"></div>
<div class="kit_footer_container">
		    
			<div class="footer_links">
				<div class="kit_logo_footer_container">
				
					<a id="kit_logo_footer" href="/fair-share/"> 
						
					</a>
				</div>
				<div class="kit_footer_section">
                                    
					<h1  class="kit_footer_linklist_header_company">
					Company
					</h1>
					
					<div>
						<p class="kit_footer_linklist">
						<a title="About Kitmoda" href="<?=ksm_get_permalink('about')?>">About Kitmoda</a>
						<br>
						<a title="Careers" href="<?=ksm_get_permalink('careers')?>">Careers</a>
						<br>
						<a title="Press" href="<?=ksm_get_permalink('press')?>">Press/Media</a>
						</p>
					</div>
				</div>
				<div  class="kit_footer_section">
					<h1 class="kit_footer_linklist_header_submissions">
					Submissions
					</h1>
					
						<div>
						<p class="kit_footer_linklist">
						<a title="Join" href="<?=ksm_get_permalink('join')?>">Join</a>
						<br>
						<a title="Best Practices" href="<?=ksm_get_permalink('bestpractices')?>">Best Practices</a>
                                                <br>
                                                <a title="Payments" href="<?=ksm_get_permalink('payments')?>">Payments</a>
						</p>
					</div>
					
				</div>
				<div  class="kit_footer_section">
					<h1 class="kit_footer_linklist_header_help">
					Help
					</h1>
					
					<div>
						<p class="kit_footer_linklist">
						<a title="Contact Support" href="<?=ksm_get_permalink('support')?>">Contact Support</a>
						<br>
						<a title="FAQs" href="<?=ksm_get_permalink('faqs')?>">FAQs</a>
						</p>
					</div>
					
				</div>
				
				<div class="kit_footer_section">
					<h1 class="kit_footer_linklist_header_legal">
					Legal
					</h1>
					<div>
						<p class="kit_footer_linklist">
						<a title="Privacy Policy" href="<?=ksm_get_permalink('privacy')?>">Privacy Policy</a>
						<br>
						<a title="Terms and Conditions" href="<?=ksm_get_permalink('terms')?>">Terms and Conditions</a>
                                                <br>
                                                <a title="Return Policy" href="<?=ksm_get_permalink('returns')?>">Return Policy</a>
						</p>
					</div>
				</div>
                            
                                <div class="kit_footer_map">
                                </div>
                                    
                            
				
			
			</div>
                        <div class="footer_legal_container">
					<p class="footer_legal_type">Copyright © 2014-2017 Kitmoda, Inc. All rights reserved. - Built by Artists for Artists. Collaboration System Patent Pending.</p>
		        </div>
</div>
</body>
</html>