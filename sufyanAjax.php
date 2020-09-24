<?php
$maddahId=$_GET['m'];

    $currDir=dirname(__FILE__);
    include("$currDir/defaultLang.php");
    include("$currDir/language.php");
    include("$currDir/lib.php");
    @include("$currDir/hooks/exams.php");
//first phase to create a new Daftar
//select Exam questionsto put in in an array 
$res1 = sql("SELECT  *
FROM  `question_score`
WHERE  `question_score`.`maddahID` ='".$maddahId."'
ORDER BY  `question_score`.`questionsNo` ", $eo);
	$tempArr="[";
	$i=0;
		while($row = db_fetch_assoc($res1)){
			$data[$i] = array_map('makeSafe', $row);
			$tempArr.= $row['questionID'].",";
			$i++;
		}
		$tempArr.="]";

?>	
<script type="text/javascript">
//console.log("jjj",<?php echo$maddahID; ?>)
	createTable(1,3,<?php echo $tempArr; ?>,<?php echo json_encode($data); ?>)
</script>

<?php

//second phase to store data question by question

	$o = array('silentErrors' => true);
	sql('insert into `dafater_score_by_question` set       `maddahID`=' . (($data['maddahID'] !== '' && $data['maddahID'] !== NULL) ? "'{$data['maddahID']}'" : 'NULL') . ', `boxNo`=' . (($data['boxNo'] !== '' && $data['boxNo'] !== NULL) ? "'{$data['boxNo']}'" : 'NULL') . ', `daftarNo`=' . (($data['daftarNo'] !== '' && $data['daftarNo'] !== NULL) ? "'{$data['daftarNo']}'" : 'NULL') . ', `questionNo`=' . (($data['questionNo'] !== '' && $data['questionNo'] !== NULL) ? "'{$data['questionNo']}'" : 'NULL') . ', `mark_1`=' . (($data['mark_1'] !== '' && $data['mark_1'] !== NULL) ? "'{$data['mark_1']}'" : 'NULL') . ', `mark_2`=' . (($data['mark_2'] !== '' && $data['mark_2'] !== NULL) ? "'{$data['mark_2']}'" : 'NULL') . ', `mark`=' . (($data['mark'] !== '' && $data['mark'] !== NULL) ? "'{$data['mark']}'" : 'NULL') . ', `note`=' . (($data['note'] !== '' && $data['note'] !== NULL) ? "'{$data['note']}'" : 'NULL') . ', `regIP`=' . "'{$data['regIP']}'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"dafater_score_by_question_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

