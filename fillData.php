<?php
    $currDir=dirname(__FILE__);
    include("$currDir/defaultLang.php");
    include("$currDir/language.php");
    include("$currDir/lib.php");
    include("$currDir/header.php");
    @include("$currDir/hooks/exams.php");
  
     
    //this is to control who can access page :) 
    $mi = getMemberInfo();
    if(!in_array($mi['group'], array('Admins', 'Dataentry'))){
        echo "Access denied";
        exit;
    }
?>
<!-- Modal -->
<div class="modal fade" id="wrongValue" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">خطأ في القيمة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       يرجى التاكد من القيمة المدخلة 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
        
      </div>
    </div>
  </div>
</div>
<script src="resources/sufyan.js">
 </script>
<script >
$j(function() { 
//when I chose exam check the value 
$j("#exams").on("change", function(){
	var t=($j("#exams").val());
	//console.log(typeof(t),t);
   $j.get("sufyanAjax.php?m="+t+"",

    function(data,status){
		//console.log(status);
     $j("#table").html(data);
    });


});


		// convert select tag to select2 
		$j("select").select2({
			dir: "rtl",
			dropdownAutoWidth: true,	
			allowClear: true
		});
		

});// end of JQuery
 </script>
<?php
//select Exam to put in in a list 
		$res = sql("SELECT * FROM `exams` ", $eo);
		$i=0;
		while($row = db_fetch_assoc($res)){
			$data[$i] = array_map('makeSafe', $row);
			?>
			<script>
				createListOptions(<?php echo json_encode($data[$i]); ?>);
			</script>
			<?php
			$i++;
		}
//var_dump($data[1]);
?>
<div class="row well well-sm" >
  <div class="col-sm-4">رقم الصندوق: <input type="number" id="boxNo" name="boxNo"> </div>
  <div class="col-sm-4">اختر مادة الامتحان:    <select id="exams" ><option value="0">مادة الامتحان</option>   </select>  </div>
  <div class="col-sm-4"></div>
</div>
   
<div class="row">
  <div class="col-sm-2"></div>
  <div class="col-sm-8 table-responsive"  id="table"></div>
  <div class="col-sm-2"></div>
</div>

