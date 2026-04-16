<?php
include('../includes/sessions.php');
include('../includes/query.php');
include('../includes/jsincludesnew.php');
include('../includes/common_functions.php');
include('../phpcomponents/notice_summons_json_comp.php');
include('../phpcomponents/actsectioncomp.php');
////include('csrf-magic.php');

//if(!isPostback)
$dist_code = $_GET['dist_code']; //'88';
$cino1 = $_GET['cino'];

//dispMessage($dist_code." ".$cino);
?>
<html>

<head>
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/mainstyles.css" rel="stylesheet">
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../css/fonts.css" rel="stylesheet" type="text/css">
    <script src="../js/bootstrap.min.js"></script>

    <script type="text/javascript" src="proceeding_reject_transfer.js"></script>
    <script type="text/javascript" src="../components/report_comp.js"></script>

    <link rel="stylesheet" href="../jquery-date/jquery-ui.css">
    <script src="../jquery-date/js/jquery-ui.js"></script>
    <style type="text/css">
        .bordered thead th {
            font-size: 13px;
            padding-left: 10px;
            border: 1px solid black;
        }

        .bordered tbody td {
            font-size: 13px;
            padding-left: 10px;
            border: 1px solid black;
        }
    </style>
    <style>
        .chosen {
            width: 100% !important;
        }

        #fpurpose_codes_chosen {
            width: 100% !important;
        }

        #fsubpurpose_codes_chosen {
            width: 100% !important;
        }

        .row-centered {
            text-align: center;
        }

        .selected {
            position: relative;
            display: block;
            padding: .5rem .75rem;
            margin-left: -1px;
            line-height: 1.25;
            border: 1px solid #dddfeb;
            z-index: 2;
            color: #224abe;
            text-decoration: none;
            background-color: #eaecf4;
            border-color: #dddfeb;
        }

        table.test thead tr th {
            padding: 5px !important;
        }


        .off_tbl thead {
            background: #2587bd;
        }

        .shwchln {
            color: #224abe;
            text-decoration: underline;
            font-weight: bold;
        }
    </style>

    <style type="text/css">
        table.gridtable {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: #333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }

        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }

        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
    </style>
    <style type="text/css">
        table.gridtable {
            font-family: verdana, arial, sans-serif;
            font-size: 11px;
            color: #333333;
            border-width: 1px;
            border-color: #666666;
            border-collapse: collapse;
        }

        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }

        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }

        .popup {
            padding: 1px;
            background: #fdfdfd;
            border: 5px solid #555555;
            ;
            position: absolute;
            z-index: 999;
            display: none;
            -webkit-box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.5);
            box-shadow: 0px 0px 5px 2px rgba(0, 0, 0, 0.5);
            margin-right: 5%;
            max-width: 50%;
        }


        .dataTables_filter {
            width: 68% !important;
            float: right !important;
            text-align: right !important;
        }

        .test td,
        .test th {
            padding: 1px !important;
            text-align: center !important;
            vertical-align: middle !important;
        }


        .formChk1 {
            -ms-transform: scale(1.5);
            /* IE */
            -moz-transform: scale(1.5);
            /* FF */
            -webkit-transform: scale(1.5);
            /* Safari and Chrome */
            -o-transform: scale(1.5);
            /* Opera */
            padding: 0px;
            margin: 0px;
        }

        /*.pr_tbl > tbody > tr:nth-of-type(odd) {
    background-color: #F0C987;
}*/
    </style>
</head>

