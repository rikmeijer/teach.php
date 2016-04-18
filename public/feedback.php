<?php
$dataDirectory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data';
$filename = $dataDirectory . DIRECTORY_SEPARATOR . $_SERVER['REMOTE_ADDR'] . '.txt';

if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0) {
    file_put_contents($filename, json_encode([
        'rating' => $_POST['rating'],
        'explanation' => $_POST['explanation']
    ]));
    exit('Dankje!');
} elseif (is_file($filename)) {
    $data = json_decode(file_get_contents($filename), true);
} else {
    $data = null;
}

if ($data !== null) {
    $rating = $data['rating'];
    $explanation = $data['explanation'];
} else {
    $rating = null;
    $explanation = null;
}

if (array_key_exists('rating', $_GET)) {
    $rating = $_GET['rating'];
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Feedback</title>
<style>
body {
	font-family: arial, sans-serif;
}
</style>
</head>
<body>
	<center>
		<h1>Hoeveel sterren?</h1>
<?php
for ($i = 0; $i < 5; $i ++) {
    if ($rating === null) {
        $image = "/img/star.png";
    } elseif ($i < $rating) {
        $image = "/img/star.png";
    } else {
        $image = "/img/unstar.png";
    }
    ?><a
			href="?rating=<?php print htmlentities(rawurldecode($i + 1));?>"><img
			src="<?php print htmlentities($image); ?>" width="100" /></a><?php
}
if ($rating !== null) {
    ?>
    <form action="feedback.php" method="post">
			<h1>Waarom?</h1>
			<input type="hidden" name="rating"
				value="<?php print htmlentities($rating);?>" />
			<textarea rows="5" cols="75" name="explanation"><?php print htmlentities($explanation); ?></textarea>
			<p>
				<input type="submit" value="Verzenden!" />
			</p>
		</form>
    <?php
}
?>
</center>
</body>
</html>