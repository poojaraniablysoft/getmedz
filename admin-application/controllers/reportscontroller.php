<?php

class ReportsController extends BackendController {

    protected $responseType = "HTML";
    protected $headers, $data = array();
    protected $filename = "";

	 function __construct($model, $controller, $action) {
        parent::__construct($model, $controller, $action);
	 }
    public function before_filter() {
        parent::before_filter();
        $this->Reports = new Reports();
        $this->filename = $this->_action;
		$this->b_crumb = new Breadcrumb();		
    }

    public function customer_stats($responseType = 'HTML') {

        $repostData = $this->Reports->customerData();

        foreach ($repostData as $key => $value) {

            /*
             * Sale Conversion – Percent of prospects that converteed to customers.
             * Example: Total prospects = 10; Total Customers = 8; Sale Conversion = 80%
             */
            $total_prospects = $value['total_prospects'];
            $total_customers = $value['total_sales'] + $value['total_upsells'];
            $repostData[$key]['sale_conversion'] = round((($total_customers / $total_prospects) * 100), 2) . " %";


            /*
             * Upsell Conversion – Percent of customers that converted on the upsell compared to total sales.
             *  Example: Total Sales = 6; Total Upsells = 3; Upsell Conversion = 50%
             */
            $total_sales = $value['total_sales'];
            $total_upsells = $value['total_upsells'];
            $repostData[$key]['upsell_conversion'] = round((($total_upsells / $total_prospects) * 100), 2) . " %";
        }
        $this->data = $repostData;

        $this->headers = array('Date' => 'date', 'Total Prospects' => 'total_prospects', 'Total Sales' => 'total_sales', 'Total Upsells' => 'total_upsells', 'Sale Conversion' => 'sale_conversion'
            , 'Upsell Conversion' => 'upsell_conversion');

        $this->responseType = $responseType;
		 $this->b_crumb->add("Customer Statitics", Utilities::generateUrl("reports", "customer_stats"));
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->response();
    }