<form name="frm" id="frm" method="post">
    <input type="hidden" name="formaction" id="formaction">
    <input type="hidden" name="num_rows" id="num_rows">
    <input type="hidden" name="dist_code" id="dist_code" value="<?php echo $dist_code ?>">
    <input type="hidden" name="cino1" id="cino1" value="<?php echo $cino1 ?>">

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-3">
            <h1 class="h3 mb-0 text-gray-800">
                Rejection and Transfer (to Regular Court)
            </h1>
        </div>
    </div>

    <!-- ================= MESSAGE ================= -->

    <div class="row justify-content-center">
        <div class="col-md-12 text-center">
            <span id="showmsg" style="display:none">
                <span id="info1"></span>
            </span>
        </div>
    </div>

    <!-- ================= MAIN CONTAINER ================= -->

    <div class="container-fluid vc-form">
        <div class="form">
            <div class="form-content">

                <!-- ================= SEARCH TYPE ================= -->

                <div class="row p-2">
                    <div class="col-md-4 text-right">
                        <label>Search Type</label>
                    </div>

                    <div class="col-md-6">
                        <input type="radio" name="search_type" value="P" onclick="toggleSearchType()" checked> Proceeded Records

                        &nbsp;&nbsp;

                        <input type="radio" name="search_type" value="S" onclick="toggleSearchType()">  Paid(Unsettled Records)
                    </div>
                </div>

                <div class="row p-2" id="settled_challan_section" style="display:none;">
                    <div class="col-md-4 text-right">
                        <span class="redStar">*</span>
                        <label>Challan No </label>
                    </div>

                    <div class="col-md-2">
                        <input type="text"
                            id="settled_challan_no"
                            name="settled_challan_no"
                            class="form-control"
                            oninput="allowAlphaNumericSlash(this);"
                            maxlength="30"
                            placeholder="Enter Challan Number">
                    </div>
                    <div class="col-md-2">
                        <input class='btnSubmit mydBtn ' style='margin-top: 0px !important' type='button' name='submitdata2' id='submitdata2' value='GO' onclick='javascript:settledCases(2);'>
                    </div>

                </div>



                <div class="row p-1" id='district_section'>
                    <div class="col-md-4" align="right"><span class='redStar'>*</span> <label>District</label></div>
                    <div class="col-md-3">
                        <select id='fdistrict_code' name='fdistrict_code' style="width: 300px;" class='chosen'>
                            <?php

                            //$query="select (case when d.national_code is null then d.lg_dcode else d.national_code end) as national_code,d.dist_name,count(1) as temp from civil_t a ,vc_case_details b, district_t d where a.cino=b.cino and (a.pay_contest is null or a.pay_contest='') and a.date_last_list is null and a.court_no=:court_no and (b.district_id=d.national_code ) and (a.cognidence_deniled!='Y' or a.cognidence_deniled is null) group by d.national_code,d.dist_name,d.lg_dcode";

                            //select (case when d.national_code is null then d.lg_dcode else d.national_code end) as national_code,d.dist_name,count(1) as temp from civil_t a ,vc_case_details b, district_t d ,court_t t where a.cino=b.cino and t.court_no=a.court_no and (a.pay_contest is null or a.pay_contest='') and a.date_last_list is null and a.court_no=:court_no and (b.district_id=d.national_code and b.district_id=ANY(string_to_array(t.district_ids,',')::bigint[])) and (a.cognidence_deniled!='Y' or a.cognidence_deniled is null) group by d.national_code,d.dist_name,d.lg_dcode

                            $query = "select 
    (case when d.national_code is null then d.lg_dcode else d.national_code end) as national_code,
    d.dist_name,
    count(1) as temp
from civil_t a,
     vc_case_details b, 
     district_t d,
     court_t t  
where a.cino = b.cino 
  and t.court_no = a.court_no 
  and (a.pay_contest is null or a.pay_contest = '') 
  and a.date_last_list is not null   
  and (circle_code > 0 or circle_code!=NULL ) 
  and a.court_no = :court_no
  and (b.district_id = d.national_code 
       and b.district_id = ANY(string_to_array(t.district_ids,',')::bigint[]) ) 
  and (a.cognidence_deniled = 'Y' or a.cognidence_deniled is not null) 
group by d.national_code, d.dist_name, d.lg_dcode";


                            $bindarr = array(':court_no' => $sessionCourt);
                            if ($_SERVER['HTTP_X_FORWARDED_FOR'] == '10.153.6.237') {
                                //echo "session->".$sessionCourt;
                                displayQuery($query, $bindarr);
                                exit;
                            }

                            $result = fetchQuery($query, $bindarr);
                            //$cnt=count($result);
                            echo "<option value=''>$labels[167]</option>";
                            //printArray($result);
                            //echo "megha";
                            foreach ($result as $val) {
                                $dist_code = $val['national_code'];
                                $dist_name = $val['dist_name'];
                                $temp = $val['temp'];

                                //echo $dist_code."megha";
                                //printArray($result);exit;
                                //echo "<option value='$dist_code' style='color:red;font-weight:bold;'>$dist_name ( Total Cases :$temp)</option>";
                                echo "<option  value='$dist_code'> $dist_name (Total cases : <span class='dd_cnt'>$temp</span>)</option>";
                            }



                            //echo fetchdistrictJson($sessionstate);

                            /*$sqlsrno ="select  district_ids from court_t where court_no=:court_no";
	$bindarr = array(':court_no'=>$sessionCourt);
	
	$rsltsrno = fetchQuerySingle($sqlsrno,$bindarr);
	$notify_court_id = trim($rsltsrno['district_ids']);
	$notify_district_array=explode(',',$notify_court_id);




	$str = file_get_contents('../dc_ncodes/nc_district_t.json');
	$json_arr = json_decode(stripslashes($str),true);
	$dist=$json_arr[$sessionstate];
	//printArray($json_arr);
	echo "<option value=''>$labels[167]</option>";

	foreach ($dist as $key => $value)
	{ 
		printArray($value);exit;
			$national_code=ltrim(($value['national_code']),'0');
			$district_code=$value['district_code'];
			$District_Name=$value['district_name']; 

			$query='select efilno from vc_case_details where district_id=:district_id';
			$bind=array(':district_id'=>$key);
			$rsltsrno = fetchQuerySingle($query,$bind);
			$cnt=count($rsltsrno);



			if(in_array($national_code,$notify_district_array))
				 echo "<option  value='$national_code'  > $District_Name.$cnt</option>";
			
	}
*/

                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <span id='fdistrict_code_error'></span>
                    </div>

                </div>

                <!--
