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
$Crosstab1 = NULL;

//
// Table class for Crosstab1
//
class crCrosstab1 {
	var $TableVar = 'Crosstab1';
	var $TableName = 'Crosstab1';
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
	var $First_Name;
	var $Last_Name;
	var $Paper_Name;
	var $Total_Marks;
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

	// Summary cells
	var $SummaryCellAttrs;
	var $SummaryViewAttrs;
	var $SummaryCurrentValue;
	var $SummaryViewValue;

	// Summary cell attributes
	function SummaryCellAttributes($i) {
		$sAtt = "";
		if (is_array($this->SummaryCellAttrs)) {
			if ($i >= 0 && $i < count($this->SummaryCellAttrs)) {
				$Attrs = $this->SummaryCellAttrs[$i];
				if (is_array($Attrs)) {
					foreach ($Attrs as $k => $v) {
						if (trim($v) <> "")
							$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
					}
				}
			}
		}
		return $sAtt;
	}

	// Summary view attributes
	function SummaryViewAttributes($i) {
		$sAtt = "";
		if (is_array($this->SummaryViewAttrs)) {
			if ($i >= 0 && $i < count($this->SummaryViewAttrs)) {
				$Attrs = $this->SummaryViewAttrs[$i];
				if (is_array($Attrs)) {
					foreach ($Attrs as $k => $v) {
						if (trim($v) <> "")
							$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
					}
				}
			}
		}
		return $sAtt;
	}

