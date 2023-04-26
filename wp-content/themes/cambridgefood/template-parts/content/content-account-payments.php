<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="contentarea">
    <div class="container">
        <div class="py-5"><?php
			$pay_your_amounts_title = get_field('pay_your_amounts_title');		 
			if(have_rows('add_account_payment_steps')):
				?>                
				<div class="title2 mb-3">
					<h2 class="pink-text"><?php echo $pay_your_amounts_title; ?></h2>
				</div>
				<?php
				while(have_rows('add_account_payment_steps')):
					the_row();
					$step_title = get_sub_field('step_title');
					$step_description = get_sub_field('step_description');
					?>
					<div class="title2"><h2 class="pink-text"><?php echo $step_title; ?></h2></div>
					<p class="mb-4"><?php echo  $step_description; ?></p>
				<?php endwhile; 
            endif; ?>
            <div class="row"><?php
                if(have_rows('add_payment_company_logo')):
                    while(have_rows('add_payment_company_logo')):
                        the_row();							
                        $image = get_sub_field('payment_company_logo');
                        if($image):
                            $img_src = wp_get_attachment_image_src($image['id'],''); ?>
                            <div class="col-md-5">
                                <img src="<?php echo $img_src[0]; ?>" alt="Account Payments Company logo">
                            </div><?php 
                        endif; 
                    endwhile;
                endif; ?>
            </div>
        </div>
</section>