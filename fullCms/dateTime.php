<?php 

date_time_set("Africa/Lagos");
$CurrentTime=time();
//$DateTime=strftime("%Y-%m-%d %H:%M:%S".$CurrentTime);
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;