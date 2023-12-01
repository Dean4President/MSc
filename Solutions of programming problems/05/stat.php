<?php
	session_start();
	
	if(!$_SESSION['enter']) {
		header("Location: ./index.php");
	}

	$link=mysqli_connect('localhost','root','', 'php');

	// make a query, check the user and pass
	$sql='SELECT users.username, COUNT(games.user_id) as NumberOfGames, ROUND(AVG(games.guesses), 2) AS AverageGuess
		FROM games
		INNER JOIN users USING(user_id)
		GROUP BY games.user_id
		ORDER BY AverageGuess ASC, NumberOfGames DESC;';

	// get results from the database, using our query
	$results=mysqli_query($link, $sql);

	mysqli_close($link);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<html>
	<head>
		<style>
			.center {
				margin: 0;
				position: absolute;
				top: 50%;
				left: 50%;
				-ms-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
			}
		</style>
	</head>
	<body>
		<?php include("./nav.php"); ?>
		<div class="container center" style="max-width: 800px;">
			<div class="card shadow">
				<div class="card-header">
					<table class="table">
						<tr class="row mb-4">
							<td class="col-12 text-center" colspan="3"><h1>Leaderboard</h1></td>
						</tr>
						<tr class="row">
							<th scope="col" class="col-4">USERNAME</td>
							<th scope="col" class="col-4">NUMBER OF GAMES</td>
							<th scope="col" class="col-4">AVERAGE GUESSES PER GAME</td>
						</tr>
						<?php foreach($results as $result) { ?>
							<tr class="row">
								<td class="col-4"><?php echo $result['username'] ?></td>
								<td class="col-4"><?php echo $result['NumberOfGames'] ?></td>
								<td class="col-4"><?php echo $result['AverageGuess'] ?></td>
							</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>