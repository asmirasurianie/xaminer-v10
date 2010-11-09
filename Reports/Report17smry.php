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
$Report17 = NULL;

//
// Table class for Report17
//
class crReport17 {
	var $TableVar = 'Report17';
	var $TableName = 'Report17';
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
	var $first_name;
	var $last_name;
	var $paper_name;
	var $outof;
	var $grade;
	var $totalmarks;
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
	function crReport17() {
		global $ReportLanguage;

		// first_name
		$this->first_name = new crField('Report17', 'Report17', 'x_first_name', 'first_name', 'students.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['first_name'] =& $this->first_name;
		$this->first_name->DateFilter = "";
		$this->first_name->SqlSelect = "SELECT DISTINCT students.first_name FROM " . $this->SqlFrom();
		$this->first_name->SqlOrderBy = "students.first_name";

		// last_name
		$this->last_name = new crField('Report17', 'Report17', 'x_last_name', 'last_name', 'students.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['last_name'] =& $this->last_name;
		$this->last_name->DateFilter = "";
		$this->last_name->SqlSelect = "";
		$this->last_name->SqlOrderBy = "";

		// paper_name
		$this->paper_name = new crField('Report17', 'Report17', 'x_paper_name', 'paper_name', 'papers.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['paper_name'] =& $this->paper_name;
		$this->paper_name->DateFilter = "";
		$this->paper_name->SqlSelect = "SELECT DISTINCT papers.paper_name FROM " . $this->SqlFrom();
		$this->paper_name->SqlOrderBy = "papers.paper_name";

		// outof
		$this->outof = new crField('Report17', 'Report17', 'x_outof', 'outof', 'papers.outof', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->outof->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['outof'] =& $this->outof;
		$this->outof->DateFilter = "";
		$this->outof->SqlSelect = "";
		$this->outof->SqlOrderBy = "";

		// grade
		$this->grade = new crField('Report17', 'Report17', 'x_grade', 'grade', 'class_std.grade', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['grade'] =& $this->grade;
		$this->grade->DateFilter = "";
		$this->grade->SqlSelect = "SELECT DISTINCT class_std.grade FROM " . $this->SqlFrom();
		$this->grade->SqlOrderBy = "class_std.grade";

		// totalmarks
		$this->totalmarks = new crField('Report17', 'Report17', 'x_totalmarks', 'totalmarks', 'class_std.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->totalmarks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['totalmarks'] =& $this->totalmarks;
		$this->totalmarks->DateFilter = "";
		$this->totalmarks->SqlSelect = "";
		$this->totalmarks->SqlOrderBy = "";

		// Chart1
		$this->Chart1 = new crChart('Report17', 'Report17', 'Chart1', 'Chart1', 'paper_name', 'grade', '', 5, 'COUNT', 550, 440);
		$this->Chart1->SqlSelect = "SELECT `paper_name`, '', COUNT(`grade`) FROM ";
		$this->Chart1->SqlGroupBy = "`paper_name`";
		$this->Chart1->SqlOrderBy = "";
		$this->Chart1->SeriesDateType = "";
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
		return "class_std Inner Join students On students.std_id = class_std.std_id Inner Join papers On papers.paper_id = class_std.paper_id";
	}

	function SqlSelect() { // Select
		return "SELECT students.first_name, students.last_name, papers.paper_name, papers.outof, class_std.grade, class_std.totalmarks FROM " . $this->SqlFrom();
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
$Report17_summary = new crReport17_summary();
$Page =& $Report17_summary;

// Page init
$Report17_summary->Page_Init();

// Page main
$Report17_summary->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Report17->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Report17_summary->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Report17_summary->ShowMessage(); ?>
<?php if ($Report17->Export == "" || $Report17->Export == "print" || $Report17->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Report17->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
<?php $jsdata = ewrpt_GetJsData($Report17->first_name, $Report17->first_name->FldType); ?>
ewrpt_CreatePopup("Report17_first_name", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($Report17->paper_name, $Report17->paper_name->FldType); ?>
ewrpt_CreatePopup("Report17_paper_name", [<?php echo $jsdata ?>]);
<?php $jsdata = ewrpt_GetJsData($Report17->grade, $Report17->grade->FldType); ?>
ewrpt_CreatePopup("Report17_grade", [<?php echo $jsdata ?>]);
</script>
<div id="Report17_first_name_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report17_paper_name_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<div id="Report17_grade_Popup" class="ewPopup">
<span class="phpreportmaker"></span>
</div>
<?php } ?>
<?php if ($Report17->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Report17->Export == "" || $Report17->Export == "print" || $Report17->Export == "email") { ?>
<?php } ?>
<?php echo $Report17->TableCaption() ?>
<?php if ($Report17->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Report17_summary->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php if ($Report17_summary->FilterApplied) { ?>
&nbsp;&nbsp;<a href="Report17smry.php?cmd=reset"><?php echo $ReportLanguage->Phrase("ResetAllFilter") ?></a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if ($Report17->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Report17->Export == "" || $Report17->Export == "print" || $Report17->Export == "email") { ?>
<?php } ?>
<?php if ($Report17->Export == "") { ?>
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<?php if ($Report17->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $Report17_summary->ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if ($Report17->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Report17smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report17_summary->StartGrp, $Report17_summary->DisplayGrps, $Report17_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report17_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report17_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report17_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report17_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report17_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report17_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report17_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report17_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report17_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report17_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report17->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Report17->ExportAll && $Report17->Export <> "") {
	$Report17_summary->StopGrp = $Report17_summary->TotalGrps;
} else {
	$Report17_summary->StopGrp = $Report17_summary->StartGrp + $Report17_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Report17_summary->StopGrp) > intval($Report17_summary->TotalGrps))
	$Report17_summary->StopGrp = $Report17_summary->TotalGrps;
$Report17_summary->RecCount = 0;

// Get first row
if ($Report17_summary->TotalGrps > 0) {
	$Report17_summary->GetRow(1);
	$Report17_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Report17_summary->GrpCount <= $Report17_summary->DisplayGrps) || $Report17_summary->ShowFirstHeader) {

	// Show header
	if ($Report17_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->first_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->first_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->first_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->first_name) ?>',0);"><?php echo $Report17->first_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->first_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->first_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report17_first_name', false, '<?php echo $Report17->first_name->RangeFrom; ?>', '<?php echo $Report17->first_name->RangeTo; ?>');return false;" name="x_first_name<?php echo $Report17_summary->Cnt[0][0]; ?>" id="x_first_name<?php echo $Report17_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->last_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->last_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->last_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->last_name) ?>',0);"><?php echo $Report17->last_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->last_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->last_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->paper_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->paper_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->paper_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->paper_name) ?>',0);"><?php echo $Report17->paper_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->paper_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->paper_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report17_paper_name', false, '<?php echo $Report17->paper_name->RangeFrom; ?>', '<?php echo $Report17->paper_name->RangeTo; ?>');return false;" name="x_paper_name<?php echo $Report17_summary->Cnt[0][0]; ?>" id="x_paper_name<?php echo $Report17_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->outof->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->outof) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->outof->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->outof) ?>',0);"><?php echo $Report17->outof->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->outof->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->outof->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->grade->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->grade) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->grade->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->grade) ?>',0);"><?php echo $Report17->grade->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->grade->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->grade->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
		<td style="width: 20px;" align="right"><a href="#" onclick="ewrpt_ShowPopup(this.name, 'Report17_grade', false, '<?php echo $Report17->grade->RangeFrom; ?>', '<?php echo $Report17->grade->RangeTo; ?>');return false;" name="x_grade<?php echo $Report17_summary->Cnt[0][0]; ?>" id="x_grade<?php echo $Report17_summary->Cnt[0][0]; ?>"><img src="phprptimages/popup.gif" width="15" height="14" align="texttop" border="0" alt="<?php echo $ReportLanguage->Phrase("Filter") ?>"></a></td>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report17->Export <> "") { ?>
<?php echo $Report17->totalmarks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report17->SortUrl($Report17->totalmarks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report17->totalmarks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report17->SortUrl($Report17->totalmarks) ?>',0);"><?php echo $Report17->totalmarks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report17->totalmarks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report17->totalmarks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Report17_summary->ShowFirstHeader = FALSE;
	}
	$Report17_summary->RecCount++;

		// Render detail row
		$Report17->ResetCSS();
		$Report17->RowType = EWRPT_ROWTYPE_DETAIL;
		$Report17_summary->RenderRow();
?>
	<tr<?php echo $Report17->RowAttributes(); ?>>
		<td<?php echo $Report17->first_name->CellAttributes() ?>>
<div<?php echo $Report17->first_name->ViewAttributes(); ?>><?php echo $Report17->first_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report17->last_name->CellAttributes() ?>>
<div<?php echo $Report17->last_name->ViewAttributes(); ?>><?php echo $Report17->last_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report17->paper_name->CellAttributes() ?>>
<div<?php echo $Report17->paper_name->ViewAttributes(); ?>><?php echo $Report17->paper_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report17->outof->CellAttributes() ?>>
<div<?php echo $Report17->outof->ViewAttributes(); ?>><?php echo $Report17->outof->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report17->grade->CellAttributes() ?>>
<div<?php echo $Report17->grade->ViewAttributes(); ?>><?php echo $Report17->grade->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report17->totalmarks->CellAttributes() ?>>
<div<?php echo $Report17->totalmarks->ViewAttributes(); ?>><?php echo $Report17->totalmarks->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Report17_summary->AccumulateSummary();

		// Get next record
		$Report17_summary->GetRow(2);
	$Report17_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Report17_summary->TotalGrps > 0) {
	$Report17->ResetCSS();
	$Report17->RowType = EWRPT_ROWTYPE_TOTAL;
	$Report17->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Report17->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Report17->RowAttrs["class"] = "ewRptGrandSummary";
	$Report17_summary->RenderRow();
?>
	<!-- tr><td colspan="6"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Report17->RowAttributes(); ?>><td colspan="6"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Report17_summary->TotCount,0,-2,-2,-2); ?> <?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Report17_summary->TotalGrps > 0) { ?>
<?php if ($Report17->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report17smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report17_summary->StartGrp, $Report17_summary->DisplayGrps, $Report17_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report17smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report17_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report17_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report17_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report17_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report17_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report17_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report17_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report17_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report17_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report17_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report17->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($Report17->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Report17->Export == "" || $Report17->Export == "print" || $Report17->Export == "email") { ?>
<?php } ?>
<?php if ($Report17->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Report17->Export == "" || $Report17->Export == "print" || $Report17->Export == "email") { ?>
<a name="cht_Chart1"></a>
<div id="div_Report17_Chart1"></div>
<?php

// Initialize chart data
$Report17->Chart1->ID = "Report17_Chart1"; // Chart ID
$Report17->Chart1->SetChartParam("type", "5", FALSE); // Chart type
$Report17->Chart1->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report17->Chart1->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report17->Chart1->SetChartParam("caption", $Report17->Chart1->ChartCaption(), TRUE); // Chart caption
$Report17->Chart1->SetChartParam("xaxisname", $Report17->Chart1->ChartXAxisName(), TRUE); // X axis name
$Report17->Chart1->SetChartParam("yaxisname", $Report17->Chart1->ChartYAxisName(), TRUE); // Y axis name
$Report17->Chart1->SetChartParam("shownames", "1", TRUE); // Show names
$Report17->Chart1->SetChartParam("showvalues", "1", TRUE); // Show values
$Report17->Chart1->SetChartParam("showhovercap", "1", TRUE); // Show hover
$Report17->Chart1->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report17->Chart1->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report17->Chart1->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report17->Chart1->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report17->Chart1->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report17->Chart1->SetChartParam("animation", "1", TRUE); // animation
$Report17->Chart1->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report17->Chart1->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report17->Chart1->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report17->Chart1->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report17->Chart1->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report17->Chart1->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report17->Chart1->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report17->Chart1->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report17->Chart1->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report17->Chart1->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report17->Chart1->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report17->Chart1->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report17->Chart1->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report17->Chart1->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report17->Chart1->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report17->Chart1->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report17->Chart1->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report17->Chart1->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report17->Chart1->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report17->Chart1->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report17->Chart1->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report17->Chart1->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report17->Chart1->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report17->Chart1->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report17->Chart1->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report17->Chart1->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report17->Chart1->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report17->Chart1->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report17->SqlSelect();
$SqlChartSelect = $Report17->Chart1->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), $Report17->SqlOrderBy(), $Report17_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report17->Chart1->SqlGroupBy, "", $Report17->Chart1->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report17->Chart1);
ewrpt_SortChartData($Report17->Chart1->Data, 0, "");

// Call Chart_Rendering event
$Report17->Chart_Rendering($Report17->Chart1);
$chartxml = $Report17->Chart1->ChartXml();

// Call Chart_Rendered event
$Report17->Chart_Rendered($Report17->Chart1, $chartxml);
echo $Report17->Chart1->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<?php } ?>
<?php if ($Report17->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Report17_summary->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Report17->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Report17_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crReport17_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Report17';

	// Page object name
	var $PageObjName = 'Report17_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Report17;
		if ($Report17->UseTokenInUrl) $PageUrl .= "t=" . $Report17->TableVar . "&"; // Add page token
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
		global $Report17;
		if ($Report17->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Report17->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Report17->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crReport17_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Report17)
		$GLOBALS["Report17"] = new crReport17();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Report17', TRUE);

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
		global $Report17;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Report17->Export = $_GET["export"];
	}
	$gsExport = $Report17->Export; // Get export parameter, used in header
	$gsExportFile = $Report17->TableVar; // Get export file, used in header

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
		global $Report17;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Report17->Export == "email") {
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
		global $Report17;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 7;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();
		$Report17->first_name->SelectionList = "";
		$Report17->first_name->DefaultSelectionList = "";
		$Report17->first_name->ValueList = "";
		$Report17->paper_name->SelectionList = "";
		$Report17->paper_name->DefaultSelectionList = "";
		$Report17->paper_name->ValueList = "";
		$Report17->grade->SelectionList = "";
		$Report17->grade->DefaultSelectionList = "";
		$Report17->grade->ValueList = "";

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
		$sSql = ewrpt_BuildReportSql($Report17->SqlSelect(), $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), $Report17->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Report17->ExportAll && $Report17->Export <> "")
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
		global $Report17;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Report17->first_name->setDbValue($rs->fields('first_name'));
			$Report17->last_name->setDbValue($rs->fields('last_name'));
			$Report17->paper_name->setDbValue($rs->fields('paper_name'));
			$Report17->outof->setDbValue($rs->fields('outof'));
			$Report17->grade->setDbValue($rs->fields('grade'));
			$Report17->totalmarks->setDbValue($rs->fields('totalmarks'));
			$this->Val[1] = $Report17->first_name->CurrentValue;
			$this->Val[2] = $Report17->last_name->CurrentValue;
			$this->Val[3] = $Report17->paper_name->CurrentValue;
			$this->Val[4] = $Report17->outof->CurrentValue;
			$this->Val[5] = $Report17->grade->CurrentValue;
			$this->Val[6] = $Report17->totalmarks->CurrentValue;
		} else {
			$Report17->first_name->setDbValue("");
			$Report17->last_name->setDbValue("");
			$Report17->paper_name->setDbValue("");
			$Report17->outof->setDbValue("");
			$Report17->grade->setDbValue("");
			$Report17->totalmarks->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Report17;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Report17->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Report17->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Report17->getStartGroup();
			}
		} else {
			$this->StartGrp = $Report17->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Report17->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Report17->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Report17->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Report17;

		// Initialize popup
		// Build distinct values for first_name

		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report17->first_name->SqlSelect, $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), $Report17->first_name->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report17->first_name->setDbValue($rswrk->fields[0]);
			if (is_null($Report17->first_name->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report17->first_name->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report17->first_name->ViewValue = $Report17->first_name->CurrentValue;
				ewrpt_SetupDistinctValues($Report17->first_name->ValueList, $Report17->first_name->CurrentValue, $Report17->first_name->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report17->first_name->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report17->first_name->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

		// Build distinct values for paper_name
		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report17->paper_name->SqlSelect, $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), $Report17->paper_name->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report17->paper_name->setDbValue($rswrk->fields[0]);
			if (is_null($Report17->paper_name->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report17->paper_name->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report17->paper_name->ViewValue = $Report17->paper_name->CurrentValue;
				ewrpt_SetupDistinctValues($Report17->paper_name->ValueList, $Report17->paper_name->CurrentValue, $Report17->paper_name->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report17->paper_name->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report17->paper_name->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

		// Build distinct values for grade
		$bNullValue = FALSE;
		$bEmptyValue = FALSE;
		$sSql = ewrpt_BuildReportSql($Report17->grade->SqlSelect, $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), $Report17->grade->SqlOrderBy, $this->Filter, "");
		$rswrk = $conn->Execute($sSql);
		while ($rswrk && !$rswrk->EOF) {
			$Report17->grade->setDbValue($rswrk->fields[0]);
			if (is_null($Report17->grade->CurrentValue)) {
				$bNullValue = TRUE;
			} elseif ($Report17->grade->CurrentValue == "") {
				$bEmptyValue = TRUE;
			} else {
				$Report17->grade->ViewValue = $Report17->grade->CurrentValue;
				ewrpt_SetupDistinctValues($Report17->grade->ValueList, $Report17->grade->CurrentValue, $Report17->grade->ViewValue, FALSE);
			}
			$rswrk->MoveNext();
		}
		if ($rswrk)
			$rswrk->Close();
		if ($bEmptyValue)
			ewrpt_SetupDistinctValues($Report17->grade->ValueList, EWRPT_EMPTY_VALUE, $ReportLanguage->Phrase("EmptyLabel"), FALSE);
		if ($bNullValue)
			ewrpt_SetupDistinctValues($Report17->grade->ValueList, EWRPT_NULL_VALUE, $ReportLanguage->Phrase("NullLabel"), FALSE);

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
				$this->ClearSessionSelection('first_name');
				$this->ClearSessionSelection('paper_name');
				$this->ClearSessionSelection('grade');
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
		// Get first name selected values

		if (is_array(@$_SESSION["sel_Report17_first_name"])) {
			$this->LoadSelectionFromSession('first_name');
		} elseif (@$_SESSION["sel_Report17_first_name"] == EWRPT_INIT_VALUE) { // Select all
			$Report17->first_name->SelectionList = "";
		}

		// Get paper name selected values
		if (is_array(@$_SESSION["sel_Report17_paper_name"])) {
			$this->LoadSelectionFromSession('paper_name');
		} elseif (@$_SESSION["sel_Report17_paper_name"] == EWRPT_INIT_VALUE) { // Select all
			$Report17->paper_name->SelectionList = "";
		}

		// Get grade selected values
		if (is_array(@$_SESSION["sel_Report17_grade"])) {
			$this->LoadSelectionFromSession('grade');
		} elseif (@$_SESSION["sel_Report17_grade"] == EWRPT_INIT_VALUE) { // Select all
			$Report17->grade->SelectionList = "";
		}
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		global $Report17;
		$this->StartGrp = 1;
		$Report17->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Report17;
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
			$Report17->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Report17->setStartGroup($this->StartGrp);
		} else {
			if ($Report17->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Report17->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Report17;
		if ($Report17->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Report17->SqlSelectCount(), $Report17->SqlWhere(), $Report17->SqlGroupBy(), $Report17->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Report17->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Report17->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// first_name
			$Report17->first_name->ViewValue = $Report17->first_name->Summary;

			// last_name
			$Report17->last_name->ViewValue = $Report17->last_name->Summary;

			// paper_name
			$Report17->paper_name->ViewValue = $Report17->paper_name->Summary;

			// outof
			$Report17->outof->ViewValue = $Report17->outof->Summary;

			// grade
			$Report17->grade->ViewValue = $Report17->grade->Summary;

			// totalmarks
			$Report17->totalmarks->ViewValue = $Report17->totalmarks->Summary;
		} else {

			// first_name
			$Report17->first_name->ViewValue = $Report17->first_name->CurrentValue;
			$Report17->first_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// last_name
			$Report17->last_name->ViewValue = $Report17->last_name->CurrentValue;
			$Report17->last_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// paper_name
			$Report17->paper_name->ViewValue = $Report17->paper_name->CurrentValue;
			$Report17->paper_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// outof
			$Report17->outof->ViewValue = $Report17->outof->CurrentValue;
			$Report17->outof->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// grade
			$Report17->grade->ViewValue = $Report17->grade->CurrentValue;
			$Report17->grade->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// totalmarks
			$Report17->totalmarks->ViewValue = $Report17->totalmarks->CurrentValue;
			$Report17->totalmarks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// first_name
		$Report17->first_name->HrefValue = "";

		// last_name
		$Report17->last_name->HrefValue = "";

		// paper_name
		$Report17->paper_name->HrefValue = "";

		// outof
		$Report17->outof->HrefValue = "";

		// grade
		$Report17->grade->HrefValue = "";

		// totalmarks
		$Report17->totalmarks->HrefValue = "";

		// Call Row_Rendered event
		$Report17->Row_Rendered();
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_Report17_$parm"] = "";
		$_SESSION["rf_Report17_$parm"] = "";
		$_SESSION["rt_Report17_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $Report17;
		$fld =& $Report17->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Report17_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Report17_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Report17_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $Report17;

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

		// Field first_name
		// Setup your default values for the popup filter below, e.g.
		// $Report17->first_name->DefaultSelectionList = array("val1", "val2");

		$Report17->first_name->DefaultSelectionList = "";
		$Report17->first_name->SelectionList = $Report17->first_name->DefaultSelectionList;

		// Field paper_name
		// Setup your default values for the popup filter below, e.g.
		// $Report17->paper_name->DefaultSelectionList = array("val1", "val2");

		$Report17->paper_name->DefaultSelectionList = "";
		$Report17->paper_name->SelectionList = $Report17->paper_name->DefaultSelectionList;

		// Field grade
		// Setup your default values for the popup filter below, e.g.
		// $Report17->grade->DefaultSelectionList = array("val1", "val2");

		$Report17->grade->DefaultSelectionList = "";
		$Report17->grade->SelectionList = $Report17->grade->DefaultSelectionList;
	}

	// Check if filter applied
	function CheckFilter() {
		global $Report17;

		// Check first_name popup filter
		if (!ewrpt_MatchedArray($Report17->first_name->DefaultSelectionList, $Report17->first_name->SelectionList))
			return TRUE;

		// Check paper_name popup filter
		if (!ewrpt_MatchedArray($Report17->paper_name->DefaultSelectionList, $Report17->paper_name->SelectionList))
			return TRUE;

		// Check grade popup filter
		if (!ewrpt_MatchedArray($Report17->grade->DefaultSelectionList, $Report17->grade->SelectionList))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $Report17;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field first_name
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report17->first_name->SelectionList))
			$sWrk = ewrpt_JoinArray($Report17->first_name->SelectionList, ", ", EWRPT_DATATYPE_STRING);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report17->first_name->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field paper_name
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report17->paper_name->SelectionList))
			$sWrk = ewrpt_JoinArray($Report17->paper_name->SelectionList, ", ", EWRPT_DATATYPE_STRING);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report17->paper_name->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field grade
		$sExtWrk = "";
		$sWrk = "";
		if (is_array($Report17->grade->SelectionList))
			$sWrk = ewrpt_JoinArray($Report17->grade->SelectionList, ", ", EWRPT_DATATYPE_STRING);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Report17->grade->FldCaption() . "<br />";
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
		global $Report17;
		$sWrk = "";
			if (is_array($Report17->first_name->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report17->first_name, "students.first_name", EWRPT_DATATYPE_STRING);
			}
			if (is_array($Report17->paper_name->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report17->paper_name, "papers.paper_name", EWRPT_DATATYPE_STRING);
			}
			if (is_array($Report17->grade->SelectionList)) {
				if ($sWrk <> "") $sWrk .= " AND ";
				$sWrk .= ewrpt_FilterSQL($Report17->grade, "class_std.grade", EWRPT_DATATYPE_STRING);
			}
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Report17;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Report17->setOrderBy("");
				$Report17->setStartGroup(1);
				$Report17->first_name->setSort("");
				$Report17->last_name->setSort("");
				$Report17->paper_name->setSort("");
				$Report17->outof->setSort("");
				$Report17->grade->setSort("");
				$Report17->totalmarks->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Report17->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Report17->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Report17->SortSql();
			$Report17->setOrderBy($sSortSql);
			$Report17->setStartGroup(1);
		}
		return $Report17->getOrderBy();
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
