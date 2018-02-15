<?php require_once APPROOT. "/views/inc/header.php" ?>
    <a href="<?php echo URLROOT;?>/posts" class="btn btn-light"><i class= "fa fa-backward"></i> Back</a>
	<h1><?php echo $data["post"]->title ?></h1>
	<div class="bg-secondary text-white p-2 mb-3">
		Written By <?php echo $data["user"]->name; ?> on <?php echo $data["user"]->created_at; ?>
			
	</div>
	<p><?php echo $data["post"]->body; ?></p>

	<?php if ($_SESSION["user_id"] == $data["user"]->id): ?>
		<a class="btn btn-dark" href="<?php echo URLROOT;?>/posts/edit/<?php echo $data["post"]->id;?>" type="button">Edit</a>

		<form method="post" action="<?php echo URLROOT;?>/posts/delete/<?php echo $data["post"]->id; ?>" class="pull-right">
			<input type="submit" class="btn btn-danger" id= "delete" value="Delete"></input>
		</form>
	<?php endif; ?>
	<script type="text/javascript">
		var submit = document.querySelector("#delete");
		submit.addEventListener("click", function() {
			return confirm("Sure to delete post?");
			
			}
		});
	</script>
<?php require_once APPROOT. "/views/inc/footer.php" ?>
