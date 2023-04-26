<div class="leaflets-wrap">
<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'our-latest-specials' ); ?> 
</div>


<section class="contentarea">
    <div class="cf_vtabs">  
        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-2">
                    <div class="tab-content" id="v-pills-tabContent"><?php                            
                        $leaflets_menu_cnt = 1;   
                        $select_leaflets_to_display = get_field('select_leaflets_to_display');
                        if($select_leaflets_to_display):
                            $leaflets_args = array(
                                'posts_per_page' => -1,
                                'post_type' => 'leaflets',
                                'post_status' => 'publish',
                                'post__in' => $select_leaflets_to_display,
                                'orderby' => 'post__in'
                            );
                            $the_query = new WP_Query($leaflets_args);
                            if($the_query->have_posts()):
                                while($the_query->have_posts()):
                                    $the_query->the_post();
                                    $leafletsName = 'v-pills-'.strtolower(str_replace(' ','-',get_the_title())).'-tab';
                                    $leafletsID = 'v-pills-'.strtolower(str_replace(' ','-',get_the_title()));

                                  //  $add_leaflets_shortcode = get_field('add_leaflets_shortcode');

                                    if($leaflets_menu_cnt == 1):
                                        $mainTabClassName = "show active";
                                    else:
                                        $mainTabClassName = "";
                                    endif; ?>
                                    <div class="tab-pane fade <?php echo $mainTabClassName; ?>" id="<?php echo $leafletsID; ?>" role="tabpanel" aria-labelledby="<?php echo $leafletsName; ?>">
                                        <div class="title text-center mb-4">
                                            <h2 class="pink-text"><?php the_title(); ?></h2>
                                        </div><?php
                                        if( have_rows('add_leaflets_thumbnail_image') ):
                                            echo '<ul class="leaflet-box">';
                                            while ( have_rows('add_leaflets_thumbnail_image') ) : the_row();
                                                $leaflet_paper_title = get_sub_field('add_title');
                                                $leaflet_paper_thumbImage = wp_get_attachment_image_src(get_sub_field('add_thumbnail_image')['id'],'');  
                                                  $add_leaflets_shortcode = get_sub_field('lefleft_shortcode');
                                                ?>
                                                <li class="leaflet-list">
                                                    <div class="leafletbook">
                                                        <div class="title">
                                                            <h3 class="pink-text"><?php echo $leaflet_paper_title; ?></h3>
                                                        </div>
                                                        <div class="leafletbook-thumb mb-3">
                                                            <a href="javascript:void(0)">
                                                            <?php echo do_shortcode($add_leaflets_shortcode); ?>
                                                                <img class="img-full" src="<?php echo $leaflet_paper_thumbImage[0]; ?>" alt="">
                                                            </a>                                                            
                                                        </div><?php
                                                        $tempLefletsId = explode('id="', $add_leaflets_shortcode);
                                                        $getLefletsId = explode('"', $tempLefletsId[1]);
                                                        $leafletsAttachments = get_posts( array(
                                                                'post_type' => 'attachment',
                                                                'posts_per_page' => -1,
                                                                'post_parent' => $getLefletsId[0] ));
                                                        if(is_array($leafletsAttachments)):
                                                            $pdfLeftletsURL = $leafletsAttachments[0]->guid;
                                                            echo '<a class="show-mobile-leaflets btn btn-pink" href="'.$pdfLeftletsURL.'" class="btn btn-pink" download>Download</a>';
                                                        endif; ?>                                                        
                                                    </div>
                                                </li><?php
                                            endwhile;
                                            wp_reset_query();
                                            wp_reset_postdata();
                                            echo '</ul>';
                                            echo '<div class="clearfix"></div>';
                                        endif; ?>
                                    </div>
                                    <?php
                                    $leaflets_menu_cnt++;
                                endwhile;
                                wp_reset_query();
                                wp_reset_postdata();
                            endif;
                        endif; ?>                                                                        
                    </div>
                </div>
                <div class="col-lg-3 order-lg-1 col-bor-r">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        
                        <?php
                        if($select_leaflets_to_display):
                            $leaflets_args = array(
                                'posts_per_page' => -1,
                                'post_type' => 'leaflets',
                                'post_status' => 'publish',
                                'post__in' => $select_leaflets_to_display,
                                'orderby' => 'post__in'
                            );
                            $the_query = new WP_Query($leaflets_args);
                            if($the_query->have_posts()):
                                $leaflets_deskmenu_cnt = 1;
                                while($the_query->have_posts()):
                                    $the_query->the_post(); 
                                    $leafletsName = 'v-pills-'.strtolower(str_replace(' ','-',get_the_title())).'-tab';
                                    $leafletsID = 'v-pills-'.strtolower(str_replace(' ','-',get_the_title())); 
                                    if($leaflets_deskmenu_cnt == 1):
                                        $TabClassName = "active";
                                    else:
                                        $TabClassName = "";
                                    endif; ?>
                                    <a class="nav-link <?php echo $TabClassName; ?>" id="<?php echo $leafletsName; ?>" data-toggle="pill" href="#<?php echo $leafletsID; ?>" role="tab" aria-controls="<?php echo $leafletsID; ?>" aria-selected="false"><?php the_title(); ?></a><?php
                                    $leaflets_deskmenu_cnt++;
                                endwhile;
                                wp_reset_query();
                                wp_reset_postdata();
                            endif;
                        endif; ?>  
                        <a id="enq_button" class="nav-link leflets-enq-form-button" href="javascript:void(0)" data-toggle="modal" data-target="#leflets_enq_form"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Hear From Us</a>                                              
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>                
        </div>
    </div>    
</section>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="leflets_enq_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="pink-text">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo do_shortcode('[contact-form-7 id="1830" title="Leaflets Enquire"]'); ?>
      </div>
    </div>
  </div>
</div>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>