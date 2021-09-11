<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $session = session();
        $data['dashboard_data'] = $session->get();
		echo view('dashboard', $data);
    }
}