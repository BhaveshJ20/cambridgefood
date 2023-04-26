<section class="contentarea">
    
<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<section class="container">
    <div class="news-article">
        <div class="row">
            <div class="col-lg-2 d-none d-lg-block">
                <div class="mb-3"><?php
                    if(get_post_status() == "archive"){
                        $returnURL = get_home_url().'/news/news-archives';
                    }else{
                        $returnURL = get_home_url().'/news';
                    } 
                    ?>
                    <a href="<?php echo $returnURL; ?>" class="btn btn-blue">Return</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="news-text">
                        <?php echo get_the_content(); ?>
                        <div class="recipe-smedia">
                        <?php echo sharethis_inline_buttons(); ?>
                        <div class="ml-auto d-lg-none d-block">
                            <a href="<?php echo $returnURL; ?>" class="btn btn-blue">Return</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>