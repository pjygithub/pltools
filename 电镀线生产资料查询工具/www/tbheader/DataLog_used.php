<?
include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_AmpMin.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_AmpMin.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_AmpMin.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_AmpMin.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_AmpMin.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Conductivity.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Conductivity.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Conductivity.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Conductivity.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Conductivity.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Current.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Current.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Current.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Current.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Current.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_default.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_default.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_default.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_default.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_default.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_FlowRate.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_FlowRate.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_FlowRate.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_FlowRate.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_FlowRate.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_OnOffPumpSpeed.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_OnOffPumpSpeed.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_OnOffPumpSpeed.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_OnOffPumpSpeed.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_OnOffPumpSpeed.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_other.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_other.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_other.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_other.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_other.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Pressure.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Pressure.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Pressure.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Pressure.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Pressure.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Speed.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Speed.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Speed.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Speed.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Speed.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Temperature.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Temperature.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Temperature.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Temperature.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Temperature.php');

include(dirname(__DIR__) . '/tbheader/L0/DataLog_L0_Voltage.php');
include(dirname(__DIR__) . '/tbheader/L1/DataLog_L1_Voltage.php');
include(dirname(__DIR__) . '/tbheader/L2/DataLog_L2_Voltage.php');
include(dirname(__DIR__) . '/tbheader/L3/DataLog_L3_Voltage.php');
include(dirname(__DIR__) . '/tbheader/L4/DataLog_L4_Voltage.php');

$used_all = array_merge(
    $DataLog_L0_AmpMin,
    $DataLog_L1_AmpMin,
    $DataLog_L2_AmpMin,
    $DataLog_L3_AmpMin,
    $DataLog_L4_AmpMin,
    $DataLog_L0_Conductivity,
    $DataLog_L1_Conductivity,
    $DataLog_L2_Conductivity,
    $DataLog_L3_Conductivity,
    $DataLog_L4_Conductivity,
    $DataLog_L0_Current,
    $DataLog_L1_Current,
    $DataLog_L2_Current,
    $DataLog_L3_Current,
    $DataLog_L4_Current,
    $DataLog_L0_default,
    $DataLog_L1_default,
    $DataLog_L2_default,
    $DataLog_L3_default,
    $DataLog_L4_default,
    $DataLog_L0_FlowRate,
    $DataLog_L1_FlowRate,
    $DataLog_L2_FlowRate,
    $DataLog_L3_FlowRate,
    $DataLog_L4_FlowRate,
    $DataLog_L0_OnOffPumpSpeed,
    $DataLog_L1_OnOffPumpSpeed,
    $DataLog_L2_OnOffPumpSpeed,
    $DataLog_L3_OnOffPumpSpeed,
    $DataLog_L4_OnOffPumpSpeed,
    $DataLog_L0_other,
    $DataLog_L1_other,
    $DataLog_L2_other,
    $DataLog_L3_other,
    $DataLog_L4_other,
    $DataLog_L0_Pressure,
    $DataLog_L1_Pressure,
    $DataLog_L2_Pressure,
    $DataLog_L3_Pressure,
    $DataLog_L4_Pressure,
    $DataLog_L0_Speed,
    $DataLog_L1_Speed,
    $DataLog_L2_Speed,
    $DataLog_L3_Speed,
    $DataLog_L4_Speed,
    $DataLog_L0_Temperature,
    $DataLog_L1_Temperature,
    $DataLog_L2_Temperature,
    $DataLog_L3_Temperature,
    $DataLog_L4_Temperature,
    $DataLog_L0_Voltage,
    $DataLog_L1_Voltage,
    $DataLog_L2_Voltage,
    $DataLog_L3_Voltage,
    $DataLog_L4_Voltage
);