<div class="row p-1">

<div class="col-md-3" align="right" >
   <label   >Vehicle Class : </label>
   </div>
   <div class="col-md-3">

<select name="vehicleclass" id="vehicleclass" class='form-control' >
	<option value=''  >Select</option> 
    <option value="MOTOR CYCLE LESS THAN 50CC (MC50CC)" title="MOTOR CYCLE LESS THAN 50CC (MC50CC)" style="cursor: pointer;">MOTOR CYCLE LESS THAN 50CC (MC50CC)</option>
    <option value="Motor cycle without Gear (Non Transport) (MCWOG)" title="Motor cycle without Gear (Non Transport) (MCWOG)" style="cursor: pointer;">Motor cycle without Gear (Non Transport) (MCWOG)</option>
    <option value="Motor Cycle with Gear(Non Transport) (MCWG)" title="Motor Cycle with Gear(Non Transport) (MCWG)" style="cursor: pointer;">Motor Cycle with Gear(Non Transport) (MCWG)</option>
    <option value="LMV-NT (LMV)" title="LMV-NT (LMV)" style="cursor: pointer; color: rgb(0, 0, 0);">LMV-NT (LMV)</option>
    <option value="LMV -3 Wheeler NT (3W-NT)" title="LMV -3 Wheeler NT (3W-NT)" style="cursor: pointer;">LMV -3 Wheeler NT (3W-NT)</option>
    <option value="LMV-Tractor-NT (TRCTOR)" title="LMV-Tractor-NT (TRCTOR)" style="cursor: pointer;">LMV-Tractor-NT (TRCTOR)</option>
    <option value="Invalid Carriage Vehicle (INVCRG)" title="Invalid Carriage Vehicle (INVCRG)" style="cursor: pointer;">Invalid Carriage Vehicle (INVCRG)</option>
    <option value="Road Roller (RDRLR)" title="Road Roller (RDRLR)" style="cursor: pointer;">Road Roller (RDRLR)</option>
    <option value="Other Others (OTHER)" title="Other Others (OTHER)" style="cursor: pointer;">Other Others (OTHER)</option>
    <option value="Others-Loader/Excavator (LDRXCV)" title="Others-Loader/Excavator (LDRXCV)" style="cursor: pointer;">Others-Loader/Excavator (LDRXCV)</option>
    <option value="Others-Cranes (CRANE)" title="Others-Cranes (CRANE)" style="cursor: pointer;">Others-Cranes (CRANE)</option>
    <option value="Others-ForkliftT (FLIFT)" title="Others-ForkliftT (FLIFT)" style="cursor: pointer;">Others-ForkliftT (FLIFT)</option>
    <option value="Others -Boring Rigg (BRIGS)" title="Others -Boring Rigg (BRIGS)" style="cursor: pointer;">Others -Boring Rigg (BRIGS)</option>
    <option value="Others - Construction Equipments (CNEQP)" title="Others - Construction Equipments (CNEQP)" style="cursor: pointer;">Others - Construction Equipments (CNEQP)</option>
    <option value="Invalid Carriage-2nd Vehicle (INVCG2)" title="Invalid Carriage-2nd Vehicle (INVCG2)" style="cursor: pointer;">Invalid Carriage-2nd Vehicle (INVCG2)</option>
    <option value="Invalid Carriage-3rd Vehicle (INVCG3)" title="Invalid Carriage-3rd Vehicle (INVCG3)" style="cursor: pointer;">Invalid Carriage-3rd Vehicle (INVCG3)</option>
    <option value="E-CART (eCART)" title="E-CART (eCART)" style="cursor: pointer;">E-CART (eCART)</option>
    <option value="E-RICKSHAW (eRIKSH)" title="E-RICKSHAW (eRIKSH)" style="cursor: pointer;">E-RICKSHAW (eRIKSH)</option>
    <option value="Others-Harvester (HARVST)" title="Others-Harvester (HARVST)" style="cursor: pointer; color: rgb(0, 0, 0);">Others-Harvester (HARVST)</option>
    <option value="Others-Trailers (TRAILR)" title="Others-Trailers (TRAILR)" style="cursor: pointer; color: rgb(0, 0, 0);">Others-Trailers (TRAILR)</option>
    <option value="Others-Agriculture Tractor and Power Tiller (AGRTLR)" title="Others-Agriculture Tractor and Power Tiller (AGRTLR)" style="cursor: pointer; color: rgb(0, 0, 0);">Others-Agriculture Tractor and Power Tiller (AGRTLR)</option>
    <option value="Others-Tow Trucks (TOWTRK)" title="Others-Tow Trucks (TOWTRK)" style="cursor: pointer; color: rgb(0, 0, 0);">Others-Tow Trucks (TOWTRK)</option>
    <option value="Others-Breakdown Van and Recovery Van (BRKREC)" title="Others-Breakdown Van and Recovery Van (BRKREC)" style="cursor: pointer; color: rgb(0, 0, 0);">Others-Breakdown Van and Recovery Van (BRKREC)</option>
