<?php
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		$a = $_POST["a"];
		$b = $_POST["b"];
		$c = $_POST["c"];

		if ($a !== 0) {
			$d = ($b*$b)-(4*$a*$c);

			$expression = $a.'x^2 + '.$b.'x + ' .$c.' = 0';

			if($d > 0) {
				$tmp = sqrt($d);

				$x1 = (-$b+$tmp)/(2*$a);
				$x2 = (-$b-$tmp)/(2*$a);

				$result = 'x1 = '.round($x1, 2).'<br />'
							.'x2 = '.round($x2, 2);
			}
			else if($d === 0) {
				$tmp = sqrt($d);

				$x1 = (-$b+$tmp)/(2*$a);

				$result = 'x = '.$x1.round(2);
			}
			else {
				$x1 = sqrt($d * -1);
				$x2 = $x1 * -1;

				$result = 'x1 = '.round($x1, 2).'i'.'<br />'
							.'x2 = '.round($x2, 2).'i';
			}
		}
		else if ($b !== 0) {
			$x = (0 - $c)/$b;
			
			$expression = $b.'x + ' .$c.' = 0';


			$result = 'x = '.round($x, 2);
		}
		else {

			if($c === 0) {
			$expression = $c.' = 0';

			$result = '';
			}
			else {
				$expression = $c.' != 0';

				$result = '';
			}
		}	
	}
?>

<html>
	<header>
	</header>
	<body>
		<form name="form" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
			<p>
				a = <input type="text" name="a" value="<?php echo $_POST["a"] ?? '' ?>" required/>
			</p>
			<p>
				b = <input type="text" name="b" value="<?php echo $_POST["b"] ?? '' ?>" required/>
			</p>
			<p>
				c = <input type="text" name="c" value="<?php echo $_POST["c"] ?? '' ?>" required/>
			</p>
			<p>
				<button type="submit" name="submit">Calculate</button>
			</p>
		</form>
	</body>
</html>

<?php if (!empty($_POST)) { ?>
<p>
	<?php echo $expression ?>
</p>
<p>
	<?php echo $result ?>
</p>
<?php } ?>
