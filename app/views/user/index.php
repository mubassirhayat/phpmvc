<?php if($data['user']):?>
	<!-- Main jumbotron for a primary marketing message or call to action -->
	<div class="jumbotron">
		<div class="container">
			<h1>Hello <?php echo $data['user']['name'];?>!</h1>
			<p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
			<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Hello <?php echo $data['user']['name'];?>!</h2>
				<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
				<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
			</div>
		</div>
		<hr>
	</div>
<?php else: ?>
	<h1>User Not Found</h1>
<?php endif; ?>
