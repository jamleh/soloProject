//calculate final mark for each question
function calculate(a,b,c){
	//console.log(a,b,c)
	$j(function(){
	
	$j("#"+c).val((Number($j("#"+a).val())+Number($j("#"+b).val()))/2);
	});
}
function validate(id,i,j,qID){
	//console.log($j("#"+id).val(),id,i,data);
	$j("#input"+qID+i+(j-1)).css("background-color", "white");
	$j("#"+id).css("background-color", "white");
	if(Number($j("#"+id).val())>Number(data[i]['mark']) || Number($j("#"+id).val())<0){
		$j('#wrongValue').modal({   show: true    });
	$j("#"+id).val('');
	$j("#"+id).css("background-color", "red");
	}
	if(Number(j)===1){
		
		if(Math.abs(Number($j("#"+id).val())-Number($j("#input"+qID+i+(j-1)).val()))>data[i]['toleranceRatio']){
			$j("#"+id).css("background-color", "red");
			$j("#input"+qID+i+(j-1)).css("background-color", "red");
			$j('#wrongValue').modal({   show: true    });
		}
	}
	
}	

//create table
var data;
function createTable(id,colNo,rawNo,obj){
	if(!data){ data=obj; }
	
    console.log(id,colNo,rawNo,data);
    var t="<table border=0 id='id' class=\"table\"> <caption>دفتر رقم "+id+"</caption> <tbody><tr><th>رقم السؤال</th><th>علامة المصحح الأول</th><th>علامة المصحح الثاني</th><th>العلامة النهائية</th></tr>";
    for (var i=0;i<rawNo.length;i++){
        t+="<tr id='tr"+id+i+"'><td ><input type='hidden' name='qId"+(i+1)+"' value='"+rawNo[i]+"'>"+(i+1)+"</td>";
        for(var j=0;j<colNo;j++){
            //Disable last TD in each raw
            var tempClass="";calc="onfocusout='validate(this.id,"+i+","+j+","+id+")' ";
            //if (j===(colNo-1))tempClass="disabled=disabled";
            if (j===2)calc+="onfocus=calculate('input"+id+i+(j-2)+"','input"+id+i+(j-1)+"','input"+id+i+j+"')";
            t+="<td id='td"+id+i+j+"'><input type='number' id='input"+id+i+j+"' name='input"+id+i+j+"' "+calc+"></td>";

        }
        t+="</tr>";
    }
    t+="</tbody></table><br><button onclick=\"createTable("+(Number(id)+1)+",3,["+rawNo+"])\">اضافة دفتر</button>";   

//create table in page
$j("#table").html(t);


$j(function(){
// when press enter just go to the next input
$j("input").keyup(function (event) {
    if (event.keyCode == 13) {
        textboxes = $j("input");
        currentBoxNumber = textboxes.index(this);
        if (textboxes[currentBoxNumber + 1] != null) {
            nextBox = textboxes[currentBoxNumber + 1];
            nextBox.focus();
            nextBox.select();
        }

        event.preventDefault();
        return false;
    }
});

});         
}
//create Options for list exams
function createListOptions(a){
	//console.log(a);
			$j(function(){
			$j("#exams").append("<option value='"+a['mawadID']+"'>"+a['examName']+"</option>"); 
			});
}