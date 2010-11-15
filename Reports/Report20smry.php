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
$Report20 = NULL;

//
// Table class for Report20
//
class crReport20 {
	var $TableVar = 'Report20';
	var $TableName = 'Report20';
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
	var $questions;
	var $marks;
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
	function crReport20() {
		global $ReportLanguage;

		// questions
		$this->questions = new crField('Report20', 'Report20', 'x_questions', 'questions', 'questions.questions', 201, EWRPT_DATATYPE_MEMO, -1);
		$this->fields['questions'] =& $this->questions;
		$this->questions->DateFilter = "";
		$this->questions->SqlSelect = "";
		$this->questions->SqlOrderBy = "";

		// marks
		$this->marks = new crField('Report20', 'Report20', 'x_marks', 'marks', 'questions.marks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->marks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['marks'] =& $this->marks;
		$this->marks->DateFilter = "";
		$this->marks->SqlSelect = "";
		$this->marks->SqlOrderBy = "";

		// Chart1
		$this->Chart1 = new crChart('Report20', 'Report20', 'Chart1', 'Chart1', 'questions', 'marks', '', 5, 'SUM', 550, 440);
		$this->Chart1->SqlSelect = "SELECT `questions`, '', SUM(`marks`) FROM ";
		$this->Chart1->SqlGroupBy = "`questions`";
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
		return "questions";
	}

	function SqlSelect() { // Select
		return "SELECT questions.questions, questions.marks FROM " . $this->SqlFrom();
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
$Report20_summary = new crReport20_summary();
$Page =& $Report20_summary;

// Page init
$Report20_summary->Page_Init();

// Page main
$Report20_summary->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Report20->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Report20_summary->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Report20_summary->ShowMessage(); ?>
<?php if ($Report20->Export == "" || $Report20->Export == "print" || $Report20->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Report20->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Report20->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Report20->Export == "" || $Report20->Export == "print" || $Report20->Export == "email") { ?>
<?php } ?>
<?php echo $Report20->TableCaption() ?>
<?php if ($Report20->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Report20_summary->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Report20->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Report20->Export == "" || $Report20->Export == "print" || $Report20->Export == "email") { ?>
<?php } ?>
<?php if ($Report20->Export == "") { ?>
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
<?php if ($Report20->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Report20smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report20_summary->StartGrp, $Report20_summary->DisplayGrps, $Report20_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report20_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report20_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report20_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report20_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report20_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report20_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report20_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report20_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report20_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report20_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report20->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
if ($Report20->ExportAll && $Report20->Export <> "") {
	$Report20_summary->StopGrp = $Report20_summary->TotalGrps;
} else {
	$Report20_summary->StopGrp = $Report20_summary->StartGrp + $Report20_summary->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Report20_summary->StopGrp) > intval($Report20_summary->TotalGrps))
	$Report20_summary->StopGrp = $Report20_summary->TotalGrps;
$Report20_summary->RecCount = 0;

// Get first row
if ($Report20_summary->TotalGrps > 0) {
	$Report20_summary->GetRow(1);
	$Report20_summary->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Report20_summary->GrpCount <= $Report20_summary->DisplayGrps) || $Report20_summary->ShowFirstHeader) {

	// Show header
	if ($Report20_summary->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
<?php if ($Report20->Export <> "") { ?>
<?php echo $Report20->questions->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report20->SortUrl($Report20->questions) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report20->questions->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report20->SortUrl($Report20->questions) ?>',0);"><?php echo $Report20->questions->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report20->questions->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report20->questions->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Report20->Export <> "") { ?>
<?php echo $Report20->marks->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Report20->SortUrl($Report20->marks) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Report20->marks->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Report20->SortUrl($Report20->marks) ?>',0);"><?php echo $Report20->marks->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Report20->marks->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Report20->marks->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Report20_summary->ShowFirstHeader = FALSE;
	}
	$Report20_summary->RecCount++;

		// Render detail row
		$Report20->ResetCSS();
		$Report20->RowType = EWRPT_ROWTYPE_DETAIL;
		$Report20_summary->RenderRow();
?>
	<tr<?php echo $Report20->RowAttributes(); ?>>
		<td<?php echo $Report20->questions->CellAttributes() ?>>
<div<?php echo $Report20->questions->ViewAttributes(); ?>>
<?php if ($Report20->questions->HrefValue <> "") { ?>
<a href="<?php echo $Report20->questions->HrefValue; ?>"><?php echo $Report20->questions->ListViewValue(); ?></a>
<?php } else { ?>
<?php echo $Report20->questions->ListViewValue(); ?>
<?php } ?>
</div>
</td>
		<td<?php echo $Report20->marks->CellAttributes() ?>>
<div<?php echo $Report20->marks->ViewAttributes(); ?>><?php echo $Report20->marks->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Report20_summary->AccumulateSummary();

		// Get next record
		$Report20_summary->GetRow(2);
	$Report20_summary->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
<?php
if ($Report20_summary->TotalGrps > 0) {
	$Report20->ResetCSS();
	$Report20->RowType = EWRPT_ROWTYPE_TOTAL;
	$Report20->RowTotalType = EWRPT_ROWTOTAL_GRAND;
	$Report20->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
	$Report20->RowAttrs["class"] = "ewRptGrandSummary";
	$Report20_summary->RenderRow();
?>
	<!-- tr><td colspan="2"><span class="phpreportmaker">&nbsp;<br /></span></td></tr -->
	<tr<?php echo $Report20->RowAttributes(); ?>><td colspan="2"><?php echo $ReportLanguage->Phrase("RptGrandTotal") ?> (<?php echo ewrpt_FormatNumber($Report20_summary->TotCount,0,-2,-2,-2); ?> <?php echo $ReportLanguage->Phrase("RptDtlRec") ?>)</td></tr>
<?php } ?>
	</tfoot>
</table>
</div>
<?php if ($Report20_summary->TotalGrps > 0) { ?>
<?php if ($Report20->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="Report20smry.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Report20_summary->StartGrp, $Report20_summary->DisplayGrps, $Report20_summary->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Report20smry.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Report20_summary->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Report20_summary->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Report20_summary->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Report20_summary->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Report20_summary->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Report20_summary->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Report20_summary->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Report20_summary->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Report20_summary->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Report20_summary->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Report20->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
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
<?php if ($Report20->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Report20->Export == "" || $Report20->Export == "print" || $Report20->Export == "email") { ?>
<?php } ?>
<?php if ($Report20->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Report20->Export == "" || $Report20->Export == "print" || $Report20->Export == "email") { ?>
<a name="cht_Chart1"></a>
<div id="div_Report20_Chart1"></div>
<?php

// Initialize chart data
$Report20->Chart1->ID = "Report20_Chart1"; // Chart ID
$Report20->Chart1->SetChartParam("type", "5", FALSE); // Chart type
$Report20->Chart1->SetChartParam("seriestype", "0", FALSE); // Chart series type
$Report20->Chart1->SetChartParam("bgcolor", "#FCFCFC", TRUE); // Background color
$Report20->Chart1->SetChartParam("caption", $Report20->Chart1->ChartCaption(), TRUE); // Chart caption
$Report20->Chart1->SetChartParam("xaxisname", $Report20->Chart1->ChartXAxisName(), TRUE); // X axis name
$Report20->Chart1->SetChartParam("yaxisname", $Report20->Chart1->ChartYAxisName(), TRUE); // Y axis name
$Report20->Chart1->SetChartParam("shownames", "1", TRUE); // Show names
$Report20->Chart1->SetChartParam("showvalues", "1", TRUE); // Show values
$Report20->Chart1->SetChartParam("showhovercap", "0", TRUE); // Show hover
$Report20->Chart1->SetChartParam("alpha", "50", FALSE); // Chart alpha
$Report20->Chart1->SetChartParam("colorpalette", "#FF0000|#FF0080|#FF00FF|#8000FF|#FF8000|#FF3D3D|#7AFFFF|#0000FF|#FFFF00|#FF7A7A|#3DFFFF|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
$Report20->Chart1->SetChartParam("showCanvasBg", "1", TRUE); // showCanvasBg
$Report20->Chart1->SetChartParam("showCanvasBase", "1", TRUE); // showCanvasBase
$Report20->Chart1->SetChartParam("showLimits", "1", TRUE); // showLimits
$Report20->Chart1->SetChartParam("animation", "1", TRUE); // animation
$Report20->Chart1->SetChartParam("rotateNames", "0", TRUE); // rotateNames
$Report20->Chart1->SetChartParam("yAxisMinValue", "0", TRUE); // yAxisMinValue
$Report20->Chart1->SetChartParam("yAxisMaxValue", "0", TRUE); // yAxisMaxValue
$Report20->Chart1->SetChartParam("PYAxisMinValue", "0", TRUE); // PYAxisMinValue
$Report20->Chart1->SetChartParam("PYAxisMaxValue", "0", TRUE); // PYAxisMaxValue
$Report20->Chart1->SetChartParam("SYAxisMinValue", "0", TRUE); // SYAxisMinValue
$Report20->Chart1->SetChartParam("SYAxisMaxValue", "0", TRUE); // SYAxisMaxValue
$Report20->Chart1->SetChartParam("showColumnShadow", "0", TRUE); // showColumnShadow
$Report20->Chart1->SetChartParam("showPercentageValues", "1", TRUE); // showPercentageValues
$Report20->Chart1->SetChartParam("showPercentageInLabel", "1", TRUE); // showPercentageInLabel
$Report20->Chart1->SetChartParam("showBarShadow", "0", TRUE); // showBarShadow
$Report20->Chart1->SetChartParam("showAnchors", "1", TRUE); // showAnchors
$Report20->Chart1->SetChartParam("showAreaBorder", "1", TRUE); // showAreaBorder
$Report20->Chart1->SetChartParam("isSliced", "1", TRUE); // isSliced
$Report20->Chart1->SetChartParam("showAsBars", "0", TRUE); // showAsBars
$Report20->Chart1->SetChartParam("showShadow", "0", TRUE); // showShadow
$Report20->Chart1->SetChartParam("formatNumber", "0", TRUE); // formatNumber
$Report20->Chart1->SetChartParam("formatNumberScale", "0", TRUE); // formatNumberScale
$Report20->Chart1->SetChartParam("decimalSeparator", ".", TRUE); // decimalSeparator
$Report20->Chart1->SetChartParam("thousandSeparator", ",", TRUE); // thousandSeparator
$Report20->Chart1->SetChartParam("decimalPrecision", "2", TRUE); // decimalPrecision
$Report20->Chart1->SetChartParam("divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
$Report20->Chart1->SetChartParam("limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
$Report20->Chart1->SetChartParam("zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
$Report20->Chart1->SetChartParam("showDivLineValue", "1", TRUE); // showDivLineValue
$Report20->Chart1->SetChartParam("showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
$Report20->Chart1->SetChartParam("showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
$Report20->Chart1->SetChartParam("hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
$SqlSelect = $Report20->SqlSelect();
$SqlChartSelect = $Report20->Chart1->SqlSelect;
$sSqlChartBase = "(" . ewrpt_BuildReportSql($SqlSelect, $Report20->SqlWhere(), $Report20->SqlGroupBy(), $Report20->SqlHaving(), $Report20->SqlOrderBy(), $Report20_summary->Filter, "") . ") EW_TMP_TABLE";

// Load chart data from sql directly
$sSql = $SqlChartSelect . $sSqlChartBase;
$sSql = ewrpt_BuildReportSql($sSql, "", $Report20->Chart1->SqlGroupBy, "", $Report20->Chart1->SqlOrderBy, "", "");
if (EWRPT_DEBUG_ENABLED) echo "(Chart SQL): " . $sSql . "<br>";
ewrpt_LoadChartData($sSql, $Report20->Chart1);
ewrpt_SortChartData($Report20->Chart1->Data, 0, "");

// Call Chart_Rendering event
$Report20->Chart_Rendering($Report20->Chart1);
$chartxml = $Report20->Chart1->ChartXml();

// Call Chart_Rendered event
$Report20->Chart_Rendered($Report20->Chart1, $chartxml);
echo $Report20->Chart1->ShowChartFCF($chartxml);
?>
<a href="#top"><?php echo $ReportLanguage->Phrase("Top") ?></a>
<br /><br />
<?php } ?>
<?php if ($Report20->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Report20_summary->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Report20->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Report20_summary->Page_Terminate();
?>
<?php

//
// Page class
//
class crReport20_summary {

	// Page ID
	var $PageID = 'summary';

	// Table name
	var $TableName = 'Report20';

	// Page object name
	var $PageObjName = 'Report20_summary';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Report20;
		if ($Report20->UseTokenInUrl) $PageUrl .= "t=" . $Report20->TableVar . "&"; // Add page token
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
		global $Report20;
		if ($Report20->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Report20->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Report20->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crReport20_summary() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Report20)
		$GLOBALS["Report20"] = new crReport20();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'summary', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Report20', TRUE);

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
		global $Report20;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Report20->Export = $_GET["export"];
	}
	$gsExport = $Report20->Export; // Get export parameter, used in header
	$gsExportFile = $Report20->TableVar; // Get export file, used in header

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
		global $Report20;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Report20->Export == "email") {
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
		global $Report20;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 3;
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
		$this->Col = array(FALSE, FALSE, FALSE);

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
		$sSql = ewrpt_BuildReportSql($Report20->SqlSelect(), $Report20->SqlWhere(), $Report20->SqlGroupBy(), $Report20->SqlHaving(), $Report20->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Report20->ExportAll && $Report20->Export <> "")
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
		global $Report20;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Report20->questions->setDbValue($rs->fields('questions'));
			$Report20->marks->setDbValue($rs->fields('marks'));
			$this->Val[1] = $Report20->questions->CurrentValue;
			$this->Val[2] = $Report20->marks->CurrentValue;
		} else {
			$Report20->questions->setDbValue("");
			$Report20->marks->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Report20;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Report20->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Report20->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Report20->getStartGroup();
			}
		} else {
			$this->StartGrp = $Report20->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Report20->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Report20->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Report20->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Report20;

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
		global $Report20;
		$this->StartGrp = 1;
		$Report20->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Report20;
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
			$Report20->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Report20->setStartGroup($this->StartGrp);
		} else {
			if ($Report20->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Report20->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Report20;
		if ($Report20->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Report20->SqlSelectCount(), $Report20->SqlWhere(), $Report20->SqlGroupBy(), $Report20->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}
		}

		// Call Row_Rendering event
		$Report20->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Report20->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// questions
			$Report20->questions->ViewValue = $Report20->questions->Summary;

			// marks
			$Report20->marks->ViewValue = $Report20->marks->Summary;
		} else {

			// questions
			$Report20->questions->ViewValue = $Report20->questions->CurrentValue;
			$Report20->questions->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// marks
			$Report20->marks->ViewValue = $Report20->marks->CurrentValue;
			$Report20->marks->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// questions
		if ($Report20->questions->CurrentValue <> "") {
			$Report20->questions->HrefValue = $Report20->questions->CurrentValue;
			if ($Report20->Export <> "") $Report20->questions->HrefValue = ewrpt_ConvertFullUrl($Report20->questions->HrefValue);
		} else {
			$Report20->questions->HrefValue = "";
		}

		// marks
		$Report20->marks->HrefValue = "";

		// Call Row_Rendered event
		$Report20->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Report20;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Report20;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Report20->setOrderBy("");
				$Report20->setStartGroup(1);
				$Report20->questions->setSort("");
				$Report20->marks->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Report20->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Report20->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Report20->SortSql();
			$Report20->setOrderBy($sSortSql);
			$Report20->setStartGroup(1);
		}
		return $Report20->getOrderBy();
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
