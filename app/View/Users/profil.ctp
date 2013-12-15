<script type="text/javascript" src="../js/chart.js"></script>


    
<?php $this->set('menuNb', 1);?>
<p class="lead">
Welcome <?=$user['User']['username'] ?>!

<br>
Your mother language is <?=$user['Language']['description']; echo ' '.$this->Html->image('flags/'.$user['Language']['flag']); ?> 
<br>

Credits: <?=$this->Session->read('Auth.User.credit') ?>
</p>

<br>
<center>
<?php 
if ($nbOfEntriesForUser <=5) $color = '#2554C7';
if ($nbOfEntriesForUser >5) $color = '#342D7E';
if ($nbOfEntriesForUser >10) $color = '#D4A017';
	
	
	echo '<h3><span class="glyphicon glyphicon-star" style="color:'.$color.';font-size:50px"></span>You have actually '.$nbOfEntriesForUser.' audio record(s)</h">';
	
	
?>
</center>
<br>
<br>
<div class="panel panel-info" style='width:auto'>
	<div class="panel-heading" style='text-align:center'>
		Rating Statistics:
	</div>
	<div class="panel-body" style='text-align:center'>
	
	
	
	
                <canvas id="canvas" height="450" width="600"></canvas>


        <script>

                var barChartData = {
                        
        labels : [<?php 
        $keys = array_keys($usersAudioFiles);
        for ($i=0; $i < count($usersAudioFiles);$i++){
        	echo '"' . $keys[$i] . '",';
        }
        ?>], datasets : [
                                {
                                        fillColor : "rgba(151,187,205,0.5)",
                                        strokeColor : "rgba(151,187,205,1)",
                                        data : 
		[<?php for ($i=0; $i < count($usersAudioFiles);$i++){
			echo '"' . ($usersAudioFiles[$keys[$i]]+1) . '",';
		}?>]
                                }
                        ]
                        
                }

        var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Bar(barChartData);
        
        </script>

    </div>
</div>
