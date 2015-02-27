<?php get_header(); ?>	

<?php query_posts( 'post_type=page&posts_per_page=100&orderby=menu_order&order=asc' ); ?>

<?php  while (have_posts()) : the_post(); ?>

<div class="main-container section <?php echo $post->post_name; ?>" id="<?php echo $post->post_name; ?>">

<header class="wrapper clearfix">

<div class="logo">
<a href="#home"><?php bloginfo('name'); ?></a>
</div>

<nav>
<ul class="nav">
		<?php 
		$nav = get_pages('sort_column=menu_order'); 
		foreach ($nav as $navitem) {
		$link = '<li id="nav-'.$navitem->post_name.'"><a href="#'. $navitem->post_name .'">'.$navitem->post_title.'</a></li>';					
		echo $link;
		}
		?>
		<li><a href="http://thebiblecourse.bigcartel.com" title="Visit The Store" target="_blank">Order</a></li>
</ul>
</nav>

</header>

<div class="main wrapper clearfix">
<?php the_content(); ?>
</div><!-- close wrapper -->
</div><!-- close section -->

<?php $i++; endwhile; ?>
	
<?php get_footer(); ?>


