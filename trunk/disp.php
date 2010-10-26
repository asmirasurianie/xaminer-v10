<select name="paper">
						<option value="0">Select paper</option>
 
						<?php
						$sql = mysql_query("SELECT DISTINCT(paper_name) FROM questionpapers");
						while($row= mysql_fetch_array($sql))
							{
                               echo "<option value='".$row[0]."'>".$row[0]."</option>";
							}
						
							?>
                        </select>