<?php

namespace Controllers;

use \Core\Controller;
use \Models\User;
use \Models\Company;
use \Models\Sale;
use \Models\Inventory;

class ReportsController extends Controller
{
    private $user;
    private $company;
    private $sale;
    private $inventory;

    public function __construct()
    {
        $this->user = new User();
        $this->user->setLoggedUser();
        $this->company = new Company($this->user->getCompany());
        $this->sale = new Sale();
        $this->inventory = new Inventory();

        if (!$this->user->isLoggedIn()) {
            header('Location: '.BASE_URL.'/login');
            exit;
        }

        if (!$this->user->hasPermission('report_view')) {
            header('Location: '.BASE_URL);
        }
    }

    public function index(): void {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $this->loadView('reports', $data);
    }

    public function sales(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();
        $data['status'] = $this->getStatus();

        $this->loadView('sales-report', $data);
    }

    public function sales_pdf(): void
    {
        $customer_name = $_GET['customer_name'] ?? '';
        $first_period = $_GET['first_period'] ?? '';
        $final_period = $_GET['final_period'] ?? '';
        $status = $_GET['status'] ?? '';
        $order_by = $_GET['order_by'] ?? '';

        $data = [];
        $data['sales_list'] = $this->sale->getFilteredSales(
            $this->user->getCompany(),
            $customer_name,
            $first_period,
            $final_period,
            $status,
            $order_by
        );
        $data['filters'] = $_GET;
        $data['status'] = $this->getStatus();
        $this->loadLibrary('mpdf/mpdf/mpdf');

        ob_start();
        $this->loadView('sales-report-pdf', $data);
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new \mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function inventory(): void
    {
        $data = [];
        $data['company_name'] = $this->company->getName();
        $data['user_email'] = $this->user->getEmail();

        $this->loadView('inventory-report', $data);
    }

    public function inventory_pdf(): void
    {
        $data = [];
        $data['inventory_list'] = $this->inventory->getFilteredInventory($this->user->getCompany());
        $this->loadLibrary('mpdf/mpdf/mpdf');

        ob_start();
        $this->loadView('inventory-report-pdf', $data);
        $html = ob_get_contents();
        ob_end_clean();
        $mpdf = new \mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    private function getStatus(): array
    {
        return [
            '0' => 'Aguardando Pagamento',
            '1' => 'Pago',
            '2' => 'Cancelado'
        ];
    }
}
