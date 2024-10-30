<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * CsvGenerator Class
 *
 * @package leadee
 * @since   1.0.0
 */

/**
 * Class CsvGenerator
 */
class LEADEE_CsvGenerator {

	/**
	 * @var LEADEE_ApiHelper API helper object.
	 */
	private $api;

	/**
	 * @var LEADEE_ExcelHelper Excel helper object.
	 */
	private $excelhelper;

	/**
	 * CsvGenerator constructor.
	 */
	public function __construct() {
		$this->api         = new LEADEE_ApiHelper();
		$this->excelhelper = new LEADEE_ExcelHelper();
	}

	/**
	 * Create CSV document.
	 *
	 * @param string $from     From date.
	 * @param string $to       To date.
	 * @param string $timezone Timezone.
	 * @return string Generated CSV string.
	 * @throws Exception Throws exception if something goes wrong.
	 */
	public function create_csv_doc( $from, $to, $timezone ) {
		$filename = sprintf( 'leadee-%s_%s.csv', $from, $to );
		$exporter = new LEADEE_ExportDataCSV( 'string', $filename );
		$result   = $this->api->get_leads_data( $from, $to, array(), $timezone );

		$exporter->initialize();
		$this->excelhelper->add_fiels_to_file( $exporter, $result );
		$exporter->finalize();

		return $exporter->getString();
	}
}
