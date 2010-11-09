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
$Report19 = NULL;

//
// Table class for Report19
//
class crReport19 {
	var $TableVar = 'Report19';
	var $TableName = 'Report19';
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
	function crReport19() {
		global $ReportLanguage;

		// first_name
		$this->first_name = new crField('Report19', 'Report19', 'x_first_name', 'first_name', 'students.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['first_name'] =& $this->first_name;
		$this->first_name->DateFilter = "";
		$this->first_name->SqlSelect = "";
		$this->first_name->SqlOrderBy = "";

		// last_name
		$this->last_name = new crField('Report19', 'Report19', 'x_last_name', 'last_name', 'students.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['last_name'] =& $this->last_name;
		$this->last_name->DateFilter = "";
		$this->last_name->SqlSelect = "";
		$this->last_name->SqlOrderBy = "";

		// paper_name
		$this->paper_name = new crField('Report19', 'Report19', 'x_paper_name', 'paper_name', 'papers.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['paper_name'] =& $this->paper_name;
		$this->paper_name->DateFilter = "";
		$this->paper_name->SqlSelect = "";
		$this->paper_name->SqlOrderBy = "";

		// outof
		$this->outof = new crField('Report19', 'Report19', 'x_outof', 'outof', 'papers.outof', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->outof->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['outof'] =& $this->outof;
		$this->outof->DateFilter = "";
		$this->outof->SqlSelect = "";
		$this->outof->SqlOrderBy = "";

		// grade
		$this->grade = new crField('Report19', 'Report19', 'x_grade', 'grade', 'class_std.grade', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['grade'] =& $this->grade;
		$this->grade->DateFilter = "";
		$this->grade->SqlSelect = "";
		$this->grade->SqlOrderBy = "";

		// totalmarks
		$this->totalmarks = new crField('Report19', 'Report19', 'x_totalmarks', 'totalmarks', 'class_std.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->totalmarks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['totalmarks'] =& $this->totalmarks;
		$this->totalmarks->DateFilter = "";
		$this->totalmarks->SqlSelect = "";
		$this->totalmarks->SqlOrderBy = "";

		// Chart1
		$this->Chart1 = new crChart('Report19', 'Report19', 'Chart1', 'Chart1', 'paper_name', 'grade', '', 5, 'SUM', 550, 440);
		$this->Chart1->SqlSelect = "SELECT `paper_name`, '', SUM(`grade`) FROM ";
		$this->Chart1->SqlGroupBy = "`paper_name`";
		$this->Chart1->SqlOrderBy = "";
		$this->Chart1->SeriesDateType = "";

		// Chart2
		$this->Chart2 = new crChart('Report19', 'Report19', 'Chart2', 'Chart2', 'grade', 'grade', '', 6, 'SUM', 550, 440);
		$this->Chart2->SqlSelect = "SELECT `grade`, '', SUM(`grade`) FROM ";
		$this->Chart2->SqlGroupBy = "`grade`";
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
$Report19_summary = new crReport19_summary();
$Page =& $Report19_summary;

// Page init
$Report19_summary->Page_Init();

// Page main
$Report19_summary->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Report19->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Report19_summary->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Report19_summary->ShowMessage(); ?>
<?php if ($Report19->Export == "" || $Report19->Export == "print" || $Report19->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Report19->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Report19->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Report19->Export == "" || $Report19->Export == "print" || $Report19->Export == "email") { ?>
<?php } ?>
<?php echo $Report19->TableCaption() ?>
<?php if ($Report19->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Report19_summary->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Report19->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Report19->Export == "" || $Report19->Export == "print" || $Report19->Export == "email") { ?>
<?php } ?>
<?php if ($Report19->Export == "") { ?>
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
<?php if ($Report19->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Report19smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report19_summary->StartGrp, $Report19_summary->DisplayGrps, $Report19_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report19_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report19_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report19_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report19_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report19_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report19_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report19_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report19_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report19_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report19_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report19->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Report19->ExportAll && $Report19->Export <> "") {
	$Report19_summary->StopGrp = $Report19_summary->TotalGrps;
} else {
	$Report19_summary->StopGrp = $Report19_summary->StartGrp + $Report19_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Report19_summary->StopGrp) > intval($Report19_summary->TotalGrps))
	$Report19_summary->StopGrp = $Report19_summary->TotalGrps;
$Report19_summary->RecCount = 0;

// Get first row
if ($Report19_summary->TotalGrps > 0) {
	$Report19_summary->GetRow(1);
	$Report19_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Report19_summary->GrpCount <= $Report19_summary->DisplayGrps) || $Report19_summary->ShowFirstHeader) {

	// Show header
	if ($Report19_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->first_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->first_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->first_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->first_name) ?>',0);"><?php echo $Report19->first_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->first_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->first_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->last_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->last_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->last_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->last_name) ?>',0);"><?php echo $Report19->last_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->last_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->last_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->paper_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->paper_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->paper_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->paper_name) ?>',0);"><?php echo $Report19->paper_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->paper_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->paper_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->outof->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->outof) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->outof->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->outof) ?>',0);"><?php echo $Report19->outof->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->outof->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->outof->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->grade->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->grade) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->grade->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->grade) ?>',0);"><?php echo $Report19->grade->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->grade->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->grade->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report19->Export <> "") { ?>
<?php echo $Report19->totalmarks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report19->SortUrl($Report19->totalmarks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report19->totalmarks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report19->SortUrl($Report19->totalmarks) ?>',0);"><?php echo $Report19->totalmarks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report19->totalmarks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report19->totalmarks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Report19_summary->ShowFirstHeader = FALSE;
	}
	$Report19_summary->RecCount++;

		// Render detail row
		$Report19->ResetCSS();
		$Report19->RowType = EWRPT_ROWTYPE_DETAIL;
		$Report19_summary->RenderRow();
?>
	<tr<?php echo $Report19->RowAttributes(); ?>>
		<td<?php echo $Report19->first_name->CellAttributes() ?>>
<div<?php echo $Report19->first_name->ViewAttributes(); ?>><?php echo $Report19->first_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report19->last_name->CellAttributes() ?>>
<div<?php echo $Report19->last_name->ViewAttributes(); ?>><?php echo $Report19->last_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report19->paper_name->CellAttributes() ?>>
<div<?php echo $Report19->paper_name->ViewAttributes(); ?>><?php echo $Report19->paper_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report19->outof->CellAttributes() ?>>
<div<?php echo $Report19->outof->ViewAttributes(); ?>><?php echo $Report19->outof->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report19->grade->CellAttributes() ?>>
<div<?php echo $Report19->grade->ViewAttributes(); ?>><?php echo $Report19->grade->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report19->totalmarks->CellAttributes() ?>>
<div<?php echo $Report19->totalmarks->ViewAttributes(); ?>><?php echo $Report19->totalmarks->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Report19_summary->AccumulateSummary();

		// Get next record
		$Report19_summary->GetRow(2);
	$Report19_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Report19_summary->TotalGrps > 0) {
	$Report19->ResetCSS();
	$Report19->RowType = EWRPT_ROWTYPE_TOTAL;
	$Report19->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Report19->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Report19->RowAttrs["class"] = "ewRptGrandSummary";
	$Report19_summary->RenderRow();
?>
	<!-- tr><td colspan="6"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Report19->RowAttributes(); ?>><td colspan="6"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Report19_summary->TotCount,0,-2,-2,-2); ?> <?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Report19_summary->TotalGrps > 0) { ?>
<?php if ($Report19->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report19smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report19_summary->StartGrp, $Report19_summary->DisplayGrps, $Report19_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report19smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report19_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report19_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report19_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report19_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report19_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report19_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report19_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report19_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report19_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report19_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report19->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($Report19->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Report19->Export == "" || $Report19->Export == "print" || $Report19->Export == "email") { ?>
<?php } ?>
<?php if ($Report19->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Report19->Export == "" || $Report19->Export == "print" || $Report19->Export == "email") { ?>
<a name="cht_Chart1"></a>
<div id="div_Report19_Chart1"></div>
<?php

// Initialize chart data
$Report19->Chart1->ID = "Report19_Chart1"; // Chart ID
$Report19->Chart1->SetChartParam("type", "5", FALSE); // Chart type
$Report19->Chart1->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report19->Chart1->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report19->Chart1->SetChartParam("caption", $Report19->Chart1->ChartCaption(), TRUE); // Chart caption
$Report19->Chart1->SetChartParam("xaxisname", $Report19->Chart1->ChartXAxisName(), TRUE); // X axis name
$Report19->Chart1->SetChartParam("yaxisname", $Report19->Chart1->ChartYAxisName(), TRUE); // Y axis name
$Report19->Chart1->SetChartParam("shownames", "1", TRUE); // Show names
$Report19->Chart1->SetChartParam("showvalues", "1", TRUE); // Show values
$Report19->Chart1->SetChartParam("showhovercap", "1", TRUE); // Show hover
$Report19->Chart1->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report19->Chart1->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report19->Chart1->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report19->Chart1->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report19->Chart1->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report19->Chart1->SetChartParam("animation", "1", TRUE); // animation
$Report19->Chart1->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report19->Chart1->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report19->Chart1->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report19->Chart1->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report19->Chart1->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report19->Chart1->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report19->Chart1->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report19->Chart1->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report19->Chart1->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report19->Chart1->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report19->Chart1->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report19->Chart1->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report19->Chart1->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report19->Chart1->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report19->Chart1->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report19->Chart1->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report19->Chart1->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report19->Chart1->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report19->Chart1->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report19->Chart1->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report19->Chart1->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report19->Chart1->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report19->Chart1->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report19->Chart1->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report19->Chart1->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report19->Chart1->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report19->Chart1->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report19->Chart1->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report19->SqlSelect();
$SqlChartSelect = $Report19->Chart1->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report19->SqlWhere(), $Report19->SqlGroupBy(), $Report19->SqlHaving(), $Report19->SqlOrderBy(), $Report19_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report19->Chart1->SqlGroupBy, "", $Report19->Chart1->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report19->Chart1);
ewrpt_SortChartData($Report19->Chart1->Data, 0, "");

// Call Chart_Rendering event
$Report19->Chart_Rendering($Report19->Chart1);
$chartxml = $Report19->Chart1->ChartXml();

// Call Chart_Rendered event
$Report19->Chart_Rendered($Report19->Chart1, $chartxml);
echo $Report19->Chart1->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<a name="cht_Chart2"></a>
<div id="div_Report19_Chart2"></div>
<?php

// Initialize chart data
$Report19->Chart2->ID = "Report19_Chart2"; // Chart ID
$Report19->Chart2->SetChartParam("type", "6", FALSE); // Chart type
$Report19->Chart2->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report19->Chart2->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report19->Chart2->SetChartParam("caption", $Report19->Chart2->ChartCaption(), TRUE); // Chart caption
$Report19->Chart2->SetChartParam("xaxisname", $Report19->Chart2->ChartXAxisName(), TRUE); // X axis name
$Report19->Chart2->SetChartParam("yaxisname", $Report19->Chart2->ChartYAxisName(), TRUE); // Y axis name
$Report19->Chart2->SetChartParam("shownames", "1", TRUE); // Show names
$Report19->Chart2->SetChartParam("showvalues", "1", TRUE); // Show values
$Report19->Chart2->SetChartParam("showhovercap", "0", TRUE); // Show hover
$Report19->Chart2->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report19->Chart2->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report19->Chart2->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report19->Chart2->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report19->Chart2->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report19->Chart2->SetChartParam("animation", "1", TRUE); // animation
$Report19->Chart2->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report19->Chart2->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report19->Chart2->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report19->Chart2->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report19->Chart2->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report19->Chart2->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report19->Chart2->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report19->Chart2->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report19->Chart2->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report19->Chart2->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report19->Chart2->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report19->Chart2->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report19->Chart2->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report19->Chart2->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report19->Chart2->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report19->Chart2->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report19->Chart2->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report19->Chart2->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report19->Chart2->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report19->Chart2->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report19->Chart2->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report19->Chart2->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report19->Chart2->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report19->Chart2->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report19->Chart2->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report19->Chart2->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report19->Chart2->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report19->Chart2->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report19->SqlSelect();
$SqlChartSelect = $Report19->Chart2->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report19->SqlWhere(), $Report19->SqlGroupBy(), $Report19->SqlHaving(), $Report19->SqlOrderBy(), $Report19_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report19->Chart2->SqlGroupBy, "", $Report19->Chart2->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report19->Chart2);
ewrpt_SortChartData($Report19->Chart2->Data, 0, "");

// Call Chart_Rendering event
$Report19->Chart_Rendering($Report19->Chart2);
$chartxml = $Report19->Chart2->ChartXml();

// Call Chart_Rendered event
$Report19->Chart_Rendered($Report19->Chart2, $chartxml);
echo $Report19->Chart2->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<?php } ?>
<?php if ($Report19->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Report19_summary->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Report19->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Report19_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crReport19_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Report19';

	// Page object name
	var $PageObjName = 'Report19_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Report19;
		if ($Report19->UseTokenInUrl) $PageUrl .= "t=" . $Report19->TableVar . "&"; // Add page token
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
		global $Report19;
		if ($Report19->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Report19->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Report19->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crReport19_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Report19)
		$GLOBALS["Report19"] = new crReport19();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Report19', TRUE);

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
		global $Report19;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Report19->Export = $_GET["export"];
	}
	$gsExport = $Report19->Export; // Get export parameter, used in header
	$gsExportFile = $Report19->TableVar; // Get export file, used in header

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
		global $Report19;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Report19->Export == "email") {
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
		global $Report19;
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
		$sSql = ewrpt_BuildReportSql($Report19->SqlSelect(), $Report19->SqlWhere(), $Report19->SqlGroupBy(), $Report19->SqlHaving(), $Report19->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Report19->ExportAll && $Report19->Export <> "")
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
		global $Report19;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Report19->first_name->setDbValue($rs->fields('first_name'));
			$Report19->last_name->setDbValue($rs->fields('last_name'));
			$Report19->paper_name->setDbValue($rs->fields('paper_name'));
			$Report19->outof->setDbValue($rs->fields('outof'));
			$Report19->grade->setDbValue($rs->fields('grade'));
			$Report19->totalmarks->setDbValue($rs->fields('totalmarks'));
			$this->Val[1] = $Report19->first_name->CurrentValue;
			$this->Val[2] = $Report19->last_name->CurrentValue;
			$this->Val[3] = $Report19->paper_name->CurrentValue;
			$this->Val[4] = $Report19->outof->CurrentValue;
			$this->Val[5] = $Report19->grade->CurrentValue;
			$this->Val[6] = $Report19->totalmarks->CurrentValue;
		} else {
			$Report19->first_name->setDbValue("");
			$Report19->last_name->setDbValue("");
			$Report19->paper_name->setDbValue("");
			$Report19->outof->setDbValue("");
			$Report19->grade->setDbValue("");
			$Report19->totalmarks->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Report19;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Report19->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Report19->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Report19->getStartGroup();
			}
		} else {
			$this->StartGrp = $Report19->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Report19->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Report19->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Report19->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Report19;

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
		global $Report19;
		$this->StartGrp = 1;
		$Report19->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Report19;
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
			$Report19->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Report19->setStartGroup($this->StartGrp);
		} else {
			if ($Report19->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Report19->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Report19;
		if ($Report19->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Report19->SqlSelectCount(), $Report19->SqlWhere(), $Report19->SqlGroupBy(), $Report19->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Report19->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Report19->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// first_name
			$Report19->first_name->ViewValue = $Report19->first_name->Summary;

			// last_name
			$Report19->last_name->ViewValue = $Report19->last_name->Summary;

			// paper_name
			$Report19->paper_name->ViewValue = $Report19->paper_name->Summary;

			// outof
			$Report19->outof->ViewValue = $Report19->outof->Summary;

			// grade
			$Report19->grade->ViewValue = $Report19->grade->Summary;

			// totalmarks
			$Report19->totalmarks->ViewValue = $Report19->totalmarks->Summary;
		} else {

			// first_name
			$Report19->first_name->ViewValue = $Report19->first_name->CurrentValue;
			$Report19->first_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// last_name
			$Report19->last_name->ViewValue = $Report19->last_name->CurrentValue;
			$Report19->last_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// paper_name
			$Report19->paper_name->ViewValue = $Report19->paper_name->CurrentValue;
			$Report19->paper_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// outof
			$Report19->outof->ViewValue = $Report19->outof->CurrentValue;
			$Report19->outof->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// grade
			$Report19->grade->ViewValue = $Report19->grade->CurrentValue;
			$Report19->grade->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// totalmarks
			$Report19->totalmarks->ViewValue = $Report19->totalmarks->CurrentValue;
			$Report19->totalmarks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// first_name
		$Report19->first_name->HrefValue = "";

		// last_name
		$Report19->last_name->HrefValue = "";

		// paper_name
		$Report19->paper_name->HrefValue = "";

		// outof
		$Report19->outof->HrefValue = "";

		// grade
		$Report19->grade->HrefValue = "";

		// totalmarks
		$Report19->totalmarks->HrefValue = "";

		// Call Row_Rendered event
		$Report19->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Report19;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Report19;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Report19->setOrderBy("");
				$Report19->setStartGroup(1);
				$Report19->first_name->setSort("");
				$Report19->last_name->setSort("");
				$Report19->paper_name->setSort("");
				$Report19->outof->setSort("");
				$Report19->grade->setSort("");
				$Report19->totalmarks->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Report19->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Report19->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Report19->SortSql();
			$Report19->setOrderBy($sSortSql);
			$Report19->setStartGroup(1);
		}
		return $Report19->getOrderBy();
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