    public function doctor_stats($responseType = "HTML") {


        $post = Syspage::getPostedVar();
        $rangeForm = $this->range_form();
        $startDate = $end_date = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$rangeForm->validate($post)) {
                Message::addErrorMessage($rangeForm->getValidationErrors());
                redirectUser(generateUrl('Reports', 'doctor_stats'));
            }
        } else {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
            $post['start_date'] = DateTime::createFromFormat('Y-m-d', $start_date)->format(CONF_DATE_FORMAT_PHP);
            $post['end_date'] = DateTime::createFromFormat('Y-m-d', $end_date)->format(CONF_DATE_FORMAT_PHP);
        }
        $rangeForm->fill($post);

        $startDate = DateTime::createFromFormat(CONF_DATE_FORMAT_PHP, $post['start_date'])->format('Y-m-d');
        $endDate = DateTime::createFromFormat(CONF_DATE_FORMAT_PHP, $post['end_date'])->format('Y-m-d');

        $data = $this->Reports->doctor_stats($startDate, $endDate);
        $this->set('data', $data);

        $dateRange = $this->getRange($startDate, $endDate);

        $reportData = array();
        foreach ($data as $key => $value) {
            $doctor_id = $value['doctor_id'];
            $replyAt = $value['reply_date'];
            $acceptedAt = $value['orquestion_doctor_accepted_at'];
            $responseTime = $value['response_time'];
            $replyDate = displayDate($value['doctor_reply']);

            if (!isset($reportData[$doctor_id][$replyDate])) {
                $reportData[$doctor_id][$replyDate]['Questions'] = 0;
                $reportData[$doctor_id][$replyDate]['TotalRespnseTime'] = 0;
                $reportData[$doctor_id][$replyDate]['avgRespnseTime'] = 0;
            }

            $reportData[$doctor_id]['name'] = $value['doctor_first_name'];
            $reportData[$doctor_id][$replyDate]['Questions'] = $reportData[$doctor_id][$replyDate]['Questions'] + 1;
            $reportData[$doctor_id][$replyDate]['TotalRespnseTime'] += $responseTime;
            $reportData[$doctor_id][$replyDate]['avgRespnseTime'] = $reportData[$doctor_id][$replyDate]['TotalRespnseTime'] / $reportData[$doctor_id][$replyDate]['Questions'];
        }

        $csvData = array();
        $coloumsData = array();
        foreach ($reportData as $report) {
            $DoctorTotalQuestions = 0;
            $DoctorTotalResponse = 0;
            $name = false;
            $docData = array();
            foreach ($dateRange as $keys => $value) {
                $date = $value->format(CONF_DATE_FORMAT_PHP);

                if (!$name) {
                    $docData[] = $report['name'];
                    $name = true;
                }

                if (isset($report[$date])) {
                    $docData[] = $report[$date]['Questions'] . "/" . number_format($report[$date]['avgRespnseTime'], 2);
                    $DoctorTotalResponse+=$report[$date]['TotalRespnseTime'];
                    $DoctorTotalQuestions+=$report[$date]['Questions'];


                    if (!isset($coloumsData[$date])) {

                        $coloumsData[$date]['Questions'] = 0;
                        $coloumsData[$date]['TotalRespnseTime'] = 0;
                    }

                    $coloumsData[$date]['Questions'] +=$report[$date]['Questions'];
                    $coloumsData[$date]['TotalRespnseTime']+=$report[$date]['TotalRespnseTime'];
                } else {
                    $docData[] = 0;
                }
            }

            $docData[] = $DoctorTotalQuestions . "/" . number_format($DoctorTotalResponse / $DoctorTotalQuestions, 2);

            $csvData[] = $docData;
        }


        //Summ All the records
        $lastRow = array('Total');
        $headers = array('Doctor Name');
        foreach ($dateRange as $keys => $value) {
            $date = $value->format(CONF_DATE_FORMAT_PHP);
            $headers[] = $value->format("M,j");
            if (isset($coloumsData[$date]))
                $lastRow[] = $coloumsData[$date]['Questions'] . "/" . number_format($coloumsData[$date]['TotalRespnseTime'] / $coloumsData[$date]['Questions'], 2);
            else {
                $lastRow[] = 0;
            }
        }


        $csvData[] = $lastRow;
        $headers[] = "Total";
        $this->headers = array_flip($headers);
        $this->data = $csvData;
		$this->b_crumb->add("Doctor Statitics", Utilities::generateUrl("reports", "doctor_stats"));
		$this->set('breadcrumb', $this->b_crumb->output());
        $this->set('rangeForm', $rangeForm);
        $this->responseType = $responseType;

        $this->response();
    }

    public function getRange($start_date, $end_date) {


        $begin = new DateTime($start_date);
        $end = new DateTime($end_date);

        $end = $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        return $daterange = new DatePeriod($begin, $interval, $end);
    }

    public function range_form() {

        $frm = new Form('searchForm', 'searchForm');
        $frm->setAction(generateUrl('reports', $this->_action));
        $frm->setExtra("class='table_form'");
        $frm->setJsErrorDisplay('afterfield');
        $frm->setTableProperties("class='table_form_vertical'");
        $frm->addDateField('Start Date', 'start_date')->requirements()->setRequired(true);
        $fld = $frm->addDateField('End Date', 'end_date');
        $fld->requirements()->setRequired(true);
        $fld->requirements()->setCompareWith('start_date', 'ge', '');
        $fld1 = $frm->addSubmitButton('', 'btn_submit', 'Search', 'btn_submit', 'style="cursor:pointer;"');

        //  $frm->setValidatorJsObjectName('searchValidator');
        // $frm->setOnSubmit('return submitsearch(this, searchValidator);');

        return $frm;
    }

    public function response() {

        switch ($this->responseType) {

            case 'CSV':
                $this->generateCsv($this->headers, $this->data, $this->filename . ".csv");
                break;

            case 'HTML':
            default:
                $this->set('headers', $this->headers);
                $this->set('data', $this->data);

                $this->render();
                break;
        }
    }

    public function generateCsv($header, $data, $filename) {

        download_send_headers($filename);
        die(generateCsv($header, $data));
    }

}
