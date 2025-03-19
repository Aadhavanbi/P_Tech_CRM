<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\ClientModel;
// use Dompdf\Dompdf;
// use Dompdf\Options;
use TCPDF;

class Invoice extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $invoiceModel = new InvoiceModel(); // Load invoice model
        $clientModel = new ClientModel();   // Load client model

        // Fetch all invoices with client details
        $invoices = $invoiceModel
            ->select('invoices.*, clients.name as client_name, clients.address as client_address, clients.phone as client_phone')
            ->join('clients', 'clients.id = invoices.client_id', 'left')
            ->findAll();

        // Pass data to the view
        return view('admin/invoice/invoice_list', ['invoices' => $invoices]);
    }


    public function preview($id)
    {
        $invoiceModel = new InvoiceModel();
        $clientModel = new ClientModel();
        $invoiceItemsModel = new InvoiceItemModel(); // Load invoice items model

        // Fetch the invoice
        $invoice = $invoiceModel
            ->select('invoices.*, clients.name as client_name, clients.address as client_address, clients.phone as client_phone')
            ->join('clients', 'clients.id = invoices.client_id', 'left')
            ->where('invoices.id', $id)
            ->first();

        if (!$invoice) {
            return redirect()->to('/invoice_list')->with('error', 'Invoice not found');
        }

        // Fetch invoice items
        $invoiceItems = $invoiceItemsModel->where('invoice_id', $id)->findAll();

        $data = [
            'invoice' => $invoice,
            'items' => $invoiceItems
        ];

        return view('admin/invoice/invoice_preview', $data);
    }


    public function add()
    {
        $clientModel = new \App\Models\ClientModel();
        $data['clients'] = $clientModel->findAll(); // Fetch all clients
        return view('admin/invoice/invoice_add', $data);
    }

    public function save()
    {
        $invoiceData = $this->request->getJSON(true); // Get JSON data

        if (!empty($invoiceData)) {
            // Extract invoice-level details
            $client_id = $invoiceData['client_id'];
            $invoiceDate = $invoiceData['invoice_date'];
            $dueDate = $invoiceData['due_date'];
            $subTotal = $invoiceData['sub_total'];
            $discount = $invoiceData['discount'];
            $tax = $invoiceData['tax'];
            $totalAmount = $invoiceData['total_amount'];
            $items = $invoiceData['items']; // List of items

            // Start Transaction
            $this->db->transStart();

            // ✅ Insert invoice and check if successful
            $this->db->table('invoices')->insert([
                'client_id' => $client_id,
                'invoice_date'  => $invoiceDate,
                'due_date'  => $dueDate,
                'subtotal'     => $subTotal,
                'discount'      => $discount,
                'tax'           => $tax,
                'total_amount'  => $totalAmount,
            ]);

            // ✅ Ensure invoice was inserted and ID is available
            $invoiceID = $this->db->insertID();
            if (!$invoiceID) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invoice insertion failed']);
            }

            // ✅ Insert each item only if invoiceID is valid
            foreach ($items as $item) {
                $itemData = [
                    'invoice_id'    => $invoiceID,
                    'item_name'     => $item['item_name'],
                    'quantity'      => $item['item_qty'],
                    'unit_price'    => $item['item_price'],
                    'total_price'   => $item['item_total'],
                    'description'   => $item['item_description'] ?? "", // Handle null description
                ];

                $this->db->table('invoice_items')->insert($itemData);
            }

            // Commit transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Database Error']);
            }

            return $this->response->setJSON(['success' => true, 'invoice_id' => $invoiceID]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid Data']);
    }

    public function edit($id)
    {
        $invoiceModel = new InvoiceModel();
        $clientModel = new ClientModel();
        $invoiceItemsModel = new InvoiceItemModel(); // Load invoice items model

        $invoice = $invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoice_list')->with('error', 'Invoice not found');
        }
        // $data['client'] = $clientModel->find($invoice['client_id']);
        $data['client_list'] = $clientModel->findAll();
        // Fetch invoice items for this invoice
        $invoiceItems = $invoiceItemsModel->where('invoice_id', $id)->findAll();
        $data['invoice'] = $invoice;
        $data['items'] = $invoiceItems;
        // print_r($invoiceItems);die;
        return view('admin/invoice/invoice_edit', $data);
    }



    public function update($id)
    {
        $invoiceData = $this->request->getJSON(true); // Get JSON data

        if (!empty($invoiceData)) {
            // Extract invoice-level details
            $clientId = $invoiceData['client_id'];
            $invoiceDate = $invoiceData['invoice_date'];
            $dueDate = $invoiceData['due_date'];
            $subTotal = $invoiceData['sub_total'];
            $discount = $invoiceData['discount'];
            $tax = $invoiceData['tax'];
            $totalAmount = $invoiceData['total_amount'];
            $items = $invoiceData['items']; // List of items

            // Start Transaction
            $this->db->transStart();

            // ✅ Update the invoice details
            $this->db->table('invoices')->where('id', $id)->update([
                'client_id' => $clientId,
                'invoice_date'  => $invoiceDate,
                'due_date'      => $dueDate,
                'subtotal'     => $subTotal,
                'discount'      => $discount,
                'tax'           => $tax,
                'total_amount'  => $totalAmount,
            ]);

            // ✅ Delete old items (so we can insert new updated items)
            $this->db->table('invoice_items')->where('invoice_id', $id)->delete();

            // ✅ Insert updated items
            foreach ($items as $item) {
                $itemData = [
                    'invoice_id'    => $id,
                    'item_name'     => $item['item_name'],
                    'quantity'      => $item['item_qty'],
                    'unit_price'    => $item['item_price'],
                    'total_price'   => $item['item_total'],
                    'description'   => $item['item_description'] ?? "", // Handle null description
                ];
                $this->db->table('invoice_items')->insert($itemData);
            }

            // Commit transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                return $this->response->setJSON(['success' => false, 'message' => 'Database Error']);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Invoice updated successfully!']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Invalid Data']);
    }



    public function delete($id)
    {
        // Logic to delete invoice
    }



    public function sendInvoice($id)
    {
        $invoiceModel = new InvoiceModel();
        $clientModel = new ClientModel();

        $invoice = $invoiceModel->find($id);
        if (!$invoice) {
            return redirect()->to('/invoice_list')->with('error', 'Invoice not found');
        }

        $client = $clientModel->find($invoice['client_id']);
        if (!$client) {
            return redirect()->to('/invoice_list')->with('error', 'Client not found');
        }

        // Load email library
        $email = \Config\Services::email();
        $email->setTo($client['email']);
        $email->setSubject('Invoice #' . $invoice['id']);
        $email->setMessage("Dear {$client['name']},<br><br>Here is your invoice.<br><br>Thanks!");

        if ($email->send()) {
            // return redirect()->to('/invoice')->with('success', 'Invoice sent successfully!');
        } else {
            // return redirect()->to('/invoice_list')->with('error', 'Failed to send invoice.');
        }
    }


    public function downloadInvoice($id)
    {
        $invoiceModel = new InvoiceModel();
        $clientModel = new ClientModel();
        $invoiceItemsModel = new InvoiceItemModel();

        // Fetch the invoice
        $invoice = $invoiceModel
            ->select('invoices.*, clients.name as client_name, clients.address as client_address, clients.phone as client_phone')
            ->join('clients', 'clients.id = invoices.client_id', 'left')
            ->where('invoices.id', $id)
            ->first();

        if (!$invoice) {
            return redirect()->to('/invoice_list')->with('error', 'Invoice not found');
        }

        // Fetch invoice items
        $invoiceItems = $invoiceItemsModel->where('invoice_id', $id)->findAll();

        // Prepare data for the view
        $data = [
            'invoice' => $invoice,
            'items' => $invoiceItems
        ];

        // Load the invoice view as HTML
        $html = view('admin/invoice/invoice_pdf', $data);
        print_r($html);die;
        // Create new TCPDF instance
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company Name');
        $pdf->SetTitle("Invoice #{$invoice['id']}");
        $pdf->SetSubject("Invoice #{$invoice['id']}");
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        // Convert HTML to PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF (force download)
        $pdf->Output("invoice_{$invoice['id']}.pdf", 'D');
    }
}
