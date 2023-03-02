<?php
	session_start();
	$_SESSION["hotel"] = $_GET['hotel'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>Zarezerwuj pokoj</title>
</head>

<body>
	<div id="container">
		<div id="header">
			<a href="noclegi.html" class="back">&#8592; powrót do Meiringen</a>
		</div>
		<div id="content">
				<fieldset id="form">
				<legend>Zarezerwuj pokój</legend>
				<div class="left">					
					<form method="post" action="rezerwacja.php">
						<div class="left">
							<label>Imię:</label>
							<input name="Imie" />
							<label>Nazwisko:</label>
							<input name="Nazwisko" /><br/>
							<label>Numer telefonu:</label>
							<input name="Telefon" placeholder="+48500500500" />
						</div>
						<div class="right">
							<label>Zameldowanie:</label>
							<input type="date" name="data_od">
							<label>Wymeldowanie:</label>
							<input type="date" name="data_do">
							<label>Który pokój chcesz zarezerwować?</label>
							<select name="Pokoj">
								<option value="2 os">2-osobowy
									<?php
										$conn = new mysqli("localhost", "user1", "", "rezerwacje");
										if ($conn->connect_error) {
    										die("Connection failed: " . $conn->connect_error);
    									}
										$sql = "SELECT cena from pokoje P join hotele_pokoje HP on HP.pokoj_ID = P.ID where P.typ='2 os' and HP.hotel_id=" . $_GET['hotel'];
										$result = $conn->query($sql);
										while($row = $result->fetch_assoc()) {
       										echo $row["cena"];
    									}
									?>
								</option>
								<option value="3 os">3-osobowy 
										<?php
										$sql = "SELECT cena from pokoje P join hotele_pokoje HP on HP.pokoj_ID = P.ID where P.typ='3 os' and HP.hotel_id=" . $_GET['hotel'];
										$result = $conn->query($sql);
										while($row = $result->fetch_assoc()) {
       										echo $row["cena"];
    									}
    									$conn->close();
									?>								
								</option>								
							</select>
							<label>Czy potrzebujesz dostawki?</label>
							<input type="radio" name="Dostawka" value="1" />tak
							<input type="radio" name="Dostawka" value="0" />nie
						</div>
						<input type="submit" value="Wyślij formularz" />
						<input type="reset" value="Wyczyść dane" />
					</form>
				</div>
				<div class="right">
					<?php
						$foto = $_GET['hotel'];

						switch ($foto) {
							case 1:
								echo '<img src="media/hot_sh.png" class="img_hotel">';
								break;
							case 2:
								echo '<img src="media/hot_phs.png" class="img_hotel">';
								break;
							case 3:
								echo '<img src="media/hot_adler.png" class="img_hotel">';
								break;
						}
					?>
				</div>
			</fieldset>

		</div>
		<div id="footer">
			System rezerwacji &#xA9; O.Kierkowska 2017
		</div>
	</div>
</body>

</html>