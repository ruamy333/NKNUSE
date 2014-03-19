
<!doctype html>
<html  lang="zh_tw">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../../css/common.css">
	<link rel="stylesheet" type="text/css" href="../../css/InputsStyle.css">
	<link rel="stylesheet" type="text/css" href="css/StudentAccount.css">
	<title>SED 平台管理系統</title>
</head>

<?
	include("../../common.php");
	include("../../../Controller/Student.php");
	include("../../../Controller/Field.php");
	include("../../../Controller/FieldRelate.php");
	include("../../../Controller/Grade.php");
	include("../../../Module/mysql.php");
	
	$view=new Common();
	$view->DrawHeader("WebAdmin");
	
	$db=new Mysql();
	$Students=new Student($db);
	$Grades=new Grade($db);
	$FieldRelates=new FieldRelate($db);
	$Fields=new Field($db);

	if(isset($_GET['Grade'])){
		$currentGrade = $_GET['Grade'];
	}
?>	
<div style="height: 20px;width:100%;"></div>
<div class="maincontent">
	<div class="GradeArea">
		<div class="ExplainTitle" style="margin-left: 15px;">學生資料匯出</div>
		<div class="GradeLine">
			<ul>
				<?
					$Grades->GetAll();
					while($Grades->HasNext())
					{
						if(!isset($_GET['Grade']))
						{
							$currentGrade=$Grades->GradeID;
							$_GET['Grade'] = $currentGrade;
						}
						echo '<li><a href="ExportData.php?Grade='.$Grades->GradeID.'">'.$Grades->GradeName.' ('.$Grades->IDToChinese($Grades->GradeName).')</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
	<div class="StudentArea">
		<form method="POST" action="StudentData.php?currentGrade=<?echo $currentGrade?>" enctype="application/x-www-form-urlencoded" target="_blank">
		<div class="ExplainTitle" style="margin-left: 15px;width:100%;"><?echo $Grades->IDToName($currentGrade)?>學生資料列表
		<input type = "submit" value="點此匯出為excel">
		</div>
		<div class="ExplainLine" style="width:100%; margin-left: 15px; margin-top:10px;">
		<table class="Table" style="width:95%;">
			<tr>
				<?
					$Fields->GetAll();
					echo '<td class="HeaderRow" style="color: white;">學號';
					while($Fields->HasNext())
					{
						echo'
						<td class="HeaderRow" style="color: white;">'.$Fields->FieldName.'
						<Input type="checkbox" name="excel[]" value='.$Fields->FieldID.' checked>
						</td>
							';
					}
				?>
			</tr>
			<?
				$IsUseOddStyle = True;
				$HasValue = False;
				$Students->GetByGradeID($currentGrade);
				while($Students->HasNext()){
					echo '<tr>';
					$FieldRelates->GetByStudentID($Students->StudentID);
					if($IsUseOddStyle)
						$Styles="DatarowOdd";
						else
						$Styles="DatarowEven";
						$IsUseOddStyle=!$IsUseOddStyle;
						echo '<td class="'.$Styles.'"><a target="_blank" href="ShowAStudent.php?SID='.$Students->StudentID.'" style="color:blue">'.$Students->StudentAccount.'</td>';
					while($FieldRelates->HasNext())
					{
						echo
						'
						<td class="'.$Styles.'">'.$FieldRelates->FieldRelateValue.'</td>
						';
						}
						echo '</tr>';
					}
	
		?>
		</table>
		</form>
	</div>
	</div>	
</div>	
<div style="height: 20px;width:100%;"></div>
<?
	$view->DrawFooter();
?>
</body>
</html>
