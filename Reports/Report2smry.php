<?php
session_start();
ob_start();
?>
<?php include "phprptinc/ewrcfg4.php"; ?>
<?php include "phprptinc/ewmysql.php"; ?>
<?php include "phprptinc/ewrfn4.php"; ?>
<?php include "phprptinc/ewrusrfn.php"; ?>
<?php

// Global variable for table object
$Report2 = NULL;

//
// Table class for Report2
//
class crReport2 {
	var $TableVar = 'Report2';
	var $TableName = 'Report2';
	var $TableType = 'REPORT';
	var $ShowCurrentFilter = EWRPT_SHOW_CURRENT_FILTER;
	var $FilterPanelOption = EWRPT_FILTER_PANEL_OPTION;
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Table caption
	function TableCaption() {
		global $ReportLanguage;
		return $ReportLanguage->TablePhrase($this->TableVar, "TblCaption");
	}

	// Session Group Per Page
	function getGroupPerPage() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"];
	}

	function setGroupPerPage($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"] = $v;
	}

	// Session Start Group
	function getStartGroup() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"];
	}

	function setStartGroup($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"] = $v;
	}

	// Session Order By
	function getOrderBy() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"];
	}

	function setOrderBy($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"] = $v;
	}

//	var $SelectLimit = TRUE;
	var $Chart1;
	var $Chart2;
	var $First_Name;
	var $Last_Name;
	var $zEmail;
	var $Phone_No2E;
	var $Roll_No;
	var $Branch;
	var $UserName;
	var $Parents_No;
	var $Password;
	var $Confirm;
	var $Class_Name;
	var $fields = array();
	var $Export; // Export
	var $ExportAll = FALSE;
	var $UseTokenInUrl = EWRPT_USE_TOKEN_IN_URL;
	var $RowType; // Row type
	var $RowTotalType; // Row total type
	var $RowTotalSubType; // Row total subtype
	var $RowGroupLevel; // Row group level
	var $RowAttrs = array(); // Row attributes

	// Reset CSS styles for table object
	function ResetCSS() {
    	$this->RowAttrs["style"] = "";
		$this->RowAttrs["class"] = "";
		foreach ($this->fields as $fld) {
			$fld->ResetCSS();
		}
	}

	//
	// Table class constructor
	//
	function crReport2() {
		global $ReportLanguage;

		// First Name
		$this->First_Name = new crField('Report2', 'Report2', 'x_First_Name', 'First Name', 'students.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['First_Name'] =& $this->First_Name;
		$this->First_Name->DateFilter = "";
		$this->First_Name->SqlSelect = "";
		$this->First_Name->SqlOrderBy = "";

		// Last Name
		$this->Last_Name = new crField('Report2', 'Report2', 'x_Last_Name', 'Last Name', 'students.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Last_Name'] =& $this->Last_Name;
		$this->Last_Name->DateFilter = "";
		$this->Last_Name->SqlSelect = "";
		$this->Last_Name->SqlOrderBy = "";

		// Email
		$this->zEmail = new crField('Report2', 'Report2', 'x_zEmail', 'Email', 'students.email', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['zEmail'] =& $this->zEmail;
		$this->zEmail->DateFilter = "";
		$this->zEmail->SqlSelect = "";
		$this->zEmail->SqlOrderBy = "";

		// Phone No.
		$this->Phone_No2E = new crField('Report2', 'Report2', 'x_Phone_No2E', 'Phone No.', 'students.phone_no', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Phone_No2E'] =& $this->Phone_No2E;
		$this->Phone_No2E->DateFilter = "";
		$this->Phone_No2E->SqlSelect = "";
		$this->Phone_No2E->SqlOrderBy = "";

		// Roll No
		$this->Roll_No = new crField('Report2', 'Report2', 'x_Roll_No', 'Roll No', 'students.rollno', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Roll_No->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Roll_No'] =& $this->Roll_No;
		$this->Roll_No->DateFilter = "";
		$this->Roll_No->SqlSelect = "";
		$this->Roll_No->SqlOrderBy = "";

		// Branch
		$this->Branch = new crField('Report2', 'Report2', 'x_Branch', 'Branch', 'students.branch', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Branch'] =& $this->Branch;
		$this->Branch->DateFilter = "";
		$this->Branch->SqlSelect = "SELECT DISTINCT students.branch FROM " . $this->SqlFrom();
		$this->Branch->SqlOrderBy = "students.branch";

		// UserName
		$this->UserName = new crField('Report2', 'Report2', 'x_UserName', 'UserName', 'students.username', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['UserName'] =& $this->UserName;
		$this->UserName->DateFilter = "";
		$this->UserName->SqlSelect = "";
		$this->UserName->SqlOrderBy = "";

		// Parents No
		$this->Parents_No = new crField('Report2', 'Report2', 'x_Parents_No', 'Parents No', 'students.parentsno', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Parents_No'] =& $this->Parents_No;
		$this->Parents_No->DateFilter = "";
		$this->Parents_No->SqlSelect = "";
		$this->Parents_No->SqlOrderBy = "";

		// Password
		$this->Password = new crField('Report2', 'Report2', 'x_Password', 'Password', 'students.password', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Password'] =& $this->Password;
		$this->Password->DateFilter = "";
		$this->Password->SqlSelect = "";
		$this->Password->SqlOrderBy = "";

		// Confirm
		$this->Confirm = new crField('Report2', 'Report2', 'x_Confirm', 'Confirm', 'students.confirm', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Confirm->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Confirm'] =& $this->Confirm;
		$this->Confirm->DateFilter = "";
		$this->Confirm->SqlSelect = "SELECT DISTINCT students.confirm FROM " . $this->SqlFrom();
		$this->Confirm->SqlOrderBy = "students.confirm";

		// Class Name
		$this->Class_Name = new crField('Report2', 'Report2', 'x_Class_Name', 'Class Name', 'class.class', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Class_Name'] =& $this->Class_Name;
		$this->Class_Name->DateFilter = "";
		$this->Class_Name->SqlSelect = "SELECT DISTINCT class.class FROM " . $this->SqlFrom();
		$this->Class_Name->SqlOrderBy = "class.class";

		// Chart1
		$this->Chart1 = new crChart('Report2', 'Report2', 'Chart1', 'Chart1', 'Class Name', 'First Name', '', 6, 'SUM', 550, 440);
		$this->Chart1->SqlSelect = "SELECT `Class Name`, '', SUM(`First Name`) FROM ";
		$this->Chart1->SqlGroupBy = "`Class Name`";
		$this->Chart1->SqlOrderBy = "";
		$this->Chart1->SeriesDateType = "";

		// Chart2
		$this->Chart2 = new crChart('Report2', 'Report2', 'Chart2', 'Chart2', 'Class Name', 'First Name', '', 5, 'SUM', 550, 440);
		$this->Chart2->SqlSelect = "SELECT `Class Name`, '', SUM(`First Name`) FROM ";
		$this->Chart2->SqlGroupBy = "`Class Name`";
		$this->Chart2->SqlOrderBy = "";
		$this->Chart2->SeriesDateType = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "students Inner Join class On class.class_id = students.class_id";
	}

	function SqlSelect() { // Select
		return "SELECT students.first_name As `First Name`, students.last_name As `Last Name`, students.email As Email, students.phone_no As `Phone No.`, students.rollno As `Roll No`, students.branch As Branch, students.username As UserName, students.parentsno As `Parents No`, students.password As Password, students.confirm As Confirm, class.class As `Class Name` FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "";
	}

	function SqlSelectAgg() {
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlAggPfx() {
		return "";
	}

	function SqlAggSfx() {
		return "";
	}

	function SqlSelectCount() {
		return "SELECT COUNT(*) FROM " . $this->SqlFrom();
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = "";
		foreach ($this->RowAttrs as $k => $v) {
			if (trim($v) <> "")
				$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
		}
		return $sAtt;
	}

	// Field object by fldvar
	function &fields($fldvar) {
		return $this->fields[$fldvar];
	}

	// Table level events
	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Load Custom Filters event
	function CustomFilters_Load() {

		// Enter your code here	
		// ewrpt_RegisterCustomFilter($this-><Field>, 'LastMonth', 'Last Month', 'GetLastMonthFilter'); // Date example
		// ewrpt_RegisterCustomFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // String example

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//global $MyTable;
		//$MyTable->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Chart Rendering event
	function Chart_Rendering(&$chart) {

		// var_dump($chart);
	}

	// Chart Rendered event
	function Chart_Rendered($chart, &$chartxml) {

		//var_dump($chart);
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$Report2_summary = new crReport2_summary();
$Page =& $Report2_summary;

// Page init
$Report2_summary->Page_Init();

// Page main
$Report2_summary->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Report2->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Report2_summary->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Report2_summary->ShowMessage(); ?>
<?php if ($Report2->Export == "" || $Report2->Export == "print" || $Report2->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Report2->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
<?php $jsdata = ewrpt_GetJsData($Report2->Branch, $Report2->Branch->FldType); ?>
ewrpt_CreatePopup("Report2_Branch", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($Report2->Confirm, $Report2->Confirm->FldType); ?>
ewrpt_CreatePopup("Report2_Confirm", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($Report2->Class_Name, $Report2->Class_Name->FldType); ?>
ewrpt_CreatePopup("Report2_Class_Name", [<?php echo $jsdata ?>]);
</script>
<div id="Report2_Branch_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report2_Confirm_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report2_Class_Name_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if ($Report2->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Report2->Export == "" || $Report2->Export == "print" || $Report2->Export == "email") { ?>
<?php } ?>
<?php echo $Report2->TableCaption() ?>
<?php if ($Report2->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Report2_summary->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php if ($Report2_summary->FilterApplied) { ?>
&nbsp;&nbsp;<a href="Report2smry.php?cmd=reset"><?php echo $ReportLanguage->Phrase("ResetAllFilter") ?></a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if ($Report2->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Report2->Export == "" || $Report2->Export == "print" || $Report2->Export == "email") { ?>
<?php } ?>
<?php if ($Report2->Export == "") { ?>
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<?php if ($Report2->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $Report2_summary->ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if ($Report2->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Report2smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report2_summary->StartGrp, $Report2_summary->DisplayGrps, $Report2_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("of") ?> <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Report2_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report2_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report2_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report2_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report2_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report2_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report2_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report2_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report2_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report2_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report2->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($Report2->ExportAll && $Report2->Export <> "") {
	$Report2_summary->StopGrp = $Report2_summary->TotalGrps;
} else {
	$Report2_summary->StopGrp = $Report2_summary->StartGrp + $Report2_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Report2_summary->StopGrp) > intval($Report2_summary->TotalGrps))
	$Report2_summary->StopGrp = $Report2_summary->TotalGrps;
$Report2_summary->RecCount = 0;

// Get first row
if ($Report2_summary->TotalGrps > 0) {
	$Report2_summary->GetRow(1);
	$Report2_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Report2_summary->GrpCount <= $Report2_summary->DisplayGrps) || $Report2_summary->ShowFirstHeader) {

	// Show header
	if ($Report2_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->First_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->First_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->First_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->First_Name) ?>',0);"><?php echo $Report2->First_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->First_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->First_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Last_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Last_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Last_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Last_Name) ?>',0);"><?php echo $Report2->Last_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Last_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Last_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->zEmail->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->zEmail) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->zEmail->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->zEmail) ?>',0);"><?php echo $Report2->zEmail->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->zEmail->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->zEmail->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Phone_No2E->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Phone_No2E) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Phone_No2E->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Phone_No2E) ?>',0);"><?php echo $Report2->Phone_No2E->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Phone_No2E->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Phone_No2E->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Roll_No->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Roll_No) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Roll_No->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Roll_No) ?>',0);"><?php echo $Report2->Roll_No->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Roll_No->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Roll_No->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Branch->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Branch) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Branch->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Branch) ?>',0);"><?php echo $Report2->Branch->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Branch->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Branch->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report2_Branch', false, '<?php echo $Report2->Branch->RangeFrom; ?>', '<?php echo $Report2->Branch->RangeTo; ?>');return false;" name="x_Branch<?php echo $Report2_summary->Cnt[0][0]; ?>" id="x_Branch<?php echo $Report2_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->UserName->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->UserName) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->UserName->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->UserName) ?>',0);"><?php echo $Report2->UserName->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->UserName->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->UserName->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Parents_No->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Parents_No) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Parents_No->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Parents_No) ?>',0);"><?php echo $Report2->Parents_No->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Parents_No->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Parents_No->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Password->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Password) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Password->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Password) ?>',0);"><?php echo $Report2->Password->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Password->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Password->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Confirm->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Confirm) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Confirm->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Confirm) ?>',0);"><?php echo $Report2->Confirm->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Confirm->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Confirm->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report2_Confirm', false, '<?php echo $Report2->Confirm->RangeFrom; ?>', '<?php echo $Report2->Confirm->RangeTo; ?>');return false;" name="x_Confirm<?php echo $Report2_summary->Cnt[0][0]; ?>" id="x_Confirm<?php echo $Report2_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report2->Export <> "") { ?>
<?php echo $Report2->Class_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report2->SortUrl($Report2->Class_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report2->Class_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report2->SortUrl($Report2->Class_Name) ?>',0);"><?php echo $Report2->Class_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report2->Class_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report2->Class_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report2_Class_Name', false, '<?php echo $Report2->Class_Name->RangeFrom; ?>', '<?php echo $Report2->Class_Name->RangeTo; ?>');return false;" name="x_Class_Name<?php echo $Report2_summary->Cnt[0][0]; ?>" id="x_Class_Name<?php echo $Report2_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Report2_summary->ShowFirstHeader = FALSE;
	}
	$Report2_summary->RecCount++;

		// Render detail row
		$Report2->ResetCSS();
		$Report2->RowType = EWRPT_ROWTYPE_DETAIL;
		$Report2_summary->RenderRow();
?>
	<tr<?php echo $Report2->RowAttributes(); ?>>
		<td<?php echo $Report2->First_Name->CellAttributes() ?>>
<div<?php echo $Report2->First_Name->ViewAttributes(); ?>><?php echo $Report2->First_Name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Last_Name->CellAttributes() ?>>
<div<?php echo $Report2->Last_Name->ViewAttributes(); ?>><?php echo $Report2->Last_Name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->zEmail->CellAttributes() ?>>
<div<?php echo $Report2->zEmail->ViewAttributes(); ?>><?php echo $Report2->zEmail->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Phone_No2E->CellAttributes() ?>>
<div<?php echo $Report2->Phone_No2E->ViewAttributes(); ?>><?php echo $Report2->Phone_No2E->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Roll_No->CellAttributes() ?>>
<div<?php echo $Report2->Roll_No->ViewAttributes(); ?>><?php echo $Report2->Roll_No->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Branch->CellAttributes() ?>>
<div<?php echo $Report2->Branch->ViewAttributes(); ?>><?php echo $Report2->Branch->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->UserName->CellAttributes() ?>>
<div<?php echo $Report2->UserName->ViewAttributes(); ?>><?php echo $Report2->UserName->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Parents_No->CellAttributes() ?>>
<div<?php echo $Report2->Parents_No->ViewAttributes(); ?>><?php echo $Report2->Parents_No->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Password->CellAttributes() ?>>
<div<?php echo $Report2->Password->ViewAttributes(); ?>><?php echo $Report2->Password->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Confirm->CellAttributes() ?>>
<div<?php echo $Report2->Confirm->ViewAttributes(); ?>><?php echo $Report2->Confirm->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report2->Class_Name->CellAttributes() ?>>
<div<?php echo $Report2->Class_Name->ViewAttributes(); ?>><?php echo $Report2->Class_Name->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Report2_summary->AccumulateSummary();

		// Get next record
		$Report2_summary->GetRow(2);
	$Report2_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Report2_summary->TotalGrps > 0) {
	$Report2->ResetCSS();
	$Report2->RowType = EWRPT_ROWTYPE_TOTAL;
	$Report2->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Report2->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Report2->RowAttrs["class"] = "ewRptGrandSummary";
	$Report2_summary->RenderRow();
?>
	<!-- tr><td colspan="11"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Report2->RowAttributes(); ?>><td colspan="11"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Report2_summary->TotCount,0,-2,-2,-2); ?> <?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Report2_summary->TotalGrps > 0) { ?>
<?php if ($Report2->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report2smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report2_summary->StartGrp, $Report2_summary->DisplayGrps, $Report2_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report2smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("of") ?> <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Report2_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report2_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report2_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report2_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report2_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report2_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report2_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report2_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report2_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report2_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report2->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if ($Report2->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Report2->Export == "" || $Report2->Export == "print" || $Report2->Export == "email") { ?>
<?php } ?>
<?php if ($Report2->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Report2->Export == "" || $Report2->Export == "print" || $Report2->Export == "email") { ?>
<a name="cht_Chart1"></a>
<div id="div_Report2_Chart1"></div>
<?php

// Initialize chart data
$Report2->Chart1->ID = "Report2_Chart1"; // Chart ID
$Report2->Chart1->SetChartParam("type", "6", FALSE); // Chart type
$Report2->Chart1->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report2->Chart1->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report2->Chart1->SetChartParam("caption", $Report2->Chart1->ChartCaption(), TRUE); // Chart caption
$Report2->Chart1->SetChartParam("xaxisname", $Report2->Chart1->ChartXAxisName(), TRUE); // X axis name
$Report2->Chart1->SetChartParam("yaxisname", $Report2->Chart1->ChartYAxisName(), TRUE); // Y axis name
$Report2->Chart1->SetChartParam("shownames", "1", TRUE); // Show names
$Report2->Chart1->SetChartParam("showvalues", "1", TRUE); // Show values
$Report2->Chart1->SetChartParam("showhovercap", "0", TRUE); // Show hover
$Report2->Chart1->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report2->Chart1->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report2->Chart1->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report2->Chart1->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report2->Chart1->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report2->Chart1->SetChartParam("animation", "1", TRUE); // animation
$Report2->Chart1->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report2->Chart1->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report2->Chart1->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report2->Chart1->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report2->Chart1->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report2->Chart1->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report2->Chart1->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report2->Chart1->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report2->Chart1->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report2->Chart1->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report2->Chart1->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report2->Chart1->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report2->Chart1->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report2->Chart1->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report2->Chart1->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report2->Chart1->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report2->Chart1->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report2->Chart1->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report2->Chart1->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report2->Chart1->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report2->Chart1->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report2->Chart1->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report2->Chart1->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report2->Chart1->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report2->Chart1->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report2->Chart1->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report2->Chart1->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report2->Chart1->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report2->SqlSelect();
$SqlChartSelect = $Report2->Chart1->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->SqlOrderBy(), $Report2_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report2->Chart1->SqlGroupBy, "", $Report2->Chart1->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report2->Chart1);
ewrpt_SortChartData($Report2->Chart1->Data, 0, "");

// Call Chart_Rendering event
$Report2->Chart_Rendering($Report2->Chart1);
$chartxml = $Report2->Chart1->ChartXml();

// Call Chart_Rendered event
$Report2->Chart_Rendered($Report2->Chart1, $chartxml);
echo $Report2->Chart1->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<a name="cht_Chart2"></a>
<div id="div_Report2_Chart2"></div>
<?php

// Initialize chart data
$Report2->Chart2->ID = "Report2_Chart2"; // Chart ID
$Report2->Chart2->SetChartParam("type", "5", FALSE); // Chart type
$Report2->Chart2->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report2->Chart2->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report2->Chart2->SetChartParam("caption", $Report2->Chart2->ChartCaption(), TRUE); // Chart caption
$Report2->Chart2->SetChartParam("xaxisname", $Report2->Chart2->ChartXAxisName(), TRUE); // X axis name
$Report2->Chart2->SetChartParam("yaxisname", $Report2->Chart2->ChartYAxisName(), TRUE); // Y axis name
$Report2->Chart2->SetChartParam("shownames", "1", TRUE); // Show names
$Report2->Chart2->SetChartParam("showvalues", "1", TRUE); // Show values
$Report2->Chart2->SetChartParam("showhovercap", "0", TRUE); // Show hover
$Report2->Chart2->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report2->Chart2->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report2->Chart2->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report2->Chart2->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report2->Chart2->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report2->Chart2->SetChartParam("animation", "1", TRUE); // animation
$Report2->Chart2->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report2->Chart2->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report2->Chart2->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report2->Chart2->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report2->Chart2->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report2->Chart2->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report2->Chart2->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report2->Chart2->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report2->Chart2->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report2->Chart2->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report2->Chart2->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report2->Chart2->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report2->Chart2->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report2->Chart2->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report2->Chart2->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report2->Chart2->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report2->Chart2->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report2->Chart2->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report2->Chart2->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report2->Chart2->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report2->Chart2->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report2->Chart2->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report2->Chart2->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report2->Chart2->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report2->Chart2->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report2->Chart2->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report2->Chart2->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report2->Chart2->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report2->SqlSelect();
$SqlChartSelect = $Report2->Chart2->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->SqlOrderBy(), $Report2_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report2->Chart2->SqlGroupBy, "", $Report2->Chart2->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report2->Chart2);
ewrpt_SortChartData($Report2->Chart2->Data, 0, "");

// Call Chart_Rendering event
$Report2->Chart_Rendering($Report2->Chart2);
$chartxml = $Report2->Chart2->ChartXml();

// Call Chart_Rendered event
$Report2->Chart_Rendered($Report2->Chart2, $chartxml);
echo $Report2->Chart2->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<?php } ?>
<?php if ($Report2->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Report2_summary->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Report2->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Report2_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crReport2_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Report2';

	// Page object name
	var $PageObjName = 'Report2_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Report2;
		if ($Report2->UseTokenInUrl) $PageUrl .= "t=" . $Report2->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EWRPT_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EWRPT_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EWRPT_SESSION_MESSAGE] .= "<br />" . $v;
		} else {
			$_SESSION[EWRPT_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EWRPT_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sHeader . "</span></p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sFooter . "</span></p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $Report2;
		if ($Report2->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Report2->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Report2->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crReport2_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Report2)
		$GLOBALS["Report2"] = new crReport2();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Report2', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		$conn = ewrpt_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ReportLanguage, $Security;
		global $Report2;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Report2->Export = $_GET["export"];
	}
	$gsExport = $Report2->Export; // Get export parameter, used in header
	$gsExportFile = $Report2->TableVar; // Get export file, used in header

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;
		global $ReportLanguage;
		global $Report2;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Report2->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWRPT_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	// Paging variables

	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $DisplayGrps = 3; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $UserIDFilter = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $FilterApplied;
	var $ShowFirstHeader;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;

	//
	// Page main
	//
	function Page_Main() {
		global $Report2;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 12;
		$nGrps = 1;
		$this->Val = ewrpt_InitArray($nDtls, 0);
		$this->Cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandSmry = ewrpt_InitArray($nDtls, 0);
		$this->GrandMn = ewrpt_InitArray($nDtls, NULL);
		$this->GrandMx = ewrpt_InitArray($nDtls, NULL);

		// Set up if accumulation required
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();
		$Report2->Branch->SelectionList = "";
		$Report2->Branch->DefaultSelectionList = "";
		$Report2->Branch->ValueList = "";
		$Report2->Confirm->SelectionList = "";
		$Report2->Confirm->DefaultSelectionList = "";
		$Report2->Confirm->ValueList = "";
		$Report2->Class_Name->SelectionList = "";
		$Report2->Class_Name->DefaultSelectionList = "";
		$Report2->Class_Name->ValueList = "";

		// Load default filter values
		$this->LoadDefaultFilters();

		// Set up popup filter
		$this->SetupPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewrpt_SetDebugMsg("popup filter: " . $sPopupFilter);
		if ($sPopupFilter <> "") {
			if ($this->Filter <> "")
				$this->Filter = "($this->Filter) AND ($sPopupFilter)";
			else
				$this->Filter = $sPopupFilter;
		}

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($Report2->SqlSelect(), $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Report2->ExportAll && $Report2->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy]++;
				if ($this->Col[$iy]) {
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk) || !is_numeric($valwrk)) {

						// skip
					} else {
						$this->Smry[$ix][$iy] += $valwrk;
						if (is_null($this->Mn[$ix][$iy])) {
							$this->Mn[$ix][$iy] = $valwrk;
							$this->Mx[$ix][$iy] = $valwrk;
						} else {
							if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
							if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 1; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->Cnt[0][0]++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$this->GrandSmry[$iy] += $valwrk;
					if (is_null($this->GrandMn[$iy])) {
						$this->GrandMn[$iy] = $valwrk;
						$this->GrandMx[$iy] = $valwrk;
					} else {
						if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
						if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		global $conn;
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get rs
	function GetRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		global $Report2;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Report2->First_Name->setDbValue($rs->fields('First Name'));
			$Report2->Last_Name->setDbValue($rs->fields('Last Name'));
			$Report2->zEmail->setDbValue($rs->fields('Email'));
			$Report2->Phone_No2E->setDbValue($rs->fields('Phone No.'));
			$Report2->Roll_No->setDbValue($rs->fields('Roll No'));
			$Report2->Branch->setDbValue($rs->fields('Branch'));
			$Report2->UserName->setDbValue($rs->fields('UserName'));
			$Report2->Parents_No->setDbValue($rs->fields('Parents No'));
			$Report2->Password->setDbValue($rs->fields('Password'));
			$Report2->Confirm->setDbValue($rs->fields('Confirm'));
			$Report2->Class_Name->setDbValue($rs->fields('Class Name'));
			$this->Val[1] = $Report2->First_Name->CurrentValue;
			$this->Val[2] = $Report2->Last_Name->CurrentValue;
			$this->Val[3] = $Report2->zEmail->CurrentValue;
			$this->Val[4] = $Report2->Phone_No2E->CurrentValue;
			$this->Val[5] = $Report2->Roll_No->CurrentValue;
			$this->Val[6] = $Report2->Branch->CurrentValue;
			$this->Val[7] = $Report2->UserName->CurrentValue;
			$this->Val[8] = $Report2->Parents_No->CurrentValue;
			$this->Val[9] = $Report2->Password->CurrentValue;
			$this->Val[10] = $Report2->Confirm->CurrentValue;
			$this->Val[11] = $Report2->Class_Name->CurrentValue;
		} else {
			$Report2->First_Name->setDbValue("");
			$Report2->Last_Name->setDbValue("");
			$Report2->zEmail->setDbValue("");
			$Report2->Phone_No2E->setDbValue("");
			$Report2->Roll_No->setDbValue("");
			$Report2->Branch->setDbValue("");
			$Report2->UserName->setDbValue("");
			$Report2->Parents_No->setDbValue("");
			$Report2->Password->setDbValue("");
			$Report2->Confirm->setDbValue("");
			$Report2->Class_Name->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Report2;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Report2->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Report2->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Report2->getStartGroup();
			}
		} else {
			$this->StartGrp = $Report2->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Report2->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Report2->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Report2->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Report2;

		// Initialize popup
		// Build distinct values for Branch

		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report2->Branch->SqlSelect, $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->Branch->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report2->Branch->setDbValue($rswrk->fields[0]);
			if (is_null($Report2->Branch->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report2->Branch->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report2->Branch->ViewValue = $Report2->Branch->CurrentValue;
				ewrpt_SetupDistinctValues($Report2->Branch->ValueList, $Report2->Branch->CurrentValue, $Report2->Branch->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report2->Branch->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report2->Branch->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

		// Build distinct values for Confirm
		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report2->Confirm->SqlSelect, $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->Confirm->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report2->Confirm->setDbValue($rswrk->fields[0]);
			if (is_null($Report2->Confirm->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report2->Confirm->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report2->Confirm->ViewValue = $Report2->Confirm->CurrentValue;
				ewrpt_SetupDistinctValues($Report2->Confirm->ValueList, $Report2->Confirm->CurrentValue, $Report2->Confirm->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report2->Confirm->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report2->Confirm->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

		// Build distinct values for Class Name
		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report2->Class_Name->SqlSelect, $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), $Report2->Class_Name->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report2->Class_Name->setDbValue($rswrk->fields[0]);
			if (is_null($Report2->Class_Name->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report2->Class_Name->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report2->Class_Name->ViewValue = $Report2->Class_Name->CurrentValue;
				ewrpt_SetupDistinctValues($Report2->Class_Name->ValueList, $Report2->Class_Name->CurrentValue, $Report2->Class_Name->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report2->Class_Name->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report2->Class_Name->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

		// Process post back form
		if (ewrpt_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWRPT_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ClearSessionSelection('Branch');
				$this->ClearSessionSelection('Confirm');
				$this->ClearSessionSelection('Class_Name');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get branch selected values

		if (is_array(@$_SESSION["sel_Report2_Branch"])) {
			$this->LoadSelectionFromSession('Branch');
		} elseif (@$_SESSION["sel_Report2_Branch"] == EWRPT_INIT_VALUE) { // Select all
			$Report2->Branch->SelectionList = "";
		}

		// Get confirm selected values
		if (is_array(@$_SESSION["sel_Report2_Confirm"])) {
			$this->LoadSelectionFromSession('Confirm');
		} elseif (@$_SESSION["sel_Report2_Confirm"] == EWRPT_INIT_VALUE) { // Select all
			$Report2->Confirm->SelectionList = "";
		}

		// Get class selected values
		if (is_array(@$_SESSION["sel_Report2_Class_Name"])) {
			$this->LoadSelectionFromSession('Class_Name');
		} elseif (@$_SESSION["sel_Report2_Class_Name"] == EWRPT_INIT_VALUE) { // Select all
			$Report2->Class_Name->SelectionList = "";
		}
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		global $Report2;
		$this->StartGrp = 1;
		$Report2->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Report2;
		$sWrk = @$_GET[EWRPT_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 3; // Non-numeric, load default
				}
			}
			$Report2->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Report2->setStartGroup($this->StartGrp);
		} else {
			if ($Report2->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Report2->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Report2;
		if ($Report2->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Report2->SqlSelectCount(), $Report2->SqlWhere(), $Report2->SqlGroupBy(), $Report2->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Report2->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Report2->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// First Name
			$Report2->First_Name->ViewValue = $Report2->First_Name->Summary;

			// Last Name
			$Report2->Last_Name->ViewValue = $Report2->Last_Name->Summary;

			// Email
			$Report2->zEmail->ViewValue = $Report2->zEmail->Summary;

			// Phone No.
			$Report2->Phone_No2E->ViewValue = $Report2->Phone_No2E->Summary;

			// Roll No
			$Report2->Roll_No->ViewValue = $Report2->Roll_No->Summary;

			// Branch
			$Report2->Branch->ViewValue = $Report2->Branch->Summary;

			// UserName
			$Report2->UserName->ViewValue = $Report2->UserName->Summary;

			// Parents No
			$Report2->Parents_No->ViewValue = $Report2->Parents_No->Summary;

			// Password
			$Report2->Password->ViewValue = $Report2->Password->Summary;

			// Confirm
			$Report2->Confirm->ViewValue = $Report2->Confirm->Summary;

			// Class Name
			$Report2->Class_Name->ViewValue = $Report2->Class_Name->Summary;
		} else {

			// First Name
			$Report2->First_Name->ViewValue = $Report2->First_Name->CurrentValue;
			$Report2->First_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Last Name
			$Report2->Last_Name->ViewValue = $Report2->Last_Name->CurrentValue;
			$Report2->Last_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Email
			$Report2->zEmail->ViewValue = $Report2->zEmail->CurrentValue;
			$Report2->zEmail->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Phone No.
			$Report2->Phone_No2E->ViewValue = $Report2->Phone_No2E->CurrentValue;
			$Report2->Phone_No2E->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Roll No
			$Report2->Roll_No->ViewValue = $Report2->Roll_No->CurrentValue;
			$Report2->Roll_No->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Branch
			$Report2->Branch->ViewValue = $Report2->Branch->CurrentValue;
			$Report2->Branch->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// UserName
			$Report2->UserName->ViewValue = $Report2->UserName->CurrentValue;
			$Report2->UserName->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Parents No
			$Report2->Parents_No->ViewValue = $Report2->Parents_No->CurrentValue;
			$Report2->Parents_No->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Password
			$Report2->Password->ViewValue = $Report2->Password->CurrentValue;
			$Report2->Password->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Confirm
			$Report2->Confirm->ViewValue = $Report2->Confirm->CurrentValue;
			$Report2->Confirm->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Class Name
			$Report2->Class_Name->ViewValue = $Report2->Class_Name->CurrentValue;
			$Report2->Class_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// First Name
		$Report2->First_Name->HrefValue = "";

		// Last Name
		$Report2->Last_Name->HrefValue = "";

		// Email
		$Report2->zEmail->HrefValue = "";

		// Phone No.
		$Report2->Phone_No2E->HrefValue = "";

		// Roll No
		$Report2->Roll_No->HrefValue = "";

		// Branch
		$Report2->Branch->HrefValue = "";

		// UserName
		$Report2->UserName->HrefValue = "";

		// Parents No
		$Report2->Parents_No->HrefValue = "";

		// Password
		$Report2->Password->HrefValue = "";

		// Confirm
		$Report2->Confirm->HrefValue = "";

		// Class Name
		$Report2->Class_Name->HrefValue = "";

		// Call Row_Rendered event
		$Report2->Row_Rendered();
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_Report2_$parm"] = "";
		$_SESSION["rf_Report2_$parm"] = "";
		$_SESSION["rt_Report2_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $Report2;
		$fld =& $Report2->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Report2_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Report2_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Report2_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $Report2;

		/**
		* Set up default values for non Text filters
		*/

		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		/**
		* Set up default values for popup filters
		* NOTE: if extended filter is enabled, use default values in extended filter instead
		*/

		// Field Branch
		// Setup your default values for the popup filter below, e.g.
		// $Report2->Branch->DefaultSelectionList = array("val1", "val2");

		$Report2->Branch->DefaultSelectionList = "";
		$Report2->Branch->SelectionList = $Report2->Branch->DefaultSelectionList;

		// Field Confirm
		// Setup your default values for the popup filter below, e.g.
		// $Report2->Confirm->DefaultSelectionList = array("val1", "val2");

		$Report2->Confirm->DefaultSelectionList = "";
		$Report2->Confirm->SelectionList = $Report2->Confirm->DefaultSelectionList;

		// Field Class Name
		// Setup your default values for the popup filter below, e.g.
		// $Report2->Class_Name->DefaultSelectionList = array("val1", "val2");

		$Report2->Class_Name->DefaultSelectionList = "";
		$Report2->Class_Name->SelectionList = $Report2->Class_Name->DefaultSelectionList;
	}

	// Check if filter applied
	function CheckFilter() {
		global $Report2;

		// Check Branch popup filter
		if (!ewrpt_MatchedArray($Report2->Branch->DefaultSelectionList, $Report2->Branch->SelectionList))
			return TRUE;

		// Check Confirm popup filter
		if (!ewrpt_MatchedArray($Report2->Confirm->DefaultSelectionList, $Report2->Confirm->SelectionList))
			return TRUE;

		// Check Class Name popup filter
		if (!ewrpt_MatchedArray($Report2->Class_Name->DefaultSelectionList, $Report2->Class_Name->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $Report2;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field Branch
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report2->Branch->SelectionList))
			$sWrk = ewrpt_JoinArray($Report2->Branch->SelectionList, ", ", EWRPT_DATATYPE_STRING);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report2->Branch->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field Confirm
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report2->Confirm->SelectionList))
			$sWrk = ewrpt_JoinArray($Report2->Confirm->SelectionList, ", ", EWRPT_DATATYPE_NUMBER);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report2->Confirm->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field Class Name
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report2->Class_Name->SelectionList))
			$sWrk = ewrpt_JoinArray($Report2->Class_Name->SelectionList, ", ", EWRPT_DATATYPE_STRING);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report2->Class_Name->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Show Filters
		if ($sFilterList <> "")
			echo $ReportLanguage->Phrase("CurrentFilters") . "<br />$sFilterList";
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Report2;
		$sWrk = "";
			if (is_array($Report2->Branch->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report2->Branch, "students.branch", EWRPT_DATATYPE_STRING);
			}
			if (is_array($Report2->Confirm->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report2->Confirm, "students.confirm", EWRPT_DATATYPE_NUMBER);
			}
			if (is_array($Report2->Class_Name->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report2->Class_Name, "class.class", EWRPT_DATATYPE_STRING);
			}
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Report2;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Report2->setOrderBy("");
				$Report2->setStartGroup(1);
				$Report2->First_Name->setSort("");
				$Report2->Last_Name->setSort("");
				$Report2->zEmail->setSort("");
				$Report2->Phone_No2E->setSort("");
				$Report2->Roll_No->setSort("");
				$Report2->Branch->setSort("");
				$Report2->UserName->setSort("");
				$Report2->Parents_No->setSort("");
				$Report2->Password->setSort("");
				$Report2->Confirm->setSort("");
				$Report2->Class_Name->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Report2->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Report2->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Report2->SortSql();
			$Report2->setOrderBy($sSortSql);
			$Report2->setStartGroup(1);
		}
		return $Report2->getOrderBy();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
