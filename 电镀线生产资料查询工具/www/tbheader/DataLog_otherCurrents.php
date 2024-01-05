<?
include(dirname(__DIR__) . '/tbheader/DataLog_mainPlatingTankCurr.php');
include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Current.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Current.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Current.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Current.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Current.php');
$DataLog_Current_s = array_merge($DataLog_L0_Current, $DataLog_L1_Current, $DataLog_L2_Current, $DataLog_L3_Current, $DataLog_L4_Current);
// var_dump($DataLog_Current_s);
$DataLog_otherCurrents = array();
for ($i = 0; $i < count($DataLog_Current_s); $i++) {
    if (!array_search($DataLog_Current_s[$i], $DataLog_mainPlatingTankCurr, TRUE)) {
        array_push($DataLog_otherCurrents, $DataLog_Current_s[$i]);
    }
}
$tbheader = $DataLog_otherCurrents;
