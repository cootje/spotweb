			<div class="spotscontainer">
				<table class="spots">
					<tr> <th> Formaat </th> <th> Cat. </th> <th> Titel </th> <th> Genre </th> <th> Afzender </th> <th> Datum </th> <th> Dnl. </th> </tr>
			
<?php
	$count = 0;
	foreach($spots as $spot) {
		$count++;

		echo "\t\t\t\t\t";
		echo "<tr class='" . ($count % 2 ? "even" : "odd") . "' >" . 
			 "<td>" . SpotCategories::Cat2Desc($spot['category'], $spot['subcata']) . "</td>" .
			 "<td>" . SpotCategories::HeadCat2Desc($spot['category']) . "</td>" .
			 "<td><a href='?page=getspot&amp;messageid=" . $spot['messageid'] . "'>" . $spot['title'] . "</a></td>" .
			 "<td>" . SpotCategories::Cat2Desc($spot['category'], $spot['subcat' . SpotCategories::SubcatNumberFromHeadcat($spot['category'])]) . "</td>" .
			 "<td>" . $spot['poster'] . "</td>" .
			 "<td>" . strftime("%a, %d-%b-%Y (%H:%M)", $spot['stamp']) . "</td>";
			 

		# only display the NZB button from 24 nov or later
		if ($spot['stamp'] > 1290578400 ) {
			echo "<td><a href='?page=getnzb&amp;messageid=" . $spot['messageid'] . "'>NZB</a></td>";
		} else {
			echo "<td> &nbsp; </td>";
		} # else
		
		echo "</tr>\r\n";
	}
?>

			</table>
		</div>
