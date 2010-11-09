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
$Report11 = NULL;

//
// Table class for Report11
//
class crReport11 {
	var $TableVar = 'Report11';
	var $TableName = 'Report11';
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
	var $Time_Taken;
	var $first_name;
	var $last_name;
	var $paper_name;
	var $totalmarks;
	var $total_time28in_seconds29;
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
	function crReport11() {
		global $ReportLanguage;

		// first_name
		$this->first_name = new crField('Report11', 'Report11', 'x_first_name', 'first_name', 'students.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['first_name'] =& $this->first_name;
		$this->first_name->DateFilter = "";
		$this->first_name->SqlSelect = "";
		$this->first_name->SqlOrderBy = "";

		// last_name
		$this->last_name = new crField('Report11', 'Report11', 'x_last_name', 'last_name', 'students.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['last_name'] =& $this->last_name;
		$this->last_name->DateFilter = "";
		$this->last_name->SqlSelect = "";
		$this->last_name->SqlOrderBy = "";

		// paper_name
		$this->paper_name = new crField('Report11', 'Report11', 'x_paper_name', 'paper_name', 'papers.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['paper_name'] =& $this->paper_name;
		$this->paper_name->DateFilter = "";
		$this->paper_name->SqlSelect = "";
		$this->paper_name->SqlOrderBy = "";

		// totalmarks
		$this->totalmarks = new crField('Report11', 'Report11', 'x_totalmarks', 'totalmarks', 'class_std.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->totalmarks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['totalmarks'] =& $this->totalmarks;
		$this->totalmarks->DateFilter = "";
		$this->totalmarks->SqlSelect = "";
		$this->totalmarks->SqlOrderBy = "";

		// total_time(in seconds)
		$this->total_time28in_seconds29 = new crField('Report11', 'Report11', 'x_total_time28in_seconds29', 'total_time(in seconds)', 'class_std.`total_time(in seconds)`', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->total_time28in_seconds29->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['total_time28in_seconds29'] =& $this->total_time28in_seconds29;
		$this->total_time28in_seconds29->DateFilter = "";
		$this->total_time28in_seconds29->SqlSelect = "";
		$this->total_time28in_seconds29->SqlOrderBy = "";

		// Time Taken
		$this->Time_Taken = new crChart('Report11', 'Report11', 'Time_Taken', 'Time Taken', 'first_name', 'total_time(in seconds)', '', 5, 'SUM', 550, 440);
		$this->Time_Taken->SqlSelect = "SELECT `first_name`, '', SUM(`total_time(in seconds)`) FROM ";
		$this->Time_Taken->SqlGroupBy = "`first_name`";
		$this->Time_Taken->SqlOrderBy = "";
		$this->Time_Taken->SeriesDateType = "";
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
		return "SELECT students.first_name, students.last_name, papers.paper_name, class_std.totalmarks, class_std.`total_time(in seconds)` FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "papers.paper_name";
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
$Report11_summary = new crReport11_summary();
$Page =& $Report11_summary;

// Page init
$Report11_summary->Page_Init();

// Page main
$Report11_summary->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Report11->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Report11_summary->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Report11_summary->ShowMessage(); ?>
<?php if ($Report11->Export == "" || $Report11->Export == "print" || $Report11->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Report11->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Report11->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Report11->Export == "" || $Report11->Export == "print" || $Report11->Export == "email") { ?>
<?php } ?>
<?php echo $Report11->TableCaption() ?>
<?php if ($Report11->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Report11_summary->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Report11->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Report11->Export == "" || $Report11->Export == "print" || $Report11->Export == "email") { ?>
<?php } ?>
<?php if ($Report11->Export == "") { ?>
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
<?php if ($Report11->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Report11smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report11_summary->StartGrp, $Report11_summary->DisplayGrps, $Report11_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report11_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report11_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report11_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report11_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report11_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report11_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report11_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report11_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report11_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report11_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report11->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Report11->ExportAll && $Report11->Export <> "") {
	$Report11_summary->StopGrp = $Report11_summary->TotalGrps;
} else {
	$Report11_summary->StopGrp = $Report11_summary->StartGrp + $Report11_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Report11_summary->StopGrp) > intval($Report11_summary->TotalGrps))
	$Report11_summary->StopGrp = $Report11_summary->TotalGrps;
$Report11_summary->RecCount = 0;

// Get first row
if ($Report11_summary->TotalGrps > 0) {
	$Report11_summary->GetRow(1);
	$Report11_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Report11_summary->GrpCount <= $Report11_summary->DisplayGrps) || $Report11_summary->ShowFirstHeader) {

	// Show header
	if ($Report11_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Report11->Export <> "") { ?>
<?php echo $Report11->first_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report11->SortUrl($Report11->first_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report11->first_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report11->SortUrl($Report11->first_name) ?>',0);"><?php echo $Report11->first_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report11->first_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report11->first_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report11->Export <> "") { ?>
<?php echo $Report11->last_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report11->SortUrl($Report11->last_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report11->last_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report11->SortUrl($Report11->last_name) ?>',0);"><?php echo $Report11->last_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report11->last_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report11->last_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report11->Export <> "") { ?>
<?php echo $Report11->paper_name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report11->SortUrl($Report11->paper_name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report11->paper_name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report11->SortUrl($Report11->paper_name) ?>',0);"><?php echo $Report11->paper_name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report11->paper_name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report11->paper_name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report11->Export <> "") { ?>
<?php echo $Report11->totalmarks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report11->SortUrl($Report11->totalmarks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report11->totalmarks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report11->SortUrl($Report11->totalmarks) ?>',0);"><?php echo $Report11->totalmarks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report11->totalmarks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report11->totalmarks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report11->Export <> "") { ?>
<?php echo $Report11->total_time28in_seconds29->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report11->SortUrl($Report11->total_time28in_seconds29) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report11->total_time28in_seconds29->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report11->SortUrl($Report11->total_time28in_seconds29) ?>',0);"><?php echo $Report11->total_time28in_seconds29->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report11->total_time28in_seconds29->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report11->total_time28in_seconds29->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Report11_summary->ShowFirstHeader = FALSE;
	}
	$Report11_summary->RecCount++;

		// Render detail row
		$Report11->ResetCSS();
		$Report11->RowType = EWRPT_ROWTYPE_DETAIL;
		$Report11_summary->RenderRow();
?>
	<tr<?php echo $Report11->RowAttributes(); ?>>
		<td<?php echo $Report11->first_name->CellAttributes() ?>>
<div<?php echo $Report11->first_name->ViewAttributes(); ?>><?php echo $Report11->first_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report11->last_name->CellAttributes() ?>>
<div<?php echo $Report11->last_name->ViewAttributes(); ?>><?php echo $Report11->last_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report11->paper_name->CellAttributes() ?>>
<div<?php echo $Report11->paper_name->ViewAttributes(); ?>><?php echo $Report11->paper_name->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report11->totalmarks->CellAttributes() ?>>
<div<?php echo $Report11->totalmarks->ViewAttributes(); ?>><?php echo $Report11->totalmarks->ListViewValue(); ?></div>
</td>
		<td<?php echo $Report11->total_time28in_seconds29->CellAttributes() ?>>
<div<?php echo $Report11->total_time28in_seconds29->ViewAttributes(); ?>><?php echo $Report11->total_time28in_seconds29->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Report11_summary->AccumulateSummary();

		// Get next record
		$Report11_summary->GetRow(2);
	$Report11_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Report11_summary->TotalGrps > 0) {
	$Report11->ResetCSS();
	$Report11->RowType = EWRPT_ROWTYPE_TOTAL;
	$Report11->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Report11->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Report11->RowAttrs["class"] = "ewRptGrandSummary";
	$Report11_summary->RenderRow();
?>
	<!-- tr><td colspan="5"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Report11->RowAttributes(); ?>><td colspan="5"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Report11_summary->TotCount,0,-2,-2,-2); ?> <?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Report11_summary->TotalGrps > 0) { ?>
<?php if ($Report11->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report11smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report11_summary->StartGrp, $Report11_summary->DisplayGrps, $Report11_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report11smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report11_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report11_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report11_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report11_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report11_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report11_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report11_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report11_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report11_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report11_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report11->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($Report11->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Report11->Export == "" || $Report11->Export == "print" || $Report11->Export == "email") { ?>
<?php } ?>
<?php if ($Report11->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Report11->Export == "" || $Report11->Export == "print" || $Report11->Export == "email") { ?>
<a name="cht_Time_Taken"></a>
<div id="div_Report11_Time_Taken"></div>
<?php

// Initialize chart data
$Report11->Time_Taken->ID = "Report11_Time_Taken"; // Chart ID
$Report11->Time_Taken->SetChartParam("type", "5", FALSE); // Chart type
$Report11->Time_Taken->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report11->Time_Taken->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report11->Time_Taken->SetChartParam("caption", $Report11->Time_Taken->ChartCaption(), TRUE); // Chart caption
$Report11->Time_Taken->SetChartParam("xaxisname", $Report11->Time_Taken->ChartXAxisName(), TRUE); // X axis name
$Report11->Time_Taken->SetChartParam("yaxisname", $Report11->Time_Taken->ChartYAxisName(), TRUE); // Y axis name
$Report11->Time_Taken->SetChartParam("shownames", "1", TRUE); // Show names
$Report11->Time_Taken->SetChartParam("showvalues", "1", TRUE); // Show values
$Report11->Time_Taken->SetChartParam("showhovercap", "0", TRUE); // Show hover
$Report11->Time_Taken->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report11->Time_Taken->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report11->Time_Taken->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report11->Time_Taken->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report11->Time_Taken->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report11->Time_Taken->SetChartParam("animation", "1", TRUE); // animation
$Report11->Time_Taken->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report11->Time_Taken->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report11->Time_Taken->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report11->Time_Taken->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report11->Time_Taken->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report11->Time_Taken->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report11->Time_Taken->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report11->Time_Taken->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report11->Time_Taken->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report11->Time_Taken->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report11->Time_Taken->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report11->Time_Taken->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report11->Time_Taken->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report11->Time_Taken->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report11->Time_Taken->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report11->Time_Taken->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report11->Time_Taken->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report11->Time_Taken->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report11->Time_Taken->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report11->Time_Taken->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report11->Time_Taken->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report11->Time_Taken->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report11->Time_Taken->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report11->Time_Taken->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report11->Time_Taken->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report11->Time_Taken->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report11->Time_Taken->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report11->Time_Taken->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report11->SqlSelect();
$SqlChartSelect = $Report11->Time_Taken->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report11->SqlWhere(), $Report11->SqlGroupBy(), $Report11->SqlHaving(), $Report11->SqlOrderBy(), $Report11_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report11->Time_Taken->SqlGroupBy, "", $Report11->Time_Taken->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report11->Time_Taken);
ewrpt_SortChartData($Report11->Time_Taken->Data, 0, "");

// Call Chart_Rendering event
$Report11->Chart_Rendering($Report11->Time_Taken);
$chartxml = $Report11->Time_Taken->ChartXml();

// Call Chart_Rendered event
$Report11->Chart_Rendered($Report11->Time_Taken, $chartxml);
echo $Report11->Time_Taken->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<?php } ?>
<?php if ($Report11->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Report11_summary->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Report11->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Report11_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crReport11_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Report11';

	// Page object name
	var $PageObjName = 'Report11_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Report11;
		if ($Report11->UseTokenInUrl) $PageUrl .= "t=" . $Report11->TableVar . "&"; // Add page token
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
		global $Report11;
		if ($Report11->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Report11->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Report11->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crReport11_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Report11)
		$GLOBALS["Report11"] = new crReport11();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Report11', TRUE);

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
		global $Report11;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Report11->Export = $_GET["export"];
	}
	$gsExport = $Report11->Export; // Get export parameter, used in header
	$gsExportFile = $Report11->TableVar; // Get export file, used in header

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
		global $Report11;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Report11->Export == "email") {
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
		global $Report11;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 6;
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
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

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
		$sSql = ewrpt_BuildReportSql($Report11->SqlSelect(), $Report11->SqlWhere(), $Report11->SqlGroupBy(), $Report11->SqlHaving(), $Report11->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Report11->ExportAll && $Report11->Export <> "")
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
		global $Report11;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Report11->first_name->setDbValue($rs->fields('first_name'));
			$Report11->last_name->setDbValue($rs->fields('last_name'));
			$Report11->paper_name->setDbValue($rs->fields('paper_name'));
			$Report11->totalmarks->setDbValue($rs->fields('totalmarks'));
			$Report11->total_time28in_seconds29->setDbValue($rs->fields('total_time(in seconds)'));
			$this->Val[1] = $Report11->first_name->CurrentValue;
			$this->Val[2] = $Report11->last_name->CurrentValue;
			$this->Val[3] = $Report11->paper_name->CurrentValue;
			$this->Val[4] = $Report11->totalmarks->CurrentValue;
			$this->Val[5] = $Report11->total_time28in_seconds29->CurrentValue;
		} else {
			$Report11->first_name->setDbValue("");
			$Report11->last_name->setDbValue("");
			$Report11->paper_name->setDbValue("");
			$Report11->totalmarks->setDbValue("");
			$Report11->total_time28in_seconds29->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Report11;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Report11->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Report11->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Report11->getStartGroup();
			}
		} else {
			$this->StartGrp = $Report11->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Report11->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Report11->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Report11->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Report11;

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
		global $Report11;
		$this->StartGrp = 1;
		$Report11->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Report11;
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
			$Report11->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Report11->setStartGroup($this->StartGrp);
		} else {
			if ($Report11->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Report11->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Report11;
		if ($Report11->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Report11->SqlSelectCount(), $Report11->SqlWhere(), $Report11->SqlGroupBy(), $Report11->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Report11->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Report11->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// first_name
			$Report11->first_name->ViewValue = $Report11->first_name->Summary;

			// last_name
			$Report11->last_name->ViewValue = $Report11->last_name->Summary;

			// paper_name
			$Report11->paper_name->ViewValue = $Report11->paper_name->Summary;

			// totalmarks
			$Report11->totalmarks->ViewValue = $Report11->totalmarks->Summary;

			// total_time(in seconds)
			$Report11->total_time28in_seconds29->ViewValue = $Report11->total_time28in_seconds29->Summary;
		} else {

			// first_name
			$Report11->first_name->ViewValue = $Report11->first_name->CurrentValue;
			$Report11->first_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// last_name
			$Report11->last_name->ViewValue = $Report11->last_name->CurrentValue;
			$Report11->last_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// paper_name
			$Report11->paper_name->ViewValue = $Report11->paper_name->CurrentValue;
			$Report11->paper_name->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// totalmarks
			$Report11->totalmarks->ViewValue = $Report11->totalmarks->CurrentValue;
			$Report11->totalmarks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// total_time(in seconds)
			$Report11->total_time28in_seconds29->ViewValue = $Report11->total_time28in_seconds29->CurrentValue;
			$Report11->total_time28in_seconds29->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// first_name
		$Report11->first_name->HrefValue = "";

		// last_name
		$Report11->last_name->HrefValue = "";

		// paper_name
		$Report11->paper_name->HrefValue = "";

		// totalmarks
		$Report11->totalmarks->HrefValue = "";

		// total_time(in seconds)
		$Report11->total_time28in_seconds29->HrefValue = "";

		// Call Row_Rendered event
		$Report11->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Report11;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Report11;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Report11->setOrderBy("");
				$Report11->setStartGroup(1);
				$Report11->first_name->setSort("");
				$Report11->last_name->setSort("");
				$Report11->paper_name->setSort("");
				$Report11->totalmarks->setSort("");
				$Report11->total_time28in_seconds29->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Report11->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Report11->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Report11->SortSql();
			$Report11->setOrderBy($sSortSql);
			$Report11->setStartGroup(1);
		}
		return $Report11->getOrderBy();
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