</select>

	</div>

	<div class="col-md-2" align="right"> <label > Vehicle Type : </label></div>
	<div class="col-md-2"> 
	<select name='vehicletype' id='vehicletype' class='form-control' > 
	<option value=''  >Select</option> 
	<option value='1'>Two Wheel</option>
	<option value='2'>Three Wheel</option>
	<option value='3'>Four Wheeler</option>
	<optgroup label="Other Vehicles">
    <option value="4">Passenger Vehicles</option>
    <option value="5">Commercial Vehicles</option>
	<option value="6">Road Vehicles</option>
	<option value='7'>Motor Vehicles</option> 
	<option value='8'>Agricultural Vehicles</option> 
	<option value='9'>Heavy Duty Vehicles</option> 
  </optgroup>
   </select>
   </div>
   <div class="col-md-2" align="right"> </div>
   
</div>
-->
                <div id="act_section">
                    <?php actSectionComponentProc(1); ?>
                </div>



                <div class="row p-1">

                    <div class="col-md-12" align="center"><label> Note : </label> <i class="fa fa-star" style="color:red;" aria-hidden="true"></i> Indicate Imprisonment </div>

                    <div class="col-md-12" align="center" id='totalrecords' style='display:none;'><label>Total Number of Records </label> : <span id='tb_pg1'>0</span> </div>

                </div>


                <div id='dv_challan' class='popup' style="margin-left:20px;margin-top:20px;"></div>

                <div id='dv_trafficchallan' class='popup' style="margin-left:10px;margin-top:20px;margin-right:20px;"></div>





                <tbody id='showoutput' align='center'></tbody>


                <span class='tb_pg' align='center'></span>






                <table border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;" class="pr_tbl table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width:10%"><?php echo $allrecords_labels[529] ?><br>
                                <div id='selectall_div'>
                                    <input type='checkbox' name='selecctall' id='selecctall' onclick='javascript:selectall()' />
                                    <?php echo "Select All" ?>
                                </div>
                            </th>
                            <th colspan="2"><?php echo "Offence Details" ?></th>


                        </tr>

                    </thead>

                    <tbody id='label_app_court'></tbody>

                </table>



                <span class='tb_pg' align='center'></span>



                <div class="row p-1">
                    <div class="col-md-12 text-center">
                        <input class="btnSubmit mydBtn" type="button" style="display:none;" id="submitdata" name="submitdata" onclick="javascript:insert();" value='Submit'>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal fade " id="viewAgree">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <img id='trafficImage' src="" style="width: 100%">
                    </div>



                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btnSubmit mydBtn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
<script type="text/javascript" src="../js/dynamicdata.js"></script>
<script>
    var formfieldstest = <?php echo json_encode($data1); ?>;
    dynamicFormFields(formfieldstest);
</script>

</html>