<?php

$dimensions = array(
    "PercentageDiskSpaceUsed",
    "ReadIOPS",
    "TotalTableCount",
    "WriteIOPS",
    "CPUUtilization");

$statistic="Average";

$f = fopen("$argv[1].csv","w");
$title = "Timestamp,";
$res = array();
foreach ($dimensions as $d)
{
    $title .= "$d,";
    $filename = "$argv[1].$d.json";
    echo "Running: ".$filename."\n"; 

    $data = json_decode(file_get_contents($filename),true);
    $data = $data["Datapoints"];
    foreach ($data as $dd)
    {
        if (!array_key_exists($dd["Timestamp"], $res))
        {
            $res[$dd["Timestamp"]] = array();
        }
        $res[$dd["Timestamp"]][$d] = $dd[$statistic];
    }
}

fwrite($f, $title."\n");
foreach ($res as $t => $r)
{
    fwrite($f, $t.",");
    foreach ($dimensions as $d)
    {
        fwrite($f,$r[$d].",");
    }
    fwrite($f,"\n");
}

fclose ($f);