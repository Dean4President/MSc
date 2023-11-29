<?php
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
<div class="card shadow">
	<div class="card-header">
		<table class="table">
			<tr class="row mb-4">
				<td class="col-8 text-center" colspan="8"><h1>Leaderboard</h1></td>
				<td class="col-2" colspan="2">
					<form name="form1" method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<button type="submit" name="goto_game" class="btn btn-info" value="goto_game">Play!</button>
					</form>
				</td>
				<td class="col-2" colspan="2">
					<form name="form1" method="GET" action="<?php echo $_SERVER['PHP_SELF'];?>">
						<button type="submit" name="goto_admin" class="btn btn-dark" value="goto_admin">Admin</button>
					</form>
				</td>
			</tr>
			<tr class="row">
				<th scope="col" class="col-4" colspan="4">USERNAME</td>
				<th scope="col" class="col-4" colspan="4">NUMBER OF GAMES</td>
				<th scope="col" class="col-4" colspan="4">AVERAGE GUESSES PER GAME</td>
			</tr>
			<?php foreach($results as $result) { ?>
				<tr class="row">
					<td class="col-4" colspan="4"><?php echo $result['username'] ?></td>
					<td class="col-4" colspan="4"><?php echo $result['NumberOfGames'] ?></td>
					<td class="col-4" colspan="4"><?php echo $result['AverageGuess'] ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
