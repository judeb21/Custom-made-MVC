<?php require_once APPROOT. "/views/inc/header.php" ?>
	<?php flash("post_message"); ?>
	<div class="row mb-3">
		<div class="col-md-6">
			<h1>All Posts</h1>
		</div>
		<div class="col-md-6">
			<a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary pull-right">
				<i class="fa fa-pencil"></i> Add Post
			</a>
		</div>
	</div>
	<?php foreach($data["posts"] as $posts): ?>
		<div class="card-body mb-3 p-2">
			<h4 class="card-title"><?php echo $posts->title?></h4>
			<div class="bg-light mb-3">Written By <?php echo $posts->name; ?> On <?php echo $posts->postCreated; ?></div>
			<p class="card-text"><?php echo $posts->body; ?></p>
			<a class="btn btn-primary pull-right" href="<?php echo URLROOT;?>/posts/like/<?php echo $posts->postId;?>">
  				Likes <span class="badge badge-light">4</span>
			</a>
			<a href="<?php echo URLROOT;?>/posts/show/<?php echo $posts->postId;?>" class="btn btn-dark">More</a>
		</div>
	<?php endforeach; ?>
<?php require_once APPROOT. "/views/inc/footer.php" ?>
