<?php

date_default_timezone_set('Europe/London');

function makeDropdown($v_sName, $v_aValues, $v_iSelected, $class = ''){

	$sDropdown = '<select name=' . $v_sName . ' id=' . $v_sName;

	if (strlen($class) > 0) {
		$sDropdown .= ' class="' . $class . '"';
	}

    $sDropdown .= '>' .PHP_EOL;

	foreach($v_aValues as $iValueId => $sValueName){

		$sDropdown .= '<option value="' . $iValueId . '"';

		if($iValueId == $v_iSelected){

			$sDropdown .= ' selected="selected"';
		}

		$sDropdown .= '>' . $sValueName . '</option>' .PHP_EOL;
	}

	$sDropdown .= '</select>' .PHP_EOL;

	return $sDropdown;
}
#--------------------------------------------------------------------------------
function isPosInt($v_iValue){

	if((is_int((int)$v_iValue)) && ($v_iValue > 0)){

		return true;
	}

	return false;
}
#--------------------------------------------------------------------------------
function redirect($v_Url){
	header("Location: " . $v_Url);
}
#--------------------------------------------------------------------------------
function getAccountName($v_iAccountId){

	global $mysql;

	$sql = 'SELECT account_name FROM account WHERE account_id = ' . $v_iAccountId;
	$oResults = $mysql->query($sql);
	$aAccountDetails = mysqli_fetch_array($oResults, MYSQLI_ASSOC);
	return $aAccountDetails['account_name'];
}
#--------------------------------------------------------------------------------
function displayCurrency($v_iAmount, $v_bShowSymbol = SHOW_SYMBOL, $v_bShowNegatives = HIDE_NEGATIVES, $v_bShowZeroDash = SHOW_ZERO_AS_0){

	if($v_iAmount > -1){

		$fAmount = (float)($v_iAmount / 100);
		$sCurrency = number_format($fAmount, 2);

		if(($v_iAmount == 0) && ($v_bShowZeroDash == SHOW_ZERO_AS_DASH)){
			$sCurrency = '-';
		}

	} elseif($v_bShowNegatives == SHOW_NEGATIVES) {

		$fAmount = (float)($v_iAmount / 100);
		$sCurrency = '<span style="color: red;">' . number_format($fAmount, 2) . '</span>';

	} else {
		return '';
	}

	if(($v_bShowSymbol == SHOW_SYMBOL) && ($sCurrency != '-')){
		return '&pound;' . $sCurrency;
	}

	return $sCurrency;
}
#--------------------------------------------------------------------------------
function displayCurrencyForInput($v_iAmount){

	if($v_iAmount > -1){

		$fAmount = (float)($v_iAmount / 100);
		$sCurrency = number_format($fAmount, 2, '.', '');

	} else {
		return '';
	}

	return $sCurrency;
}
#--------------------------------------------------------------------------------
function displayCreditDebit($v_iCredit, $v_iDebit){

	if($v_iCredit > $v_iDebit){

		$sCreditDebit = '<span style="color: green;">+</span>&nbsp;' . displayCurrency($v_iCredit);

	} elseif($v_iDebit > $v_iCredit) {

		$sCreditDebit = '<span style="color: red;">-</span>&nbsp;' . displayCurrency($v_iDebit);

	} else {

		$sCreditDebit = displayCurrency(0);
	}

	return $sCreditDebit;
}
#--------------------------------------------------------------------------------
function processDate($v_sDateText){
	return DateAndCurrency::stringDateToUnixTime($v_sDateText);
}
#--------------------------------------------------------------------------------
function getMonth($v_sDateText){

	list($iDay, $iMonth, $iYear) = explode('/', $v_sDateText);

	$iDay = (int)$iDay;
	$iMonth = (int)$iMonth;
	$iYear = (int)$iYear;

	return $iMonth;
}
#--------------------------------------------------------------------------------
function getDisplayDate($v_iDate){

	if(isPosInt($v_iDate)){
		return date("j M Y", $v_iDate);
	}

	return '';
}
#--------------------------------------------------------------------------------
function getDisplayDateField($v_iDate){

	if(isPosInt($v_iDate)){
		return date("d/m/Y", $v_iDate);
	}

	return '';
}
#--------------------------------------------------------------------------------
function shading($v_iShadeRow){
	if($v_iShadeRow & 1){
		return 'plane';
	} else {
		return 'shade';
	}
}
#--------------------------------------------------------------------------------
function process_input_amount($v_sAmount){
	if(strpos($v_sAmount, '.') === false){
		$iAmount = (int) $v_sAmount . '00';
	} else {
		$iAmount = (int) str_replace('.', '', $v_sAmount);
	}

	return $iAmount;
}
#--------------------------------------------------------------------------------
function process_statement_amount($v_sAmount){

	$iAmount = 0;

	if(preg_match_all('/[0-9]{1,}/', $v_sAmount, $aAmounts)){
		$iAmount = implode('', $aAmounts[0]);
	}

	return $iAmount;
}
#--------------------------------------------------------------------------------
function process_display_input_amount($v_iAmount){
	if(isPosInt($v_iAmount)){
		$sAmount = substr($v_iAmount, 0, (strlen($v_iAmount) -2)) . '.' . substr($v_iAmount, -2);
	} else {
		$sAmount = '0.00';
	}

	return $sAmount;
}
#--------------------------------------------------------------------------------
function getAccountsList($mysql, $bDisplayAllAcounts = SHOW_ALL_ACCOUNTS, $sDropdownDefault = 'Select an account'){

	$aAccounts = array(-1 => $sDropdownDefault);

	if($bDisplayAllAcounts == SHOW_EXPENSE_AND_INCOME_ACCOUNTS){
		$sWhere = sprintf('WHERE account_type IN(%d, %d)', ACCOUNT_TYPE_EXPENSE, ACCOUNT_TYPE_INCOME);
	} elseif($bDisplayAllAcounts == SHOW_BALANCE_AND_BANK_ACCOUNTS){
		$sWhere = sprintf('WHERE account_type IN(%d, %d)', ACCOUNT_TYPE_BANK, ACCOUNT_TYPE_BALANCE);
	} else {
		$sWhere = '';
	}

	$sql = sprintf('SELECT account_id, CONCAT(at_name, " - ", account_name) AS account_name FROM account JOIN account_types ON at_id = account_type %s ORDER BY account_name', $sWhere);
	$oResults = $mysql->query($sql);
	while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

		$iAccId = $aRow['account_id'];

		$aAccounts[$iAccId] = $aRow['account_name'];
	}

	return $aAccounts;
}
#--------------------------------------------------------------------------------
function getChildAccountIds($v_iParentId){

	global $mysql;

	$aAccountIds = array();

	$sql = 'SELECT account_id FROM account WHERE account_parent_id = ' . $v_iParentId;

	$oResults = $mysql->query($sql);

	while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

		$iAccountId = $aRow['account_id'];

		$aAccountIds[$iAccountId] = $iAccountId;
	}

	if(count($aAccountIds) > 0){

		$sAccountIds = implode(',', $aAccountIds);

		$sql = 'SELECT account_id FROM account WHERE account_parent_id IN (' . $sAccountIds . ')';

		$oResults = $mysql->query($sql);

		while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

			$iAccountId = $aRow['account_id'];

			$aAccountIds[$iAccountId] = $iAccountId;
		}
	}

	return $aAccountIds;
}
#--------------------------------------------------------------------------------
// Gets list of account_id => account_name
function getChildAccountsForDropdown($v_iParentId){

	global $mysql;

	$aAccounts = array();

	$sql = 'SELECT account_id, account_name FROM account WHERE account_parent_id = ' . $v_iParentId;

	$oResults = $mysql->query($sql);

	while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

		$iAccountId = $aRow['account_id'];

		$aAccounts[$iAccountId] = $aRow['account_name'];
	}

	if(count($aAccounts) > 0){

		$sAccountIds = implode(',', $aAccounts);

		$sql = 'SELECT account_id, account_name FROM account WHERE account_parent_id IN (' . $sAccountIds . ')';

		$oResults = $mysql->query($sql);

		while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

			$iAccountId = $aRow['account_id'];

			$aAccounts[$iAccountId] = $aRow['account_name'];
		}
	}

	return $aAccounts;
}
#--------------------------------------------------------------------------------
function getParentAccountId($v_iChild){

	global $mysql;

	$sql = 'SELECT account_parent_id FROM account WHERE account_id = ' .  $v_iChild;

	if($oResults = $mysql->query($sql)){
		$aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC);

		return $aRow['account_parent_id'];
	}

	return $v_iChild;
}
#--------------------------------------------------------------------------------
function processDecimalStringToInt($v_sDecimal){

	// Remove commer first (if there is one)
	$v_sDecimal = str_replace(',', '', $v_sDecimal);

	if(($iPos = strpos($v_sDecimal, '.')) === FALSE){
		$v_sDecimal .= '.00';
	} else {

		$iInLen = strlen($v_sDecimal);

		if(($iInLen - $iPos) < 3){

			$iNoZeros = 3 - ($iInLen - $iPos);

			for($iLoop = 0; $iLoop < $iNoZeros; $iLoop++){
				$v_sDecimal .= '0';
			}
		} elseif(($iInLen - $iPos) > 3){
			die('Error');
		}
	}

	return (int) str_replace('.', '', $v_sDecimal);

}
#--------------------------------------------------------------------------------
function getUnreconciledTransactions($v_iAccountId){

	global $mysql;

	$sql = sprintf('SELECT * FROM transaction WHERE reconciled = %d AND account = %d ORDER BY date', TRANSACTION_UNRECONCILED, $v_iAccountId);

	$aTransactions = array();
	$oResults = $mysql->query($sql);
	while($aTrans = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

		$aTransactions[] = $aTrans;
	}

	return $aTransactions;
}
#--------------------------------------------------------------------------------
function getAccountsForDropdownByName(){
	return Account::getAccountsForDropdownByName();
}
#--------------------------------------------------------------------------------
function getInOutAccountsForDropdown(){

	global $mysql;

	$aAccounts = array(-1 => 'Select an account');
	$sql = sprintf('SELECT account_id, CONCAT(at_name, " - ", account_name) AS account_name FROM account JOIN account_types ON at_id = account_type WHERE at_id IN (%s) ORDER BY account_name', ACCOUNT_TYPE_EXPENSE . ',' . ACCOUNT_TYPE_INCOME);
	$oResults = $mysql->query($sql);
	while($aRow = mysqli_fetch_array($oResults, MYSQLI_ASSOC)){

		$iAccId = $aRow['account_id'];

		$aAccounts[$iAccId] = $aRow['account_name'];
	}

	return $aAccounts;
}
#--------------------------------------------------------------------------------
function saveTransaction($sTransName, $sTransDesc, $iTransDate, $iAccountId, $iCategoryId, $sNewAmountCredit, $sNewAmountDebit, $iTransId = NEW_TRANS_ID){

	global $mysql;

	if(isPosInt($iTransId)){
		// Update
		$sql = sprintf('UPDATE transaction SET name = %s, comment = %s, date = %d, account = %d, category = %d, credit = %d, debit = %d WHERE id = %d', $mysql->sqlString($sTransName), $mysql->sqlString($sTransDesc), $iTransDate, $iAccountId, $iCategoryId, processDecimalStringToInt($sNewAmountCredit), processDecimalStringToInt($sNewAmountDebit), $iTransId);
		$mysql->query($sql);
	} else {
		// Write new transaction
		$sql = sprintf('INSERT INTO transaction SET name = %s, comment = %s, date = %d, account = %d, category = %d, credit = %d, debit = %d', $mysql->sqlString($sTransName), $mysql->sqlString($sTransDesc), $iTransDate, $iAccountId, $iCategoryId, processDecimalStringToInt($sNewAmountCredit), processDecimalStringToInt($sNewAmountDebit));
		$mysql->query($sql);
		$iTransId = lastInsertId($mysql);
	}

	return $iTransId;
}
function dissableTransaction($iTransId){

	global $mysql;

	if(isPosInt($iTransId)){
		$sql = sprintf('UPDATE transaction SET status = 0 WHERE id = %d', $iTransId);
		$mysql->query($sql);
	}
}
#--------------------------------------------------------------------------------
function displayTransaction(){
	include 'transaction_popup.php';
}
#--------------------------------------------------------------------------------
function getPreviousTransactions($v_aCategories, $v_iNoTrans)
{
	global $mysql;

	$aTransactions = array();

	foreach($v_aCategories as $iCatId){

		$sql = sprintf('SELECT %s FROM transaction WHERE account = %d AND category = %d AND status = 1 ORDER BY date desc LIMIT %d', SQL_TRANS_COLS_FULL, BANK_ACCOUNT_COOP, $iCatId, $v_iNoTrans);
		$oTrResults = $mysql->query($sql);

		while($aTranRow = mysqli_fetch_array($oTrResults, MYSQLI_ASSOC)){
			$aTransactions[] = $aTranRow;
		}
	}

	return $aTransactions;
}
#--------------------------------------------------------------------------------
function getAccountTypeId($v_iAccountId){

	global $mysql;

	$sql = 'SELECT account_type FROM account WHERE account_id = ' . $v_iAccountId;
	$oResults = $mysql->query($sql);
	$aTrans = mysqli_fetch_array($oResults, MYSQLI_ASSOC);

	$iAccountType = $aTrans['account_type'];

	return $iAccountType;
}
#--------------------------------------------------------------------------------
function getTransactionSql($v_iAccountId, $v_sTransactionColumns = SQL_TRANS_COLS_FULL, $accountType = -1)
{
	if ($accountType > -1) {
		$iAccountType = $accountType;
	} else {
	$iAccountType = getAccountTypeId($v_iAccountId);
	}

	$sOrdering = '';

	if($v_sTransactionColumns == SQL_TRANS_COLS_FULL){
		$sOrdering = 'ORDER BY date, name';
	}

	if($v_iAccountId == 1) {
		$sOrdering = 'ORDER BY date desc, name';
	}

	switch($iAccountType){

		case ACCOUNT_TYPE_BANK:
		$sql = sprintf('SELECT %s FROM transaction JOIN account ON account_id = category WHERE account = %d AND account_type IN (%d, %d, %d) AND status = 1 %s', $v_sTransactionColumns, $v_iAccountId, ACCOUNT_TYPE_EXPENSE, ACCOUNT_TYPE_INCOME, ACCOUNT_TYPE_SYSTEM, $sOrdering);
		break;

		case ACCOUNT_TYPE_EXPENSE:
		case ACCOUNT_TYPE_INCOME:
		case ACCOUNT_TYPE_SYSTEM:
		$sql = sprintf('SELECT %s FROM transaction WHERE category = %d AND status = 1 %s', $v_sTransactionColumns, $v_iAccountId, $sOrdering);
		break;

		case ACCOUNT_TYPE_BALANCE:
		$sql = sprintf('SELECT %s FROM transaction JOIN account ON account_id = category WHERE account = %d AND status = 1 UNION SELECT %s FROM transaction JOIN account ON account_id = category WHERE account_parent_id = %d AND status = 1 %s', $v_sTransactionColumns, $v_iAccountId, $v_sTransactionColumns, $v_iAccountId, $sOrdering);
		break;

		default:
		$sql = sprintf('SELECT %s FROM transaction %s WHERE status = 1', $v_sTransactionColumns, $sOrdering);
	}

	return $sql;
}
#--------------------------------------------------------------------------------
function calculateNoDays($from, $to) {

	$noSecs = $to - $from;
	$noDays = round($noSecs / (60*60*24), 0);

	return $noDays;
}
#--------------------------------------------------------------------------------
function getLastCreditTransactionForAccount($accountId){

	global $mysql;

	$sql = sprintf('SELECT date, credit FROM transaction WHERE account = %d ORDER BY date DESC limit 1', $accountId);
	$oResults = $mysql->query($sql);
	return mysqli_fetch_array($oResults, MYSQLI_ASSOC);
}
#--------------------------------------------------------------------------------
function getTimeToClearDebtString($accountId, $debt){

	$transaction = getLastCreditTransactionForAccount($accountId);

	$transDate = $transaction['date'];
	$transAmount = $transaction['credit'];

	if ($transAmount < 1) {
		return 'No payments made';
	}

	$iLastPaymentDate = $transDate;

	$payment = $transAmount;

	$monthCount = 0;
	while ($debt > 0) {
		$monthCount++;
		$debt -= $payment;
	}

	$endDate = date('M Y', strtotime("+" . $monthCount . " months", $iLastPaymentDate));

	$years = round(($monthCount / 12), 0);

	return 'Clear by ' . $endDate . ' (' . $years . ' years or ' . $monthCount . ' months)';
}
#--------------------------------------------------------------------------------
function dd($data, $die = FALSE) {
	echo '<pre>' . print_r($data, 1) . '</pre>';
	if ($die) {
		die;
	}
}
function fv($currentValue, $seeking, $data, $die = FALSE) {
	if ($currentValue == $seeking) {
		dd($data, $die);
	}
}
function ddb($data, $die = FALSE) {
    $bData = ($data) ? 'TRUE' : 'FALSE';
    dd($bData, $die);
}