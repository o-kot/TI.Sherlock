<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="styles.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>Twoja rezerwacja</title>
</head>

<?php

	$conn = new mysqli("localhost", "user1", "", "rezerwacje");
		if ($conn->connect_error) 
		{
    		die("Connection failed: " . $conn->connect_error);
    	}



    if($_POST['Imie'] == "" || $_POST['Nazwisko'] == "" || $_POST['Telefon'] == "" || !isset($_POST['Dostawka']))
    {
    	echo '<script type="text/javascript">alert("Nie wprowadziłeś wszystkich danych. Uzupełnij brakujące pola."); window.history.back(); </script>';
    }
    else if (date("Y-m-d", strtotime($_POST['data_od'])) <= date("Y-m-d") || date("Y-m-d", strtotime($_POST['data_do'])) <= date("Y-m-d")) 
    {
    	echo '<script type="text/javascript">alert("Podałeś złą datę. Nie możesz zarezerwować hotelu w przeszłości."); window.history.back(); </script>';
    }
    else if (date("Y-m-d", strtotime($_POST['data_od'])) >= date("Y-m-d", strtotime($_POST['data_do'])))
    {
    	echo '<script type="text/javascript">alert("Wprowadziłeś błędne daty. Data zakończenia pobytu nie może być wcześniejsza niż data jego rozpoczęcia :) "); window.history.back(); </script>';
    }
    else
    {
	    if(!preg_match("/^\+[0-9]{11}$/", $_POST['Telefon'])) 
	    {
	    	echo '<script type="text/javascript">alert("Wprowdziłeś numer telefonu w niepoprawnym formacie."); window.history.back(); </script>';
	    }
	    else 
	    {
	    	$sql = "SELECT ID from klienci where telefon=" . $_POST['Telefon'];
	    	$result = $conn->query($sql);
	    	$num = mysqli_num_rows($result); 
		   	
		   	if($num==0)
		   	{
		   		$sql = "INSERT INTO klienci (imie, nazwisko, telefon)
				VALUES ('" . $_POST['Imie'] . "','" . $_POST['Nazwisko'] . "','" . $_POST['Telefon'] . "')";
				$conn->query($sql);

	    		$sql = "SELECT ID from klienci where telefon=" . $_POST['Telefon'];
	    		$result = $conn->query($sql);

	    		while($row = $result->fetch_assoc()) 
	    		{
	        		$IDK= $row["ID"];
	        		//echo $IDK;
	    		}
	    		
		   	}
		   	else 
		   	{
				while($row = $result->fetch_assoc()) 
				{
	        		$IDK= $row["ID"];
	        		//echo $IDK;
	    		}
	    		
		   	}

			$sql = "SELECT ID from rezerwacje where klient_id=$IDK";
		    $result = $conn->query($sql);
		    $num = mysqli_num_rows($result); 
				if($num!=0)
				{
					echo '<script type="text/javascript">alert("Masz już jedną rezerwację, niestety nie możesz zrobić następnej :( "); window.history.back(); </script>';
				}
				else
				{
					$sql = "SELECT ilosc, pokoj_id from hotele_pokoje HP join pokoje P on P.ID=HP.pokoj_id where hotel_ID=" .$_SESSION["hotel"] . " and typ = '" . $_POST['Pokoj'] ."'";
				 	$result = $conn->query($sql);

				 	//echo $sql;

				 	while($row = $result->fetch_assoc())
				 	{
				 		$avail=$row['ilosc'];
				 		$IDP=$row["pokoj_id"];

				 		//echo "Łącznie mamy " . $avail . " pokoi. ID pokoju to " . $IDP;
				 	}

					$sql = "SELECT ID from rezerwacje where ((data_od between '" . $_POST['data_od'] . "' and '" . $_POST['data_do'] . "') or (data_do between '" . $_POST['data_od'] . "' and '" . $_POST['data_do'] . "')) and pokoj_id =" .$IDP;		    
					$result = $conn->query($sql);
				    $num = mysqli_num_rows($result);
				    //echo $num;
				 	    
					if(!($num < $avail)) 
				 	{
				 		echo '<script type="text/javascript">alert("Niestety wybrany rodzaj pokoju nie jest dostęny w tym okresie :( "); window.history.back(); </script>';
				 		
				 	}
				 	else
				 	{ 
				 		$sql = "INSERT INTO rezerwacje (pokoj_id, klient_id, czy_dostawka, data_od, data_do)
						VALUES  ('". $IDP ."', '". $IDK ."', '". $_POST['Dostawka'] ."', '". $_POST['data_od'] ."', '". $_POST['data_do'] ."')";
						$result = $conn->query($sql);
						?>

						<h3>Gratulacje, dokonaleś rezerwacji w 
							<?php
							switch ($_SESSION['hotel']) {
							 	case 1:
							 		echo "Das Hotel Sherlock holmes";
							 		break;
							 	case 2:
							 		echo "Parkhotel du Sauvage";
							 		break;
							 	case 3:
							 		echo "Hotel Adler Central";
							 		break;
							}; 
							?>
							!
						</h3>
						<div id="summary">
						<h4>Dane Twojej rezerwacji:</h4>
							<?php
							echo $_POST['Imie'] . " " . $_POST['Nazwisko'] . "<br> Numer kontaktowy: " . $_POST['Telefon'] . "<br> Data przyjazdu: " . $_POST['data_od'] . "&emsp;Data wyjazdu: " . $_POST['data_do'];
							?>
						</div>
						<p><a href="index.html" class="back">&#8592; powrót do Meiringen</a></p>

						<?php
						session_destroy();

				 	}			
					
				}


	    }
	}

	$conn->close();

?>