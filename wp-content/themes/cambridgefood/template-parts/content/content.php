<?php
get_template_part( 'template-parts/modules/innerpage', 'banner' );

get_template_part( 'template-parts/modules/ssisa', 'bredcrumbs' );

get_template_part( 'template-parts/modules/innerpage', 'overview' );

?>
<section class="ma-video-overview-wrap mt70">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>