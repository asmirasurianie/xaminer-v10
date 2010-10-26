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
$Studentwise_Tests_taken = NULL;

//
// Table class for Studentwise Tests taken
//
class crStudentwise_Tests_taken {
	var $TableVar = 'Studentwise_Tests_taken';
	var $TableName = 'Studentwise Tests taken';
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
	var $first_name;
	var $last_name;
	var $rollno;
	var $paper_name;
	var $totalmarks;
	var $attended_date;
	var $attended_time;
	var $fields = array();
	var $Export; // Export
	var $ExportAll = TRUE;
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
	function crStudentwise_Tests_taken() {
		global $ReportLanguage;

		// first_name
		$this->first_name = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_first_name', 'first_name', 'students.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['first_name'] =& $this->first_name;
		$this->first_name->DateFilter = "";
		$this->first_name->SqlSelect = "";
		$this->first_name->SqlOrderBy = "";

		// last_name
		$this->last_name = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_last_name', 'last_name', 'students.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['last_name'] =& $this->last_name;
		$this->last_name->DateFilter = "";
		$this->last_name->SqlSelect = "";
		$this->last_name->SqlOrderBy = "";

		// rollno
		$this->rollno = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_rollno', 'rollno', 'students.rollno', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->rollno->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rollno'] =& $this->rollno;
		$this->rollno->DateFilter = "";
		$this->rollno->SqlSelect = "";
		$this->rollno->SqlOrderBy = "";

		// paper_name
		$this->paper_name = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_paper_name', 'paper_name', 'papers.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['paper_name'] =& $this->paper_name;
		$this->paper_name->DateFilter = "";
		$this->paper_name->SqlSelect = "";
		$this->paper_name->SqlOrderBy = "";

		// totalmarks
		$this->totalmarks = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_totalmarks', 'totalmarks', 'class_std.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->totalmarks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['totalmarks'] =& $this->totalmarks;
		$this->totalmarks->DateFilter = "";
		$this->totalmarks->SqlSelect = "";
		$this->totalmarks->SqlOrderBy = "";

		// attended_date
		$this->attended_date = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_attended_date', 'attended_date', 'class_std.attended_date', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['attended_date'] =& $this->attended_date;
		$this->attended_date->DateFilter = "";
		$this->attended_date->SqlSelect = "";
		$this->attended_date->SqlOrderBy = "";

		// attended_time
		$this->attended_time = new crField('Studentwise_Tests_taken', 'Studentwise Tests taken', 'x_attended_time', 'attended_time', 'class_std.attended_time', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['attended_time'] =& $this->attended_time;
		$this->attended_time->DateFilter = "";
		$this->attended_time->SqlSelect = "";
		$this->attended_time->SqlOrderBy = "";
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
		return "class_std,students,papers";
	}

	function SqlSelect() { // Select
		return "SELECT students.first_name, students.last_name,students.rollno,papers.paper_name,class_std.totalmarks, class_std.attended_date,class_std.attended_time FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "class_std.std_id=students.std_id and papers.paper_id=class_std.paper_id";
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
$Studentwise_Tests_taken_rpt = new crStudentwise_Tests_taken_rpt();
$Page =& $Studentwise_Tests_taken_rpt;

// Page init
$Studentwise_Tests_taken_rpt->Page_Init();

// Page main
$Studentwise_Tests_taken_rpt->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Studentwise_Tests_taken_rpt->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Studentwise_Tests_taken_rpt->ShowMessage(); ?>
<?php if ($Studentwise_Tests_taken->Export == "" || $Studentwise_Tests_taken->Export == "print" || $Studentwise_Tests_taken->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "" || $Studentwise_Tests_taken->Export == "print" || $Studentwise_Tests_taken->Export == "email") { ?>
<?php } ?>
<?php echo $Studentwise_Tests_taken->TableCaption() ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Studentwise_Tests_taken_rpt->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "" || $Studentwise_Tests_taken->Export == "print" || $Studentwise_Tests_taken->Export == "email") { ?>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
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
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Studentwise_Tests_takenrpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Studentwise_Tests_taken_rpt->StartGrp, $Studentwise_Tests_taken_rpt->DisplayGrps, $Studentwise_Tests_taken_rpt->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Studentwise_Tests_takenrpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Studentwise_Tests_takenrpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Studentwise_Tests_takenrpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Studentwise_Tests_takenrpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Studentwise_Tests_taken_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Studentwise_Tests_taken_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Studentwise_Tests_taken_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Studentwise_Tests_taken->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Studentwise_Tests_taken->ExportAll && $Studentwise_Tests_taken->Export <> "") {
	$Studentwise_Tests_taken_rpt->StopGrp = $Studentwise_Tests_taken_rpt->TotalGrps;
} else {
	$Studentwise_Tests_taken_rpt->StopGrp = $Studentwise_Tests_taken_rpt->StartGrp + $Studentwise_Tests_taken_rpt->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Studentwise_Tests_taken_rpt->StopGrp) > intval($Studentwise_Tests_taken_rpt->TotalGrps))
	$Studentwise_Tests_taken_rpt->StopGrp = $Studentwise_Tests_taken_rpt->TotalGrps;
