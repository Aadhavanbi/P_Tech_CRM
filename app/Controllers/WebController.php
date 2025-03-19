<?php

namespace App\Controllers;
use App\Helpers\MailHelper;
use App\Models\ClientModel;
use App\Models\VisaRequestModel;
use App\Models\StatusModel;
use App\Models\CountryModel;
use App\Models\VisaTypeModel;
use App\Models\NotesModel;
use App\Models\WebModel;

use CodeIgniter\API\ResponseTrait;


class WebController extends BaseController
{
    public $session;
    protected $ClientModel;
    protected $VisaRequestModel;
    protected $StatusModel;
    protected $CountryModel;
    protected $VisaTypeModel;
    protected $NotesModel;
    protected $WebModel;


    use ResponseTrait;

    public function __construct()
    {
        $this->session = session();
        $this->ClientModel = new ClientModel();
        $this->VisaRequestModel = new VisaRequestModel();
        $this->StatusModel = new StatusModel();
        $this->CountryModel = new CountryModel();
        $this->VisaTypeModel = new VisaTypeModel();
        $this->NotesModel = new NotesModel();
        $this->WebModel = new WebModel();
    }

   
    public function home()
    {

        $data['countryinfo'] = $this->WebModel->getCountryList();
        $data['categoryinfo'] = $this->WebModel->getCategory();
        echo view('web/home',$data);
        
    }

    public function get_cat(){
        $cid = $this->request->getPost('cid');
        $res = $this->WebModel->get_cat($cid);
        foreach($res as $r){
            $f[] = $r;
        }
        echo json_encode($f);
    }

    public function why_choose_us(){
        
        echo view('web/why_choose_us');
    }

    public function apply_visa(){

        $data['countryinfo'] = $this->WebModel->getCountryList();
        $data['categoryinfo'] = $this->WebModel->getCategory();
        echo view('web/apply_visa',$data);
     
    }

    public function contact(){
        echo view('web/contact');
    }

    public function terms(){
        echo view('web/terms');
    }

    public function privacy(){
        echo view('web/privacy');
    }

    public function track_visa(){
        echo view('web/track_visa');
    }

    public function visa_info(){
        $data['countryinfo'] = $this->WebModel->getCountryList();
        $data['categoryinfo'] = $this->WebModel->getCategory();
      
        $con['vc_country'] = $this->request->getGet('countryID');
        $con['vc_category'] = $this->request->getGet('categoryID');
        $con1['vs_country'] = $this->request->getGet('countryID');
        $con1['vs_category'] = $this->request->getGet('categoryID');
      
        $con2['vf_country'] = $this->request->getGet('countryID');
        $con2['vf_category'] = $this->request->getGet('categoryID');
      
        $catary = array(2=>'Business',20=>'Tourist',4=>'Dependent',23=>'Work');
        $data['catname'] = $catary[$this->request->getGet('categoryID')];
      
        $data['vf_info'] = $this->WebModel->get_files($con2['vf_category'],$con2['vf_country']);
        $data['visa_fee_info'] = $this->WebModel->get_visa_fees($con2['vf_category'],$con2['vf_country']);

      
        $data['catlist'] = $this->WebModel->get_cat($this->request->getGet('countryID'));
        $data['branchname'] = $this->WebModel->get_branch_name($this->request->getGet('branchid'));
      
        $data['vs_type_info'] = $this->WebModel->get_vs_type($this->request->getGet('countryID'));
      
        $data['visainfo'] = $this->WebModel->visa_info($con);
        $data['countrysummary'] = $this->WebModel->country_summary($this->request->getGet('countryID'));

        echo view('web/visa_info',$data);
    }

    public function contact_request(){
        
       
        
        $toemail = getenv('ContactAsAdminMailId');
        $subject = "Request from Contact form";

       
        $data['name'] = $this->request->getPost('name');
        $data['subject'] = $this->request->getPost('subject');
        $data['email'] = $this->request->getPost('email');
        $data['message'] = $this->request->getPost('message');
        
        $html = view('web/email/contact_us',$data);
       
        $MailHelper = new MailHelper();
        $MailHelper->send_contact_mail($data['email'],$subject,$html);
        $MailHelper->send_contact_mail($toemail,$subject,$html);
  
    }

    public function test(){
        
       
        
        $toemail = "gowtham.manavalan.la@gmail.com";
        $subject = "Request from Contact form";

       
        $data['name'] = 'Gowtham';
        $data['subject'] = 'We provide you with best travel solutions for your visa';
        $data['email'] = 'gwm@gmail.com';
        $data['message'] = 'Our team is specially trained and dedicated to help you even from the planning stage of your trip. As a pioneer in this field we have expertise in providing perfect travel solutions';
        
        echo view('web/email/contact_us',$data);
       
  
    }

   



}
