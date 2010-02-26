<?php
/**
 * RecordAdminCreateForm extension - An extension to enable the creation of any RA record from any page.
 * See http://www.organicdesign.co.nz/Extension:RecordAdminCreateForm for installation and usage details
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author [http://www.organicdesign.co.nz/wiki/User:Jack User:Jack]
 * @copyright © 2008 [http://www.organicdesign.co.nz/wiki/User:Jack User:Jack]
 * @licence GNU General Public Licence 2.0 or later
 */
if ( !defined( 'MEDIAWIKI' ) )           die( 'Not an entry point.' );
if ( !defined( 'RECORDADMIN_VERSION' ) ) die( 'The RecordAdminCreateForm extension depends on the RecordAdmin extension' );

define( 'RECORDADMINCREATEFORM_VERSION', '1.0.4, 2009-12-30' );

$wgExtensionFunctions[] = 'efSetupRecordAdminCreateForm';

$wgExtensionCredits['parserhook'][] = array(
	'name'        => 'RecordAdminCreateForm',
	'author'      => '[http://www.organicdesign.co.nz/wiki/User:Jack User:Jack]',
	'description' => 'An extension to enable the creation of any RA record from any page. Made with [http://www.organicdesign.co.nz/Template:Extension Template:Extension].',
	'url'         => 'http://www.organicdesign.co.nz/Extension:RecordAdminCreateForm',
	'version'     => RECORDADMINCREATEFORM_VERSION
);

/**
 * Function called from the hook BeforePageDisplay, creates a form which links to a new RA form page with title and type arguments in the url.
 */
function efRecordAdminCreateForm (&$out) {
	global $wgRecordAdminCategory;

	# Make options list from items in records cat
	/*$options = '';
	$dbr = &wfGetDB(DB_SLAVE);
	$cl  = $dbr->tableName( 'categorylinks' );
	$cat = $dbr->addQuotes( $wgRecordAdminCategory );
	$res = $dbr->select( $cl, 'cl_from', "cl_to = $cat", __METHOD__, array( 'ORDER BY' => 'cl_sortkey' ) );
	while ( $row = $dbr->fetchRow( $res ) ) $options .= '<option>' . Title::newFromID( $row[0] )->getText() . '</option>';
	*/
	
	# Get an options list from the article 
	$title    = Title::newFromText('MediaWiki:Od-minform-record-list');
	$article  = new Article($title);
	$options = $article->getContent();

	# Post the form to Special:RecordAdmin
	$action = Title::makeTitle( NS_SPECIAL, 'RecordAdmin' )->getLocalUrl();

	/*# Add a form to the page
	$out->mBodytext .= "
		<form id='RACreateForm' method='POST' action='$action'>
			Create a new <select name='wpType'>$options</select>
			called <input name='wpTitle' class='raCreateInput' />
			<input type='submit' class='raCreateButton' value='Create' />
		</form>";
*/
	$out->mBodytext .= "
<div id='search-create'>
	<table id='search-create-table' cellpadding='0' cellspacing='0'>
		<tr>
			<th>
				<label for='racreateBody'>Create New Record</label>
			</th>
			<td id='p-racreate' class='portlet'>
				<div id='racreateBody' class='pBody'>
					<form id='RACreateForm' method='POST' action='$action'>
						<select name='wpType'>$options</select>
						<input type='submit' class='raCreateButton' style='display:inline' value='Create' />
					</form>
				<div>
			</td>
			<th>
				<label for='searchInput'><?php $this->msg('search') ?></label>
			</th>
			<td id='p-search' class='portlet'
				<div id='searchBody' class='pBody'>
					<form name='searchform' action='/Special:Search' id='searchform'>
						<div>
							<input id='searchInput' name='search' type='text' title='Search EWG.OD [f]' accesskey='f' value='' />
							<input type='submit' name='fulltext' class='searchButton' id='mw-searchButton' value='Go' title='Search the pages for this text' />
							<input type='button' class='searchButton' value='Search' onClick='document.searchform.findthis.value=document.searchform.search.value;findinpage(document.searchform, frametosearch);' />
							<input type='hidden' name='findthis' />
						</div>
					</form>
				</div>
			</td>
		</tr>
	</table>
</div>
";

	return true;
}

/**
 * Setup function
 */
function efSetupRecordAdminCreateForm() {
	global $wgHooks;
	$wgHooks['BeforePageDisplay'][] = 'efRecordAdminCreateForm';
}