$Studentwise_Tests_taken_rpt->RecCount = 0;

// Get first row
if ($Studentwise_Tests_taken_rpt->TotalGrps > 0) {
	$Studentwise_Tests_taken_rpt->GetRow(1);
	$Studentwise_Tests_taken_rpt->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Studentwise_Tests_taken_rpt->GrpCount <= $Studentwise_Tests_taken_rpt->DisplayGrps) || $Studentwise_Tests_taken_rpt->ShowFirstHeader) {

	// Show header
	if ($Studentwise_Tests_taken_rpt->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->first_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->first_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->first_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->first_name) ?>',0);"><?php echo $Studentwise_Tests_taken->first_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->first_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->first_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->last_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->last_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->last_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->last_name) ?>',0);"><?php echo $Studentwise_Tests_taken->last_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->last_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->last_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->rollno->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->rollno) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->rollno->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->rollno) ?>',0);"><?php echo $Studentwise_Tests_taken->rollno->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->rollno->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->rollno->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->paper_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->paper_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->paper_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->paper_name) ?>',0);"><?php echo $Studentwise_Tests_taken->paper_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->paper_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->paper_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->totalmarks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->totalmarks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->totalmarks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->totalmarks) ?>',0);"><?php echo $Studentwise_Tests_taken->totalmarks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->totalmarks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->totalmarks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->attended_date->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->attended_date) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->attended_date->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->attended_date) ?>',0);"><?php echo $Studentwise_Tests_taken->attended_date->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->attended_date->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->attended_date->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Studentwise_Tests_taken->Export <> "") { ?>
<?php echo $Studentwise_Tests_taken->attended_time->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->attended_time) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Studentwise_Tests_taken->attended_time->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Studentwise_Tests_taken->SortUrl($Studentwise_Tests_taken->attended_time) ?>',0);"><?php echo $Studentwise_Tests_taken->attended_time->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Studentwise_Tests_taken->attended_time->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Studentwise_Tests_taken->attended_time->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Studentwise_Tests_taken_rpt->ShowFirstHeader = FALSE;
	}
	$Studentwise_Tests_taken_rpt->RecCount++;

		// Render detail row
		$Studentwise_Tests_taken->ResetCSS();
		$Studentwise_Tests_taken->RowType = EWRPT_ROWTYPE_DETAIL;
		$Studentwise_Tests_taken_rpt->RenderRow();
?>
	<tr<?php echo $Studentwise_Tests_taken->RowAttributes(); ?>>
		<td<?php echo $Studentwise_Tests_taken->first_name->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->first_name->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->first_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->last_name->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->last_name->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->last_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->rollno->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->rollno->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->rollno->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->paper_name->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->paper_name->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->paper_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->totalmarks->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->totalmarks->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->totalmarks->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->attended_date->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->attended_date->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->attended_date->ListViewValue(); ?></div>
</td>
		<td<?php echo $Studentwise_Tests_taken->attended_time->CellAttributes() ?>>
<div<?php echo $Studentwise_Tests_taken->attended_time->ViewAttributes(); ?>><?php echo $Studentwise_Tests_taken->attended_time->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Studentwise_Tests_taken_rpt->AccumulateSummary();

		// Get next record
		$Studentwise_Tests_taken_rpt->GetRow(2);
	$Studentwise_Tests_taken_rpt->GrpCount++;
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
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "" || $Studentwise_Tests_taken->Export == "print" || $Studentwise_Tests_taken->Export == "email") { ?>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "" || $Studentwise_Tests_taken->Export == "print" || $Studentwise_Tests_taken->Export == "email") { ?>
<?php } ?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Studentwise_Tests_taken_rpt->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Studentwise_Tests_taken->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Studentwise_Tests_taken_rpt->Page_Terminate();
?>
<?php