	//
	// Table class constructor
	//
	function crCrosstab1() {
		global $ReportLanguage;

		// First Name
		$this->First_Name = new crField('Crosstab1', 'Crosstab1', 'x_First_Name', 'First Name', 's.first_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->First_Name->GroupingFieldId = 1;
		$this->fields['First_Name'] =& $this->First_Name;
		$this->First_Name->DateFilter = "";
		$this->First_Name->SqlSelect = "";
		$this->First_Name->SqlOrderBy = "";

		// Last Name
		$this->Last_Name = new crField('Crosstab1', 'Crosstab1', 'x_Last_Name', 'Last Name', 's.last_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->Last_Name->GroupingFieldId = 2;
		$this->fields['Last_Name'] =& $this->Last_Name;
		$this->Last_Name->DateFilter = "";
		$this->Last_Name->SqlSelect = "";
		$this->Last_Name->SqlOrderBy = "";

		// Paper Name
		$this->Paper_Name = new crField('Crosstab1', 'Crosstab1', 'x_Paper_Name', 'Paper Name', 'p.paper_name', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Paper_Name'] =& $this->Paper_Name;
		$this->Paper_Name->DateFilter = "";
		$this->Paper_Name->SqlSelect = "";
		$this->Paper_Name->SqlOrderBy = "";

		// Total Marks
		$this->Total_Marks = new crField('Crosstab1', 'Crosstab1', 'x_Total_Marks', 'Total Marks', 'c.totalmarks', 3, EWRPT_DATATYPE_NUMBER, -1);
		$this->Total_Marks->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['Total_Marks'] =& $this->Total_Marks;
		$this->Total_Marks->DateFilter = "";
		$this->Total_Marks->SqlSelect = "";
		$this->Total_Marks->SqlOrderBy = "";
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
	function ColumnField() { // Column field
		return "c.totalmarks";
	}

	function ColumnDateType() { // Column date type
		return "";
	}

	function SummaryField() { // Summary field
		return "p.paper_name";
	}

	function SummaryType() { // Summary type
		return "MAX";
	}

	function ColumnCaptions() { // Column captions
		global $ReportLanguage;
		return "";
	}

	function ColumnNames() { // Column names
		return "";
	}

	function ColumnValues() { // Column values
		return "";
	}

	function SqlFrom() { // From
		return "students As s, papers As p, class_std As c";
	}

	function SqlSelect() { // Select
		return "SELECT s.first_name AS `First Name`, s.last_name AS `Last Name`, <DistinctColumnFields> FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "s.std_id = c.std_id And c.paper_id = p.paper_id";
	}

	function SqlGroupBy() { // Group By
		return "s.first_name, s.last_name";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "s.first_name ASC, s.last_name ASC";
	}

	function SqlDistinctSelect() {
		return "SELECT DISTINCT c.totalmarks FROM students As s, papers As p, class_std As c";
	}

	function SqlDistinctWhere() {
		return "s.std_id = c.std_id And c.paper_id = p.paper_id";
	}

	function SqlDistinctOrderBy() {
		return "c.totalmarks ASC";
	}

	// Table Level Group SQL
	function SqlFirstGroupField() {
		return "s.first_name";
	}

	function SqlSelectGroup() {
		return "SELECT DISTINCT " . $this->SqlFirstGroupField() . " FROM " . $this->SqlFrom();
	}

	function SqlOrderByGroup() {
		return "s.first_name ASC";
	}

	function SqlSelectAgg() {
		return "SELECT <DistinctColumnFields> FROM " . $this->SqlFrom();
	}

	function SqlGroupByAgg() {
		return "";
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
$Crosstab1_crosstab = new crCrosstab1_crosstab();
$Page =& $Crosstab1_crosstab;

// Page init
$Crosstab1_crosstab->Page_Init();

// Page main
$Crosstab1_crosstab->Page_Main();
?>
<?php include "phprptinc/header.php"; ?>
<?php if ($Crosstab1->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Crosstab1_crosstab->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Crosstab1_crosstab->ShowMessage(); ?>
<?php if ($Crosstab1->Export == "" || $Crosstab1->Export == "print" || $Crosstab1->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Crosstab1->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<!-- Table container (begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top container (begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Crosstab1->Export == "" || $Crosstab1->Export == "print" || $Crosstab1->Export == "email") { ?>
<?php } ?>
<?php echo $Crosstab1->TableCaption() ?>
<?php if ($Crosstab1->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Crosstab1_crosstab->ExportPrintUrl ?>"><?php echo $ReportLanguage->Phrase("PrinterFriendly") ?></a>
<?php } ?>
<br /><br />
<?php if ($Crosstab1->Export == "") { ?>
</div></td></tr>
<!-- Top container (end) -->
<tr>
	<!-- Left container (begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- left slot -->
<?php } ?>
<?php if ($Crosstab1->Export == "" || $Crosstab1->Export == "print" || $Crosstab1->Export == "email") { ?>
<?php } ?>
<?php if ($Crosstab1->Export == "") { ?>
	</div></td>
	<!-- Left container (end) -->
	<!-- Center container (report) (begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- crosstab report starts -->
<div id="report_crosstab">
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if ($Crosstab1->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="Crosstab1ctb.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Crosstab1_crosstab->StartGrp, $Crosstab1_crosstab->DisplayGrps, $Crosstab1_crosstab->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="Crosstab1ctb.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="Crosstab1ctb.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="Crosstab1ctb.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="Crosstab1ctb.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
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
	<?php if ($Crosstab1_crosstab->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Crosstab1_crosstab->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("GroupsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="1"<?php if ($Crosstab1_crosstab->DisplayGrps == 1) echo " selected=\"selected\"" ?>>1</option>
<option value="2"<?php if ($Crosstab1_crosstab->DisplayGrps == 2) echo " selected=\"selected\"" ?>>2</option>
<option value="3"<?php if ($Crosstab1_crosstab->DisplayGrps == 3) echo " selected=\"selected\"" ?>>3</option>
<option value="4"<?php if ($Crosstab1_crosstab->DisplayGrps == 4) echo " selected=\"selected\"" ?>>4</option>
<option value="5"<?php if ($Crosstab1_crosstab->DisplayGrps == 5) echo " selected=\"selected\"" ?>>5</option>
<option value="10"<?php if ($Crosstab1_crosstab->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Crosstab1_crosstab->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Crosstab1_crosstab->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Crosstab1->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report grid (begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php if ($Crosstab1_crosstab->ShowFirstHeader) { // Show header ?>
	<thead>
	<!-- Table header -->
	<tr class="ewTableRow">
		<td colspan="2" style="white-space: nowrap;"><div class="phpreportmaker"><?php echo $Crosstab1->Paper_Name->FldCaption() ?>&nbsp;(<?php echo $ReportLanguage->Phrase("RptMax") ?>)&nbsp;</div></td>
		<td class="ewRptColHeader" colspan="<?php echo @$Crosstab1_crosstab->ColSpan; ?>" style="white-space: nowrap;">
			<?php echo $Crosstab1->Total_Marks->FldCaption() ?>
		</td>
	</tr>
	<tr>
<td class="ewTableHeader">
<?php if ($Crosstab1->Export <> "") { ?>
<?php echo $Crosstab1->First_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Crosstab1->SortUrl($Crosstab1->First_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Crosstab1->First_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Crosstab1->SortUrl($Crosstab1->First_Name) ?>',0);"><?php echo $Crosstab1->First_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Crosstab1->First_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Crosstab1->First_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<td class="ewTableHeader">
<?php if ($Crosstab1->Export <> "") { ?>
<?php echo $Crosstab1->Last_Name->FldCaption() ?>
<?php } else { ?>
	<table cellspacing="0" class="ewTableHeaderBtn"><tr>
<?php if ($Crosstab1->SortUrl($Crosstab1->Last_Name) == "") { ?>
		<td style="vertical-align: bottom;"><?php echo $Crosstab1->Last_Name->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Crosstab1->SortUrl($Crosstab1->Last_Name) ?>',0);"><?php echo $Crosstab1->Last_Name->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Crosstab1->Last_Name->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Crosstab1->Last_Name->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
<?php } ?>
</td>
<!-- Dynamic columns begin -->
	<?php
	$cntval = count($Crosstab1_crosstab->Val);
	for ($iy = 1; $iy < $cntval; $iy++) {
		if ($Crosstab1_crosstab->Col[$iy]->Visible) {
			$Crosstab1->SummaryCurrentValue[$iy-1] = $Crosstab1_crosstab->Col[$iy]->Caption;
			$Crosstab1->SummaryViewValue[$iy-1] = $Crosstab1->SummaryCurrentValue[$iy-1];
	?>
		<td class="ewTableHeader"<?php echo $Crosstab1->Total_Marks->CellAttributes() ?>><div<?php echo $Crosstab1->Total_Marks->ViewAttributes() ?>><?php echo $Crosstab1->SummaryViewValue[$iy-1]; ?></div></td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
	</thead>
<?php } // End show header ?>
	<tbody>
<?php
if ($Crosstab1_crosstab->TotalGrps > 0) {

// Set the last group to display if not export all
if ($Crosstab1->ExportAll && $Crosstab1->Export <> "") {
	$Crosstab1_crosstab->StopGrp = $Crosstab1_crosstab->TotalGrps;
} else {
	$Crosstab1_crosstab->StopGrp = $Crosstab1_crosstab->StartGrp + $Crosstab1_crosstab->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Crosstab1_crosstab->StopGrp) > intval($Crosstab1_crosstab->TotalGrps)) {
	$Crosstab1_crosstab->StopGrp = $Crosstab1_crosstab->TotalGrps;
}

// Navigate
$Crosstab1_crosstab->RecCount = 0;

// Get first row
if ($Crosstab1_crosstab->TotalGrps > 0) {
	$Crosstab1_crosstab->GetGrpRow(1);
	$Crosstab1_crosstab->GrpCount = 1;
}
while ($rsgrp && !$rsgrp->EOF && $Crosstab1_crosstab->GrpCount <= $Crosstab1_crosstab->DisplayGrps) {

	// Build detail SQL
	$sWhere = ewrpt_DetailFilterSQL($Crosstab1->First_Name, $Crosstab1->SqlFirstGroupField(), $Crosstab1->First_Name->GroupValue());
	if ($Crosstab1_crosstab->Filter != "")
		$sWhere = "($Crosstab1_crosstab->Filter) AND ($sWhere)";
	$sSql = ewrpt_BuildReportSql($Crosstab1_crosstab->SqlSelectWork, $Crosstab1->SqlWhere(), $Crosstab1->SqlGroupBy(), "", $Crosstab1->SqlOrderBy(), $sWhere, $Crosstab1_crosstab->Sort);
	$rs = $conn->Execute($sSql);
	$rsdtlcnt = ($rs) ? $rs->RecordCount() : 0;
	if ($rsdtlcnt > 0)
		$Crosstab1_crosstab->GetRow(1);
	while ($rs && !$rs->EOF) {
		$Crosstab1_crosstab->RecCount++;

		// Render row
		$Crosstab1->ResetCSS();
		$Crosstab1->RowType = EWRPT_ROWTYPE_DETAIL;
		$Crosstab1_crosstab->RenderRow();
?>
	<!-- Data -->
	<tr<?php echo $Crosstab1->RowAttributes(); ?>>
		<!-- First Name -->
		<td<?php echo $Crosstab1->First_Name->CellAttributes(); ?>><div<?php echo $Crosstab1->First_Name->ViewAttributes(); ?>><?php echo $Crosstab1->First_Name->GroupViewValue; ?></div></td>
		<!-- Last Name -->
		<td<?php echo $Crosstab1->Last_Name->CellAttributes(); ?>><div<?php echo $Crosstab1->Last_Name->ViewAttributes(); ?>><?php echo $Crosstab1->Last_Name->GroupViewValue; ?></div></td>
<!-- Dynamic columns begin -->
	<?php
		$cntcol = count($Crosstab1->SummaryViewValue);
		for ($iy = 1; $iy <= $cntcol; $iy++) {
			$bColShow = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Visible : TRUE;
			$sColDesc = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Caption : $ReportLanguage->Phrase("Summary");
			if ($bColShow) {
	?>
		<!-- <?php //echo $Crosstab1_crosstab->Col[$iy]->Caption; ?> -->
		<!-- <?php echo $sColDesc; ?> -->
		<td<?php echo $Crosstab1->SummaryCellAttributes($iy-1) ?>><div<?php echo $Crosstab1->SummaryViewAttributes($iy-1); ?>><?php echo $Crosstab1->SummaryViewValue[$iy-1]; ?></div></td>
	<?php
			}
		}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php

		// Accumulate page summary
		$Crosstab1_crosstab->AccumulateSummary();

		// Get next record
		$Crosstab1_crosstab->GetRow(2);
?>
<?php

		// Process summary level 2
		if ($Crosstab1_crosstab->ChkLvlBreak(2)) {
			$Crosstab1->ResetCSS();
			$Crosstab1->RowType = EWRPT_ROWTYPE_TOTAL;
			$Crosstab1->RowTotalType = EWRPT_ROWTOTAL_GROUP;
			$Crosstab1->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
			$Crosstab1->RowGroupLevel = 2;
			$Crosstab1_crosstab->RenderRow();
?>
	<!-- Summary Last Name (level 2) -->
	<tr<?php echo $Crosstab1->RowAttributes(); ?>>
		<td<?php echo $Crosstab1->First_Name->CellAttributes() ?>>&nbsp;</td>
		<td colspan="1"<?php echo $Crosstab1->Last_Name->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSumHead") ?> <?php echo $Crosstab1->Last_Name->FldCaption() ?>: <?php echo $Crosstab1->Last_Name->GroupViewValue; ?></td>
<!-- Dynamic columns begin -->
	<?php
	$cntcol = count($Crosstab1->SummaryViewValue);
	for ($iy = 1; $iy <= $cntcol; $iy++) {
		$bColShow = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Visible : TRUE;
		$sColDesc = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Caption : $ReportLanguage->Phrase("Summary");
		if ($bColShow) {
	?>
		<!-- <?php //echo $Crosstab1_crosstab->Col[$iy]->Caption; ?> -->
		<!-- <?php echo $sColDesc; ?> -->
		<td<?php echo $Crosstab1->SummaryCellAttributes($iy-1) ?>><div<?php echo $Crosstab1->SummaryViewAttributes($iy-1); ?>><?php echo $Crosstab1->SummaryViewValue[$iy-1]; ?></div></td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php

			// Reset level 2 summary
			$Crosstab1_crosstab->ResetLevelSummary(2);
		}
?>
<?php
	} // End detail records loop
?>
<?php

		// Process summary level 1
		if ($Crosstab1_crosstab->ChkLvlBreak(1)) {
			$Crosstab1->ResetCSS();
			$Crosstab1->RowType = EWRPT_ROWTYPE_TOTAL;
			$Crosstab1->RowTotalType = EWRPT_ROWTOTAL_GROUP;
			$Crosstab1->RowTotalSubType = EWRPT_ROWTOTAL_FOOTER;
			$Crosstab1->RowGroupLevel = 1;
			$Crosstab1_crosstab->RenderRow();
?>
	<!-- Summary First Name (level 1) -->
	<tr<?php echo $Crosstab1->RowAttributes(); ?>>
		<td colspan="2"<?php echo $Crosstab1->First_Name->CellAttributes() ?>><?php echo $ReportLanguage->Phrase("RptSumHead") ?> <?php echo $Crosstab1->First_Name->FldCaption() ?>: <?php echo $Crosstab1->First_Name->GroupViewValue; ?></td>
<!-- Dynamic columns begin -->
	<?php
	$cntcol = count($Crosstab1->SummaryViewValue);
	for ($iy = 1; $iy <= $cntcol; $iy++) {
		$bColShow = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Visible : TRUE;
		$sColDesc = ($iy <= $Crosstab1_crosstab->ColCount) ? $Crosstab1_crosstab->Col[$iy]->Caption : $ReportLanguage->Phrase("Summary");
		if ($bColShow) {
	?>
		<!-- <?php //echo $Crosstab1_crosstab->Col[$iy]->Caption; ?> -->
		<!-- <?php echo $sColDesc; ?> -->
		<td<?php echo $Crosstab1->SummaryCellAttributes($iy-1) ?>><div<?php echo $Crosstab1->SummaryViewAttributes($iy-1); ?>><?php echo $Crosstab1->SummaryViewValue[$iy-1]; ?></div></td>
	<?php
		}
	}
	?>
<!-- Dynamic columns end -->
	</tr>
<?php

			// Reset level 1 summary
			$Crosstab1_crosstab->ResetLevelSummary(1);
		}
?>
<?php
	$Crosstab1_crosstab->GetGrpRow(2);
	$Crosstab1_crosstab->GrpCount++;
}
?>
	</tbody>
	<tfoot>
<?php } ?>
	</tfoot>
</table>
</div>
</td></tr></table>
</div>
<!-- Crosstab report ends -->
<?php if ($Crosstab1->Export == "") { ?>
	</div><br /></td>
	<!-- Center container (report) (end) -->
	<!-- Right container (begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- right slot -->
<?php } ?>
<?php if ($Crosstab1->Export == "" || $Crosstab1->Export == "print" || $Crosstab1->Export == "email") { ?>
<?php } ?>
<?php if ($Crosstab1->Export == "") { ?>
	</div></td>
	<!-- Right container (end) -->
</tr>
<!-- Bottom container (begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- bottom slot -->
<?php } ?>
<?php if ($Crosstab1->Export == "" || $Crosstab1->Export == "print" || $Crosstab1->Export == "email") { ?>
<?php } ?>
<?php if ($Crosstab1->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom container (end) -->
</table>
<!-- Table container (end) -->
<?php } ?>
<?php $Crosstab1_crosstab->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Crosstab1->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/footer.php"; ?>
<?php
$Crosstab1_crosstab->Page_Terminate();
?>
<?php

//
// Page class
//
class crCrosstab1_crosstab {

	// Page ID
	var $PageID = 'crosstab';

	// Table name
	var $TableName = 'Crosstab1';

	// Page object name
	var $PageObjName = 'Crosstab1_crosstab';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Crosstab1;
		if ($Crosstab1->UseTokenInUrl) $PageUrl .= "t=" . $Crosstab1->TableVar . "&"; // Add page token
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
		global $Crosstab1;
		if ($Crosstab1->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Crosstab1->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Crosstab1->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crCrosstab1_crosstab() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Crosstab1)
		$GLOBALS["Crosstab1"] = new crCrosstab1();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'crosstab', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Crosstab1', TRUE);

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
		global $Crosstab1;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Crosstab1->Export = $_GET["export"];
	}
	$gsExport = $Crosstab1->Export; // Get export parameter, used in header
	$gsExportFile = $Crosstab1->TableVar; // Get export file, used in header

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
		global $Crosstab1;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Crosstab1->Export == "email") {
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
	var $Cnt, $Col, $Val, $Smry;
	var $ColCount, $ColSpan;
	var $SqlSelectWork, $SqlSelectAggWork;
	var $SqlChartWork;

	//
	// Page main
	//
	function Page_Main() {
		global $Crosstab1;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Get sort
		$this->Sort = $this->GetSort();

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Popup values and selections
		// Set up popup filter

		$this->SetupPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Load columns to array
		$this->GetColumns();

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

		// Get total group count
		$sGrpSort = ewrpt_UpdateSortFields($Crosstab1->SqlOrderByGroup(), $this->Sort, 2); // Get grouping field only
		$sSql = ewrpt_BuildReportSql($Crosstab1->SqlSelectGroup(), $Crosstab1->SqlWhere(), $Crosstab1->SqlGroupBy(), "", $Crosstab1->SqlOrderByGroup(), $this->Filter, $sGrpSort);
		$this->TotalGrps = $this->GetGrpCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Crosstab1->ExportAll && $Crosstab1->Export <> "")
			$this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup();

		// Get total groups
		$rsgrp = $this->GetGrpRs($sSql, $this->StartGrp, $this->DisplayGrps);

		// Init detail recordset
		$rs = NULL;

		// Set up column attributes
		$Crosstab1->Total_Marks->ViewAttrs["style"] = "";
		$Crosstab1->Total_Marks->CellAttrs["style"] = "vertical-align: top;";
	}

	// Get column values
	function GetColumns() {
		global $conn;
		global $Crosstab1;
		global $ReportLanguage;

		// Build SQL
		$sSql = ewrpt_BuildReportSql($Crosstab1->SqlDistinctSelect(), $Crosstab1->SqlDistinctWhere(), "", "", $Crosstab1->SqlDistinctOrderBy(), $this->Filter, "");

		// Load recordset
		$rscol = $conn->Execute($sSql);

		// Get distinct column count
		$this->ColCount = ($rscol) ? $rscol->RecordCount() : 0;
		if ($this->ColCount == 0) {
			if ($rscol) $rscol->Close();
			echo $ReportLanguage->Phrase("NoDistinctColVals") . $sSql . "<br />";
			exit();
		}

		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of distinct values

		$nGrps = 2;
		$this->Col = ewrpt_InitArray($this->ColCount+1, NULL);
		$this->Val = ewrpt_InitArray($this->ColCount+1, NULL);
		$this->ValCnt = ewrpt_InitArray($this->ColCount+1, NULL);
		$this->Cnt = ewrpt_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->Smry = ewrpt_Init2DArray($this->ColCount+1, $nGrps+1, NULL);
		$this->SmryCnt = ewrpt_Init2DArray($this->ColCount+1, $nGrps+1, NULL);

		// Reset summary values
		$this->ResetLevelSummary(0);
		$colcnt = 0;
		while (!$rscol->EOF) {
			if (is_null($rscol->fields[0])) {
				$wrkValue = EWRPT_NULL_VALUE;
				$wrkCaption = $ReportLanguage->Phrase("NullLabel");
			} elseif ($rscol->fields[0] == "") {
				$wrkValue = EWRPT_EMPTY_VALUE;
				$wrkCaption = $ReportLanguage->Phrase("EmptyLabel");
			} else {
				$wrkValue = $rscol->fields[0];
				$wrkCaption = $rscol->fields[0];
			}
			$colcnt++;
			$this->Col[$colcnt] = new crCrosstabColumn($wrkValue, $wrkCaption, TRUE);
			$rscol->MoveNext();
		}
		$rscol->Close();

		// Get active columns
		if (!is_array($Crosstab1->Total_Marks->SelectionList)) {
			$this->ColSpan = $this->ColCount;
		} else {
			$this->ColSpan = 0;
			for ($i = 1; $i <= $this->ColCount; $i++) {
				$bSelected = FALSE;
				$cntsel = count($Crosstab1->Total_Marks->SelectionList);
				for ($j = 0; $j < $cntsel; $j++) {
					if (ewrpt_CompareValue($Crosstab1->Total_Marks->SelectionList[$j], $this->Col[$i]->Value, $Crosstab1->Total_Marks->FldType)) {
						$this->ColSpan++;
						$bSelected = TRUE;
						break;
					}
				}
				$this->Col[$i]->Visible = $bSelected;
			}
		}

		// Update crosstab sql
		$sSqlFlds = "";
		for ($colcnt = 1; $colcnt <= $this->ColCount; $colcnt++) {
			$sFld = ewrpt_CrossTabField($Crosstab1->SummaryType(), $Crosstab1->SummaryField(), $Crosstab1->ColumnField(), $Crosstab1->ColumnDateType(), $this->Col[$colcnt]->Value, "", "C" . $colcnt);
			if ($sSqlFlds <> "")
				$sSqlFlds .= ", ";
			$sSqlFlds .= $sFld;
		}
		$this->SqlSelectWork = str_replace("<DistinctColumnFields>", $sSqlFlds, $Crosstab1->SqlSelect());
		$this->SqlSelectAggWork = str_replace("<DistinctColumnFields>", $sSqlFlds, $Crosstab1->SqlSelectAgg());

		// Update chart sql if Y Axis = Column Field
		$this->SqlChartWork = "";
		for ($i = 0; $i < $this->ColCount; $i++) {
			if ($this->Col[$i+1]->Visible) {
				$sChtFld = ewrpt_CrossTabField("SUM", $Crosstab1->SummaryField(), $Crosstab1->ColumnField(), $Crosstab1->ColumnDateType(), $this->Col[$i+1]->Value, "");
				if ($this->SqlChartWork != "") $this->SqlChartWork .= "+";
				$this->SqlChartWork .= $sChtFld;
			}
		}
	}

	// Get group count
	function GetGrpCnt($sql) {
		global $conn;
		$rsgrpcnt = $conn->Execute($sql);
		$grpcnt = ($rsgrpcnt) ? $rsgrpcnt->RecordCount() : 0;
		if ($rsgrpcnt) $rsgrpcnt->Close();
		return $grpcnt;
	}

	// Get group rs
	function GetGrpRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
	}

	// Get group row values
	function GetGrpRow($opt) {
		global $rsgrp;
		global $Crosstab1;
		if (!$rsgrp)
			return;
		if ($opt == 1) { // Get first group

	//		$rsgrp->MoveFirst(); // NOTE: no need to move position
			$Crosstab1->First_Name->setDbValue(""); // Init first value
		} else { // Get next group
			$rsgrp->MoveNext();
		}
		if (!$rsgrp->EOF) {
			$Crosstab1->First_Name->setDbValue($rsgrp->fields[0]);
		} else {
			$Crosstab1->First_Name->setDbValue("");
		}
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		global $Crosstab1;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			if ($opt <> 1)
				$Crosstab1->First_Name->setDbValue($rs->fields('First Name'));
			$Crosstab1->Last_Name->setDbValue($rs->fields('Last Name'));
			$cntval = count($this->Val);
			for ($ix = 1; $ix < $cntval; $ix++)
				$this->Val[$ix] = $rs->fields[$ix+2-1];
		} else {
			$Crosstab1->First_Name->setDbValue("");
			$Crosstab1->Last_Name->setDbValue("");
		}
	}

	// Check level break
	function ChkLvlBreak($lvl) {
		global $Crosstab1;
		switch ($lvl) {
			case 1:
				return (is_null($Crosstab1->First_Name->CurrentValue) && !is_null($Crosstab1->First_Name->OldValue)) ||
					(!is_null($Crosstab1->First_Name->CurrentValue) && is_null($Crosstab1->First_Name->OldValue)) ||
					($Crosstab1->First_Name->GroupValue() <> $Crosstab1->First_Name->GroupOldValue());
			case 2:
				return (is_null($Crosstab1->Last_Name->CurrentValue) && !is_null($Crosstab1->Last_Name->OldValue)) ||
					(!is_null($Crosstab1->Last_Name->CurrentValue) && is_null($Crosstab1->Last_Name->OldValue)) ||
					($Crosstab1->Last_Name->GroupValue() <> $Crosstab1->Last_Name->GroupOldValue()) || $this->ChkLvlBreak(1); // Recurse upper level
		}
	}

	// Accummulate summary
	function AccumulateSummary() {
		global $Crosstab1;
		$cntx = count($this->Smry);
		for ($ix = 1; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 0; $iy < $cnty; $iy++) {
				$valwrk = $this->Val[$ix];
				$this->Cnt[$ix][$iy]++;
				$this->Smry[$ix][$iy] = ewrpt_SummaryValue($this->Smry[$ix][$iy], $valwrk, $Crosstab1->SummaryType());
			}
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = 1; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = $lvl; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				$this->Smry[$ix][$iy] = Null;
			}
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Set up starting group
	function SetUpStartGroup() {
		global $Crosstab1;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Crosstab1->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Crosstab1->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Crosstab1->getStartGroup();
			}
		} else {
			$this->StartGrp = $Crosstab1->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Crosstab1->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Crosstab1->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Crosstab1->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Crosstab1;

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
		global $Crosstab1;

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$Crosstab1->setStartGroup($this->StartGrp);
	}

	// Check if any column values is present
	function HasColumnValues(&$rs) {
		$cntcol = count($this->Col);
		for ($i = 1; $i < $cntcol; $i++) {
			if ($this->Col[$i]->Visible) {
				if ($rs->fields[2+$i-1] <> 0) return TRUE;
			}
		}
		return FALSE;
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Crosstab1;
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
			$Crosstab1->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Crosstab1->setStartGroup($this->StartGrp);
		} else {
			if ($Crosstab1->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Crosstab1->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 2; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Crosstab1;

		// Set up summary values
		$colcnt = $this->ColCount;
		$Crosstab1->SummaryCellAttrs = ewrpt_InitArray($colcnt, NULL);
		$Crosstab1->SummaryViewAttrs = ewrpt_InitArray($colcnt, NULL);
		$Crosstab1->SummaryCurrentValue = ewrpt_InitArray($colcnt, NULL);
		$Crosstab1->SummaryViewValue = ewrpt_InitArray($colcnt, NULL);
		if ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// aggregate sql
			$sSql = ewrpt_BuildReportSql($this->SqlSelectAggWork, $Crosstab1->SqlWhere(), $Crosstab1->SqlGroupByAgg(), "", "", $this->Filter, "");
			$rsagg = $conn->Execute($sSql);
			if ($rsagg && !$rsagg->EOF) $rsagg->MoveFirst();
		}
		for ($i = 1; $i <= $this->ColCount; $i++) {
			if ($this->Col[$i]->Visible) {
				if ($Crosstab1->RowType == EWRPT_ROWTYPE_DETAIL) { // Detail row
					$thisval = $this->Val[$i];
				} elseif ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_GROUP) { // Group total
					$thisval = $this->Smry[$i][$Crosstab1->RowGroupLevel];
				} elseif ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_PAGE) { // Page total
					$thisval = $this->Smry[$i][0];
				} elseif ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total
					$thisval = ($rsagg && !$rsagg->EOF) ? $rsagg->fields[$i+0-1] : 0;
				}
				$Crosstab1->SummaryCurrentValue[$i-1] = $thisval;
			}
		}
		if ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total
			if ($rsagg) $rsagg->Close();
		}

		// Call Row_Rendering event
		$Crosstab1->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Crosstab1->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// First Name
			$Crosstab1->First_Name->GroupViewValue = $Crosstab1->First_Name->GroupOldValue();
			$Crosstab1->First_Name->CellAttrs["class"] = ($Crosstab1->RowGroupLevel == 1) ? "ewRptGrpSummary1" : "ewRptGrpField1";

			// Last Name
			$Crosstab1->Last_Name->GroupViewValue = $Crosstab1->Last_Name->GroupOldValue();
			$Crosstab1->Last_Name->CellAttrs["class"] = ($Crosstab1->RowGroupLevel == 2) ? "ewRptGrpSummary2" : "ewRptGrpField2";

			// Set up summary values
			$scvcnt = count($Crosstab1->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$Crosstab1->SummaryViewValue[$i] = $Crosstab1->SummaryCurrentValue[$i];
				$Crosstab1->SummaryViewAttrs[$i]["style"] = "";
				$Crosstab1->SummaryCellAttrs[$i]["style"] = "";
				$Crosstab1->SummaryCellAttrs[$i]["class"] = ($Crosstab1->RowTotalType == EWRPT_ROWTOTAL_GROUP) ? "ewRptGrpSummary" . $Crosstab1->RowGroupLevel : "";
			}
		} else {

			// First Name
			$Crosstab1->First_Name->GroupViewValue = $Crosstab1->First_Name->GroupValue();
			$Crosstab1->First_Name->CellAttrs["class"] = "ewRptGrpField1";
			if ($Crosstab1->First_Name->GroupValue() == $Crosstab1->First_Name->GroupOldValue() && !$this->ChkLvlBreak(1))
				$Crosstab1->First_Name->GroupViewValue = "&nbsp;";

			// Last Name
			$Crosstab1->Last_Name->GroupViewValue = $Crosstab1->Last_Name->GroupValue();
			$Crosstab1->Last_Name->CellAttrs["class"] = "ewRptGrpField2";
			if ($Crosstab1->Last_Name->GroupValue() == $Crosstab1->Last_Name->GroupOldValue() && !$this->ChkLvlBreak(2))
				$Crosstab1->Last_Name->GroupViewValue = "&nbsp;";

			// Set up summary values
			$scvcnt = count($Crosstab1->SummaryCurrentValue);
			for ($i = 0; $i < $scvcnt; $i++) {
				$Crosstab1->SummaryViewValue[$i] = $Crosstab1->SummaryCurrentValue[$i];
				$Crosstab1->SummaryViewAttrs[$i]["style"] = "";
				$Crosstab1->SummaryCellAttrs[$i]["style"] = "";
				$Crosstab1->SummaryCellAttrs[$i]["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
			}
		}

		// First Name
		$Crosstab1->First_Name->HrefValue = "";

		// Last Name
		$Crosstab1->Last_Name->HrefValue = "";

		// Call Row_Rendered event
		$Crosstab1->Row_Rendered();
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Crosstab1;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Crosstab1;

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Crosstab1->setOrderBy("");
				$Crosstab1->setStartGroup(1);
				$Crosstab1->First_Name->setSort("");
				$Crosstab1->Last_Name->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Crosstab1->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Crosstab1->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $Crosstab1->SortSql();
			$Crosstab1->setOrderBy($sSortSql);
			$Crosstab1->setStartGroup(1);
		}
		return $Crosstab1->getOrderBy();
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
