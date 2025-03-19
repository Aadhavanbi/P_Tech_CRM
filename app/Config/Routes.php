<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\Admin\Login as AdminLogin;
use App\Controllers\Admin\Dashboard as AdminDashboard;
use App\Controllers\Admin\Invoice as AdminInvoice;
use App\Controllers\Admin\Quote as AdminQuote;
use App\Controllers\Admin\Lead as AdminLead;
use App\Controllers\Admin\Sale as AdminSale;
use App\Controllers\Admin\Employee as AdminEmployee;
use App\Controllers\Admin\Client as AdminClient;

/**
 * @var RouteCollection $routes
 */

/**
 *   Admin Routes Start From Here
 */

$routes->get('/', [AdminLogin::class, 'index']);
$routes->get('dashboard', [AdminDashboard::class, 'index']);


// Invoice Routes 

$routes->get('invoice', [AdminInvoice::class, 'index']);
$routes->get('invoice_preview/(:num)', [AdminInvoice::class, 'preview/$1']);
$routes->get('invoice_add', [AdminInvoice::class, 'add']);
$routes->post('invoice_save', [AdminInvoice::class, 'save']);
$routes->get('invoice_edit/(:num)', [AdminInvoice::class, 'edit/$1']);
$routes->post('invoice_update/(:num)', [AdminInvoice::class, 'update/$1']);
$routes->get('send_invoice/(:num)', [AdminInvoice::class, 'sendInvoice/$1']);
$routes->get('download_invoice/(:num)', [AdminInvoice::class, 'downloadInvoice/$1']);
// $routes->get('invoice_add', [AdminInvoice::class, 'preview']);

// Invoice Routes


// Quote Routes
$routes->get('quote', [AdminQuote::class, 'index']);
$routes->get('quote_preview', [AdminQuote::class, 'preview']);
$routes->get('quote_add', [AdminQuote::class, 'add']);
$routes->get('quote_edit/(:num)', [AdminQuote::class, 'edit/$1']);
// Quote Routes

// Leads Routes
$routes->get('leads', [AdminLead::class, 'index']);
$routes->get('lead_add', [AdminLead::class, 'add']);
$routes->post('lead_save', [AdminLead::class, 'save']);
$routes->get('lead_edit/(:num)', [AdminLead::class, 'edit/$1']);
$routes->post('lead_update/(:num)', [AdminLead::class, 'update/$1']);
$routes->get('lead_delete/(:num)', [AdminLead::class, 'delete/$1']);
$routes->post('lead_update_status', [AdminLead::class, 'update_status']);
$routes->post('lead_update_stage', [AdminLead::class, 'update_stage']);
// Leads Routes

// Sales Routes
$routes->get('sales', [AdminSale::class, 'index']);
$routes->get('sale_add', [AdminSale::class, 'add']);
$routes->get('sale_edit/(:num)', [AdminSale::class, 'edit/$1']);
$routes->post('sale_store', [AdminSale::class, 'store']);
$routes->post('sale_update/(:num)', [AdminSale::class, 'update/$1']);
$routes->get('sale_delete/(:num)', [AdminSale::class, 'delete/$1']);
// Sales Routes

// Employee Routes
$routes->get('employees', [AdminEmployee::class, 'index']);
$routes->get('employee_add', [AdminEmployee::class, 'add']);
$routes->get('employee_edit/(:num)', [AdminEmployee::class, 'edit/$1']);
$routes->post('employee_save', [AdminEmployee::class, 'save']);
$routes->post('employee_update/(:num)', [AdminEmployee::class, 'update/$1']);
$routes->get('employee_delete/(:num)', [AdminEmployee::class, 'delete/$1']);
// Employee Routes

// Client Routes
$routes->get('clients', [AdminClient::class, 'index']); // List clients
$routes->get('client_add', [AdminClient::class, 'add']); // Show add client form
$routes->post('client_save', [AdminClient::class, 'save']); // Save new client
$routes->get('client_edit/(:num)', [AdminClient::class, 'edit/$1']); // Show edit client form
$routes->post('client_update/(:num)', [AdminClient::class, 'update/$1']); // Update client
$routes->delete('client_delete/(:num)', [AdminClient::class, 'delete/$1']);
// Client Routes


/**
 *   Admin Routes End Here
 */
