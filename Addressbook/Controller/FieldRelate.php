<?
//This class was generated by PHPDBParser(Java) at 2014/03/04 01:08:46
class FieldRelate
{
	//Mysql connection
	private $db;
	//Execute result
	private $Result;
	//rows number of result
	private $Rows;

	//Database fields
	public $FieldRelateID;
	public $FieldRelateStudentID;
	public $FieldRelateFieldID;
	public $FieldRelateValue;

	public function __construct($db)
	{
		$this->db=$db;
	}
	public function GetByValue($KeyValue)
	{
		$this->Rows=0;
		$sql = 'SELECT * FROM `fieldrelate` WHERE `FieldRelateValue` LIKE \'%'.$KeyValue.'%\' Group By `FieldRelateStudentID`';
		//store return data to $this->Result
		$this->Result=$this->db->query($sql);
		//count the numbers of return data and save to $this->Rows
		$this->Rows=$this->db->num_rows($this->Result);
	}
	public function Insert($StudentID,$FieldID)
	{
		$sql = 'INSERT INTO `FieldRelate` (`FieldRelateStudentID`,`FieldRelateFieldID`) 
		VALUES                            (\''.$StudentID.'\',\''.$FieldID.'\');';
		$this->db->query($sql);
	}

	public function UpdateValue($StudentID,$FieldID,$Value)
	{
		//看看此表有沒有BUG
		$sql='SELECT count(*) as total from `FieldRelate`  WHERE `FieldRelateStudentID` = \''.$StudentID.'\' AND `FieldRelateFieldID` = \''.$FieldID.'\';';
		 $result=$this->db->query($sql);
		$data=mysql_fetch_assoc($result);
		//若不見
		if($data['total']=="0")
		$this->Insert($StudentID,$FieldID);
		
		
		
		$sql = 'UPDATE `FieldRelate` SET 
		`FieldRelateValue`=\''.$Value.'\' 
		WHERE `FieldRelateStudentID` = \''.$StudentID.'\' AND `FieldRelateFieldID` = \''.$FieldID.'\';';
		$this->db->query($sql);
	}

	public function GetByStudentID($StudentID)
	{
		$this->Rows=0;
		$sql='SELECT * FROM `FieldRelate` WHERE FieldRelateStudentID =\''.$StudentID.'\' ORDER BY `FieldRelateID` ASC;';
		//store return data to $this->Result
		$this->Result=$this->db->query($sql);
		//count the numbers of return data and save to $this->Rows
		$this->Rows=$this->db->num_rows($this->Result);
	}

	public function DeleteByID($FieldRelateID)
	{
		$sql='DELETE from `FieldRelate` WHERE `FieldRelateID`=\''.$FieldRelateID.'\';';
		$this->db->query($sql);
	}
	
	public function DeleteByStudentID($StudentID)
	{
		$sql='DELETE from `FieldRelate` WHERE `FieldRelateStudentID`=\''.$StudentID.'\';';
		$this->db->query($sql);
	}
	
	public function DeleteByFieldID($FieldID)
	{
		$sql='DELETE from `FieldRelate` WHERE `FieldRelateFieldID`=\''.$FieldID.'\';';
		$this->db->query($sql);
	}

	public function HasNext()
	{
		if($this->Rows>0)
		{
			$temp=$this->db->fetch_array($this->Result);
			$this->FieldRelateID=$temp['FieldRelateID'];
			$this->FieldRelateStudentID=$temp['FieldRelateStudentID'];
			$this->FieldRelateFieldID=$temp['FieldRelateFieldID'];
			$this->FieldRelateValue=$temp['FieldRelateValue'];
			$this->Rows--;
			return true;
		}
		return false;
	}
}
///testing
 /*
include("mysql.php");
$fr = new FieldRelate(new Mysql());
$fr->UpdateValue(1,5,"20");
*/
?>