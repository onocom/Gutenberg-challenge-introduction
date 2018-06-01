<?php
/*
Template Name: Gutenberg Challenge Introduction
*/
$gci = gutenberg_challenge_introduction::get_instance();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title>WordCamp Osaka 2018 Gutenberg Demo Page</title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Monoton" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link href="<?php echo $gci->get_plugin_url();?>/css/style.css" rel="stylesheet">
</head>
<body>
	<div class="p-1 p-md-5 text-center text-white gci-bg-primary">
		<div class="col-md-12 mx-auto my-5 py-5">
			<h1 class="display-3 gci-webfont">Gutenberg<br>DEMO SITE</h1>
			<p class="lead">Gutenbergの使い方を覚えたり、機能について理解を深めるために、実際に手を動かしてみましょう。</p>
			<a href="https://github.com/onocom/gutenberg-challenge/" class="btn btn-light" target="_blank">紹介テーマダウンロード</a>
		</div>
	</div>
	<div class="d-md-flex flex-md-equal w-100 mx-auto ">
		<div class="w-100 py-5 px-3 text-center">
			<div class="my-3 py-5">
				<?php $gci->get_edit_link();?>
			</div>
		</div>
	</div>
	<div class="p-1 p-md-5 text-center text-white gci-bg-secondary ">
		<div class="col-md-12 mx-auto my-5">
			<h2 class="display-3 gci-webfont">Gutenberg<br>Challenge</h2>
			<p class="lead">ランディングページをGutenberg で作ってみよう！</p>
		</div>
	</div>
	<div class="d-md-flex flex-md-equal w-100">
		<div class="bg-dark text-light w-100 p-3 text-center overflow-hidden">
			<div class="p-3">
				<h2 class="display-5">完成イメージ</h2>
				<p>完成イメージは以下からダウンロードできます</p>
				<div class="btn-group">
					<a href="https://github.com/onocom/gutenberg-challenge/raw/master/00_data/step01_check-finish-design-data/pdf/landing-page.pdf" class="btn btn-primary" target="_blank">PDF</a>
					<a href="https://github.com/onocom/gutenberg-challenge/raw/master/00_data/step01_check-finish-design-data/png/landing-page.png" class="btn btn-primary" target="_blank">PNG</a>
					<a href="https://github.com/onocom/gutenberg-challenge/raw/master/00_data/step01_check-finish-design-data/xd/landing-page.xd" class="btn btn-primary" target="_blank">Xd</a>
				</div>
				<a href="https://github.com/onocom/gutenberg-challenge/" class="btn btn-secondary" target="_blank">GitHub</a>

			</div>
			<div class="p-5">
				<div style="max-height: 70vh;overflow: auto;" class="mx-auto">
					<img src="https://github.com/onocom/gutenberg-challenge/raw/master/00_data/step01_check-finish-design-data/png/landing-page.png" class="img-fluid" alt="完成イメージ" >
				</div>
			</div>
		</div>
	</div>
	<div class="d-md-flex flex-md-equal w-100 mx-auto ">
		<div class="w-100 py-5 px-3 text-center">
			<div class="my-3 py-5">
				<?php $gci->get_edit_link();?>
			</div>
		</div>
	</div>
	<div class="d-md-flex flex-md-equal w-100 mx-auto ">
		<div class="bg-light w-100 py-5 px-3 text-center">
			<div class="p-5">
				<h3 class="display-3 gci-webfont">Challenger List</h3>
				<div style="max-width: 600px;max-height: 50vh;overflow: auto;" class="bg-white mx-auto p-0">
					<div class="m-0 text-left list-group">
					<?php
					$posts = get_posts('posts_per_page=100&orderby=modified');
					if( $posts ){
						foreach( $posts as $the_post ) {
							echo "<a class='list-group-item' href='" . get_permalink($the_post) . "' target='_blank'>[ID:" . $the_post->ID . "] " . get_permalink($the_post) . "</a>";
						}
					} else {
						echo "none";
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="d-md-flex flex-md-equal w-100 mx-auto ">
		<div class="w-100 py-5 px-3 text-center">
			<a href="http://onocom.net">onocom.net</a>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>

