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
$Student_wise = NULL;

//
// Table class for Student wise
//
class crStudent_wise {
	var $TableVar = 'Student_wise';
	var $TableName = 'Student wise';
	var $TableType = 'CUSTOMVIEW';
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
	var $First_Name;
	var $Last_Name;
	var $Roll_No;
	var $Paper_Name;
	var $Total_Marks;
	var $Attended_Date;
	var $Attended_Time;
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
	function crStudent_wise() {
		global $ReportLanguage;

		// First Name
		$this->First_Name = new crField('Student_wise', 'Student wise', 'x_First_Name', 'First Name', 's.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['First_Name'] =& $this->First_Name;
		$this->First_Name->DateFilter = "";
		$this->First_Name->SqlSelect = "";
		$this->First_Name->SqlOrderBy = "";

		// Last Name
		$this->Last_Name = new crField('Student_wise', 'Student wise', 'x_Last_Name', 'Last Name', 's.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Last_Name'] =& $this->Last_Name;
		$this->Last_Name->DateFilter = "";
		$this->Last_Name->SqlSelect = "";
		$this->Last_Name->SqlOrderBy = "";

		// Roll No
		$this->Roll_No = new crField('Student_wise', 'Student wise', 'x_Roll_No', 'Roll No', 's.rollno', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Roll_No->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Roll_No'] =& $this->Roll_No;
		$this->Roll_No->DateFilter = "";
		$this->Roll_No->SqlSelect = "";
		$this->Roll_No->SqlOrderBy = "";

		// Paper Name
		$this->Paper_Name = new crField('Student_wise', 'Student wise', 'x_Paper_Name', 'Paper Name', 'p.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Paper_Name'] =& $this->Paper_Name;
		$this->Paper_Name->DateFilter = "";
		$this->Paper_Name->SqlSelect = "";
		$this->Paper_Name->SqlOrderBy = "";

		// Total Marks
		$this->Total_Marks = new crField('Student_wise', 'Student wise', 'x_Total_Marks', 'Total Marks', 'c.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Total_Marks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Total_Marks'] =& $this->Total_Marks;
		$this->Total_Marks->DateFilter = "";
		$this->Total_Marks->SqlSelect = "";
		$this->Total_Marks->SqlOrderBy = "";

		// Attended Date
		$this->Attended_Date = new crField('Student_wise', 'Student wise', 'x_Attended_Date', 'Attended Date', 'c.attended_date', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Attended_Date'] =& $this->Attended_Date;
		$this->Attended_Date->DateFilter = "";
		$this->Attended_Date->SqlSelect = "";
		$this->Attended_Date->SqlOrderBy = "";

		// Attended Time
		$this->Attended_Time = new crField('Student_wise', 'Student wise', 'x_Attended_Time', 'Attended Time', 'c.attended_time', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Attended_Time'] =& $this->Attended_Time;
		$this->Attended_Time->DateFilter = "";
		$this->Attended_Time->SqlSelect = "";
		$this->Attended_Time->SqlOrderBy = "";
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
		return "students As s, papers As p, class_std As c";
	}

	function SqlSelect() { // Select
		return "SELECT s.first_name As `First Name`, s.last_name As `Last Name`, s.rollno As `Roll No`, p.paper_name As `Paper Name`, c.totalmarks As `Total Marks`, c.attended_date As `Attended Date`, c.attended_time As `Attended Time` FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "s.std_id = c.std_id And c.paper_id = p.paper_id";
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

	function SqlSelectAgg() {
		return "SELECT  FROM " . $this->SqlFrom();
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
$Student_wise_rpt = new crStudent_wise_rpt();
$Page =& $Student_wise_rpt;

// Page init
$Student_wise_rpt->Page_Init();

// Page main
$Student_wise_rpt->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Student_wise->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Student_wise_rpt->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Student_wise_rpt->ShowMessage(); ?>
<?php if ($Student_wise->Export == "" || $Student_wise->Export == "print" || $Student_wise->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Student_wise->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Student_wise->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Student_wise->Export == "" || $Student_wise->Export == "print" || $Student_wise->Export == "email") { ?>
<?php } ?>
<?php echo $Student_wise->TableCaption() ?>
<?php if ($Student_wise->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Student_wise_rpt->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Student_wise->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Student_wise->Export == "" || $Student_wise->Export == "print" || $Student_wise->Export == "email") { ?>
<?php } ?>
<?php if ($Student_wise->Export == "") { ?>
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if ($Student_wise->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Student_wiserpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Student_wise_rpt->StartGrp, $Student_wise_rpt->DisplayGrps, $Student_wise_rpt->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Student_wiserpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Student_wiserpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Student_wiserpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Student_wiserpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Student_wise_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Student_wise_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Student_wise_rpt->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Student_wise_rpt->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Student_wise_rpt->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Student_wise_rpt->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Student_wise_rpt->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Student_wise_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Student_wise_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Student_wise_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Student_wise->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Student_wise->ExportAll && $Student_wise->Export <> "") {
	$Student_wise_rpt->StopGrp = $Student_wise_rpt->TotalGrps;
} else {
	$Student_wise_rpt->StopGrp = $Student_wise_rpt->StartGrp + $Student_wise_rpt->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Student_wise_rpt->StopGrp) > intval($Student_wise_rpt->TotalGrps))
	$Student_wise_rpt->StopGrp = $Student_wise_rpt->TotalGrps;
$Student_wise_rpt->RecCount = 0;

// Get first row
if ($Student_wise_rpt->TotalGrps > 0) {
	$Student_wise_rpt->GetRow(1);
	$Student_wise_rpt->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Student_wise_rpt->GrpCount <= $Student_wise_rpt->DisplayGrps) || $Student_wise_rpt->ShowFirstHeader) {

	// Show header
	if ($Student_wise_rpt->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->First_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->First_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->First_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->First_Name) ?>',0);"><?php echo $Student_wise->First_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->First_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->First_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Last_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Last_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Last_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Last_Name) ?>',0);"><?php echo $Student_wise->Last_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Last_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Last_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Roll_No->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Roll_No) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Roll_No->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Roll_No) ?>',0);"><?php echo $Student_wise->Roll_No->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Roll_No->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Roll_No->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Paper_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Paper_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Paper_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Paper_Name) ?>',0);"><?php echo $Student_wise->Paper_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Paper_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Paper_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Total_Marks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Total_Marks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Total_Marks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Total_Marks) ?>',0);"><?php echo $Student_wise->Total_Marks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Total_Marks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Total_Marks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Attended_Date->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Attended_Date) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Attended_Date->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Attended_Date) ?>',0);"><?php echo $Student_wise->Attended_Date->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Attended_Date->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Attended_Date->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Student_wise->Export <> "") { ?>
<?php echo $Student_wise->Attended_Time->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Student_wise->SortUrl($Student_wise->Attended_Time) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Student_wise->Attended_Time->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Student_wise->SortUrl($Student_wise->Attended_Time) ?>',0);"><?php echo $Student_wise->Attended_Time->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Student_wise->Attended_Time->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Student_wise->Attended_Time->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Student_wise_rpt->ShowFirstHeader = FALSE;
	}
	$Student_wise_rpt->RecCount++;

		// Render detail row
		$Student_wise->ResetCSS();
		$Student_wise->RowType = EWRPT_ROWTYPE_DETAIL;
		$Student_wise_rpt->RenderRow();
?>
	<tr<?php echo $Student_wise->RowAttributes(); ?>>
		<td<?php echo $Student_wise->First_Name->CellAttributes() ?>>
<div<?php echo $Student_wise->First_Name->ViewAttributes(); ?>><?php echo $Student_wise->First_Name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Last_Name->CellAttributes() ?>>
<div<?php echo $Student_wise->Last_Name->ViewAttributes(); ?>><?php echo $Student_wise->Last_Name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Roll_No->CellAttributes() ?>>
<div<?php echo $Student_wise->Roll_No->ViewAttributes(); ?>><?php echo $Student_wise->Roll_No->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Paper_Name->CellAttributes() ?>>
<div<?php echo $Student_wise->Paper_Name->ViewAttributes(); ?>><?php echo $Student_wise->Paper_Name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Total_Marks->CellAttributes() ?>>
<div<?php echo $Student_wise->Total_Marks->ViewAttributes(); ?>><?php echo $Student_wise->Total_Marks->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Attended_Date->CellAttributes() ?>>
<div<?php echo $Student_wise->Attended_Date->ViewAttributes(); ?>><?php echo $Student_wise->Attended_Date->ListViewValue(); ?></div>
</td>
		<td<?php echo $Student_wise->Attended_Time->CellAttributes() ?>>
<div<?php echo $Student_wise->Attended_Time->ViewAttributes(); ?>><?php echo $Student_wise->Attended_Time->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Student_wise_rpt->AccumulateSummary();

		// Get next record
		$Student_wise_rpt->GetRow(2);
	$Student_wise_rpt->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if ($Student_wise->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Student_wise->Export == "" || $Student_wise->Export == "print" || $Student_wise->Export == "email") { ?>
<?php } ?>
<?php if ($Student_wise->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Student_wise->Export == "" || $Student_wise->Export == "print" || $Student_wise->Export == "email") { ?>
<?php } ?>
<?php if ($Student_wise->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Student_wise_rpt->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Student_wise->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Student_wise_rpt->Page_Terminate();
?>
<?php

//
// Page class
//
class crStudent_wise_rpt {

	// Page ID
	var $PageID = 'rpt';

	// Table name
	var $TableName = 'Student wise';

	// Page object name
	var $PageObjName = 'Student_wise_rpt';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Student_wise;
		if ($Student_wise->UseTokenInUrl) $PageUrl .= "t=" . $Student_wise->TableVar . "&"; // Add page token
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
		global $Student_wise;
		if ($Student_wise->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Student_wise->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Student_wise->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crStudent_wise_rpt() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Student_wise)
		$GLOBALS["Student_wise"] = new crStudent_wise();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Student wise', TRUE);

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
		global $Student_wise;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Student_wise->Export = $_GET["export"];
	}
	$gsExport = $Student_wise->Export; // Get export parameter, used in header
	$gsExportFile = $Student_wise->TableVar; // Get export file, used in header

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
		global $Student_wise;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Student_wise->Export == "email") {
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
	var $DisplayGrps = 2; // Groups per page
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
		global $Student_wise;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 8;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

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

		// No filter
		$this->FilterApplied = FALSE;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($Student_wise->SqlSelect(), $Student_wise->SqlWhere(), $Student_wise->SqlGroupBy(), $Student_wise->SqlHaving(), $Student_wise->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Student_wise->ExportAll && $Student_wise->Export <> "")
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
		global $Student_wise;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Student_wise->First_Name->setDbValue($rs->fields('First Name'));
			$Student_wise->Last_Name->setDbValue($rs->fields('Last Name'));
			$Student_wise->Roll_No->setDbValue($rs->fields('Roll No'));
			$Student_wise->Paper_Name->setDbValue($rs->fields('Paper Name'));
			$Student_wise->Total_Marks->setDbValue($rs->fields('Total Marks'));
			$Student_wise->Attended_Date->setDbValue($rs->fields('Attended Date'));
			$Student_wise->Attended_Time->setDbValue($rs->fields('Attended Time'));
			$this->Val[1] = $Student_wise->First_Name->CurrentValue;
			$this->Val[2] = $Student_wise->Last_Name->CurrentValue;
			$this->Val[3] = $Student_wise->Roll_No->CurrentValue;
			$this->Val[4] = $Student_wise->Paper_Name->CurrentValue;
			$this->Val[5] = $Student_wise->Total_Marks->CurrentValue;
			$this->Val[6] = $Student_wise->Attended_Date->CurrentValue;
			$this->Val[7] = $Student_wise->Attended_Time->CurrentValue;
		} else {
			$Student_wise->First_Name->setDbValue("");
			$Student_wise->Last_Name->setDbValue("");
			$Student_wise->Roll_No->setDbValue("");
			$Student_wise->Paper_Name->setDbValue("");
			$Student_wise->Total_Marks->setDbValue("");
			$Student_wise->Attended_Date->setDbValue("");
			$Student_wise->Attended_Time->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Student_wise;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Student_wise->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Student_wise->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Student_wise->getStartGroup();
			}
		} else {
			$this->StartGrp = $Student_wise->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Student_wise->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Student_wise->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Student_wise->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Student_wise;

		// Initialize popup
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
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		global $Student_wise;
		$this->StartGrp = 1;
		$Student_wise->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Student_wise;
		$sWrk = @$_GET[EWRPT_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 2; // Non-numeric, load default
				}
			}
			$Student_wise->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Student_wise->setStartGroup($this->StartGrp);
		} else {
			if ($Student_wise->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Student_wise->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 2; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Student_wise;
		if ($Student_wise->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Student_wise->SqlSelectCount(), $Student_wise->SqlWhere(), $Student_wise->SqlGroupBy(), $Student_wise->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Student_wise->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Student_wise->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// First Name
			$Student_wise->First_Name->ViewValue = $Student_wise->First_Name->Summary;

			// Last Name
			$Student_wise->Last_Name->ViewValue = $Student_wise->Last_Name->Summary;

			// Roll No
			$Student_wise->Roll_No->ViewValue = $Student_wise->Roll_No->Summary;

			// Paper Name
			$Student_wise->Paper_Name->ViewValue = $Student_wise->Paper_Name->Summary;

			// Total Marks
			$Student_wise->Total_Marks->ViewValue = $Student_wise->Total_Marks->Summary;

			// Attended Date
			$Student_wise->Attended_Date->ViewValue = $Student_wise->Attended_Date->Summary;

			// Attended Time
			$Student_wise->Attended_Time->ViewValue = $Student_wise->Attended_Time->Summary;
		} else {

			// First Name
			$Student_wise->First_Name->ViewValue = $Student_wise->First_Name->CurrentValue;
			$Student_wise->First_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Last Name
			$Student_wise->Last_Name->ViewValue = $Student_wise->Last_Name->CurrentValue;
			$Student_wise->Last_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Roll No
			$Student_wise->Roll_No->ViewValue = $Student_wise->Roll_No->CurrentValue;
			$Student_wise->Roll_No->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Paper Name
			$Student_wise->Paper_Name->ViewValue = $Student_wise->Paper_Name->CurrentValue;
			$Student_wise->Paper_Name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Total Marks
			$Student_wise->Total_Marks->ViewValue = $Student_wise->Total_Marks->CurrentValue;
			$Student_wise->Total_Marks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Attended Date
			$Student_wise->Attended_Date->ViewValue = $Student_wise->Attended_Date->CurrentValue;
			$Student_wise->Attended_Date->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Attended Time
			$Student_wise->Attended_Time->ViewValue = $Student_wise->Attended_Time->CurrentValue;
			$Student_wise->Attended_Time->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// First Name
		$Student_wise->First_Name->HrefValue = "";

		// Last Name
		$Student_wise->Last_Name->HrefValue = "";

		// Roll No
		$Student_wise->Roll_No->HrefValue = "";

		// Paper Name
		$Student_wise->Paper_Name->HrefValue = "";

		// Total Marks
		$Student_wise->Total_Marks->HrefValue = "";

		// Attended Date
		$Student_wise->Attended_Date->HrefValue = "";

		// Attended Time
		$Student_wise->Attended_Time->HrefValue = "";

		// Call Row_Rendered event
		$Student_wise->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Student_wise;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Student_wise;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Student_wise->setOrderBy("");
				$Student_wise->setStartGroup(1);
				$Student_wise->First_Name->setSort("");
				$Student_wise->Last_Name->setSort("");
				$Student_wise->Roll_No->setSort("");
				$Student_wise->Paper_Name->setSort("");
				$Student_wise->Total_Marks->setSort("");
				$Student_wise->Attended_Date->setSort("");
				$Student_wise->Attended_Time->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Student_wise->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Student_wise->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Student_wise->SortSql();
			$Student_wise->setOrderBy($sSortSql);
			$Student_wise->setStartGroup(1);
		}
		return $Student_wise->getOrderBy();
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
