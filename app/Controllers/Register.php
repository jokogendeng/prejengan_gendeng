<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Register extends Controller
{
	public function index()
	{
		//include helper form
		helper(['form']);
		$data = [];
		echo view('register', $data);
	}

	public function save()
	{
		//include helper form
		helper(['form', 'url']);
		$avatar = $this->request->getFile('file');
		//set rules validation form
		$rules = [
			'name' 			=> 'required|min_length[3]|max_length[20]',
			'email' 		=> 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.user_email]',
			'password' 		=> 'required|min_length[6]|max_length[200]',
			'confpassword' 	=> 'matches[password]'
		];

		$validated = $this->validate([
            'file' => [
                'uploaded[file]',
                'mime_in[file,image/jpg,image/png,image/jpeg]',
                'max_size[file,4096]'
            ],
        ]);
 
  

		if($this->validate($rules) && $validated){
			$model = new UserModel();
			$avatar = $this->request->getFile('file');
            $avatar->move(WRITEPATH . 'uploads');
			$data = [
				'user_name' 	=> $this->request->getVar('name'),
				'user_email' 	=> $this->request->getVar('email'),
				'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
				'user_image' =>  $avatar->getClientName(),
            	'user_image_type'  => $avatar->getClientMimeType()
			];
			$model->save($data);
			return redirect()->to(base_url('login'));
		}else{
			$data['validation'] = $this->validator;
			echo view('register', $data);
		}
		
	}


}