//
// Page class
//
class crStudentwise_Tests_taken_rpt {

	// Page ID
	var $PageID = 'rpt';

	// Table name
	var $TableName = 'Studentwise Tests taken';

	// Page object name
	var $PageObjName = 'Studentwise_Tests_taken_rpt';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Studentwise_Tests_taken;
		if ($Studentwise_Tests_taken->UseTokenInUrl) $PageUrl .= "t=" . $Studentwise_Tests_taken->TableVar . "&"; // Add page token
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
		global $Studentwise_Tests_taken;
		if ($Studentwise_Tests_taken->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Studentwise_Tests_taken->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Studentwise_Tests_taken->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crStudentwise_Tests_taken_rpt() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Studentwise_Tests_taken)
		$GLOBALS["Studentwise_Tests_taken"] = new crStudentwise_Tests_taken();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Studentwise Tests taken', TRUE);

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
		global $Studentwise_Tests_taken;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Studentwise_Tests_taken->Export = $_GET["export"];
	}
	$gsExport = $Studentwise_Tests_taken->Export; // Get export parameter, used in header
	$gsExportFile = $Studentwise_Tests_taken->TableVar; // Get export file, used in header

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
		global $Studentwise_Tests_taken;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Studentwise_Tests_taken->Export == "email") {
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
		global $Studentwise_Tests_taken;
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
		$sSql = ewrpt_BuildReportSql($Studentwise_Tests_taken->SqlSelect(), $Studentwise_Tests_taken->SqlWhere(), $Studentwise_Tests_taken->SqlGroupBy(), $Studentwise_Tests_taken->SqlHaving(), $Studentwise_Tests_taken->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Studentwise_Tests_taken->ExportAll && $Studentwise_Tests_taken->Export <> "")
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
		global $Studentwise_Tests_taken;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Studentwise_Tests_taken->first_name->setDbValue($rs->fields('first_name'));
			$Studentwise_Tests_taken->last_name->setDbValue($rs->fields('last_name'));
			$Studentwise_Tests_taken->rollno->setDbValue($rs->fields('rollno'));
			$Studentwise_Tests_taken->paper_name->setDbValue($rs->fields('paper_name'));
			$Studentwise_Tests_taken->totalmarks->setDbValue($rs->fields('totalmarks'));
			$Studentwise_Tests_taken->attended_date->setDbValue($rs->fields('attended_date'));
			$Studentwise_Tests_taken->attended_time->setDbValue($rs->fields('attended_time'));
			$this->Val[1] = $Studentwise_Tests_taken->first_name->CurrentValue;
			$this->Val[2] = $Studentwise_Tests_taken->last_name->CurrentValue;
			$this->Val[3] = $Studentwise_Tests_taken->rollno->CurrentValue;
			$this->Val[4] = $Studentwise_Tests_taken->paper_name->CurrentValue;
			$this->Val[5] = $Studentwise_Tests_taken->totalmarks->CurrentValue;
			$this->Val[6] = $Studentwise_Tests_taken->attended_date->CurrentValue;
			$this->Val[7] = $Studentwise_Tests_taken->attended_time->CurrentValue;
		} else {
			$Studentwise_Tests_taken->first_name->setDbValue("");
			$Studentwise_Tests_taken->last_name->setDbValue("");
			$Studentwise_Tests_taken->rollno->setDbValue("");
			$Studentwise_Tests_taken->paper_name->setDbValue("");
			$Studentwise_Tests_taken->totalmarks->setDbValue("");
			$Studentwise_Tests_taken->attended_date->setDbValue("");
			$Studentwise_Tests_taken->attended_time->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Studentwise_Tests_taken;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Studentwise_Tests_taken->getStartGroup();
			}
		} else {
			$this->StartGrp = $Studentwise_Tests_taken->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Studentwise_Tests_taken;

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
		global $Studentwise_Tests_taken;
		$this->StartGrp = 1;
		$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Studentwise_Tests_taken;
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
			$Studentwise_Tests_taken->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Studentwise_Tests_taken->setStartGroup($this->StartGrp);
		} else {
			if ($Studentwise_Tests_taken->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Studentwise_Tests_taken->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 2; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Studentwise_Tests_taken;
		if ($Studentwise_Tests_taken->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Studentwise_Tests_taken->SqlSelectCount(), $Studentwise_Tests_taken->SqlWhere(), $Studentwise_Tests_taken->SqlGroupBy(), $Studentwise_Tests_taken->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Studentwise_Tests_taken->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Studentwise_Tests_taken->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// first_name
			$Studentwise_Tests_taken->first_name->ViewValue = $Studentwise_Tests_taken->first_name->Summary;

			// last_name
			$Studentwise_Tests_taken->last_name->ViewValue = $Studentwise_Tests_taken->last_name->Summary;

			// rollno
			$Studentwise_Tests_taken->rollno->ViewValue = $Studentwise_Tests_taken->rollno->Summary;

			// paper_name
			$Studentwise_Tests_taken->paper_name->ViewValue = $Studentwise_Tests_taken->paper_name->Summary;

			// totalmarks
			$Studentwise_Tests_taken->totalmarks->ViewValue = $Studentwise_Tests_taken->totalmarks->Summary;

			// attended_date
			$Studentwise_Tests_taken->attended_date->ViewValue = $Studentwise_Tests_taken->attended_date->Summary;

			// attended_time
			$Studentwise_Tests_taken->attended_time->ViewValue = $Studentwise_Tests_taken->attended_time->Summary;
		} else {

			// first_name
			$Studentwise_Tests_taken->first_name->ViewValue = $Studentwise_Tests_taken->first_name->CurrentValue;
			$Studentwise_Tests_taken->first_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// last_name
			$Studentwise_Tests_taken->last_name->ViewValue = $Studentwise_Tests_taken->last_name->CurrentValue;
			$Studentwise_Tests_taken->last_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rollno
			$Studentwise_Tests_taken->rollno->ViewValue = $Studentwise_Tests_taken->rollno->CurrentValue;
			$Studentwise_Tests_taken->rollno->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// paper_name
			$Studentwise_Tests_taken->paper_name->ViewValue = $Studentwise_Tests_taken->paper_name->CurrentValue;
			$Studentwise_Tests_taken->paper_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// totalmarks
			$Studentwise_Tests_taken->totalmarks->ViewValue = $Studentwise_Tests_taken->totalmarks->CurrentValue;
			$Studentwise_Tests_taken->totalmarks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// attended_date
			$Studentwise_Tests_taken->attended_date->ViewValue = $Studentwise_Tests_taken->attended_date->CurrentValue;
			$Studentwise_Tests_taken->attended_date->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// attended_time
			$Studentwise_Tests_taken->attended_time->ViewValue = $Studentwise_Tests_taken->attended_time->CurrentValue;
			$Studentwise_Tests_taken->attended_time->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// first_name
		$Studentwise_Tests_taken->first_name->HrefValue = "";

		// last_name
		$Studentwise_Tests_taken->last_name->HrefValue = "";

		// rollno
		$Studentwise_Tests_taken->rollno->HrefValue = "";

		// paper_name
		$Studentwise_Tests_taken->paper_name->HrefValue = "";

		// totalmarks
		$Studentwise_Tests_taken->totalmarks->HrefValue = "";

		// attended_date
		$Studentwise_Tests_taken->attended_date->HrefValue = "";

		// attended_time
		$Studentwise_Tests_taken->attended_time->HrefValue = "";

		// Call Row_Rendered event
		$Studentwise_Tests_taken->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Studentwise_Tests_taken;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Studentwise_Tests_taken;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Studentwise_Tests_taken->setOrderBy("");
				$Studentwise_Tests_taken->setStartGroup(1);
				$Studentwise_Tests_taken->first_name->setSort("");
				$Studentwise_Tests_taken->last_name->setSort("");
				$Studentwise_Tests_taken->rollno->setSort("");
				$Studentwise_Tests_taken->paper_name->setSort("");
				$Studentwise_Tests_taken->totalmarks->setSort("");
				$Studentwise_Tests_taken->attended_date->setSort("");
				$Studentwise_Tests_taken->attended_time->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Studentwise_Tests_taken->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Studentwise_Tests_taken->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Studentwise_Tests_taken->SortSql();
			$Studentwise_Tests_taken->setOrderBy($sSortSql);
			$Studentwise_Tests_taken->setStartGroup(1);
		}
		return $Studentwise_Tests_taken->getOrderBy();
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
