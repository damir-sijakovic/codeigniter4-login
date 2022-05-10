<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator as v;


class UsersController extends BaseController
{
    public function index()
    {
        //
    }
    
    
    public function login()    
    {
        $session = session();
        if ($session->has('loginId'))
        {
            return redirect()->to('/dashboard');
        }

        return view("login");
    }

    public function loginPost()
    {    
        header('Content-type:application/json;charset=utf-8');

        $session = session();

        $email = $this->request->getVar("login-form-email");
        $password = $this->request->getVar("login-form-password"); 

        if (!v::email()->validate($email))
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Bad email format!',
                'data' => null,
            ]);        
            die();
        }

        if (!v::alnum()->noWhitespace()->length(8, 40)->validate($password))
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Password must be alphanumeric 8-40 chars!',
                'data' => null,
            ]);        
            die();
        }

        $usersModel = new UsersModel();
        $emailExists = $usersModel->getWhere(["email" => $email]);
        $emailExistsResult = $emailExists->getResult();

        if (!$emailExistsResult)
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'User email not found!',
                'data' => null,
            ]);        
            die();
        }


        $passHash = $emailExistsResult[0]->password;
        $uuid = $emailExistsResult[0]->uuid;
        if (!password_verify($password, $passHash))
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Bad login password!',
                'data' => null,
            ]);        
            die();
        }
        else
        {
            $session->set('loginId', $uuid);

            echo json_encode([
                'error' => false,
                'message' => 'User login valid!',
                'data' => $uuid,
            ]);        
            die();
        }
    
        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Fail, internal server error.',
            'data' => null,
        ]);        
        die();

    }

    public function register()
    {
        $session = session();
        if ($session->has('loginId'))
        {
            return redirect()->to('/dashboard');
        }

        return view("register");
    }


    public function registerPost()
    {
        header('Content-type:application/json;charset=utf-8');


        $session = session();

        $email = $this->request->getVar("register-form-email");
        $password = $this->request->getVar("register-form-password"); 
        $uuid = Uuid::uuid4();

        if (!v::email()->validate($email))
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Bad email format!',
                'data' => null,
            ]);        
            die();
        }

        if (!v::alnum()->noWhitespace()->length(8, 40)->validate($password))
        {
            http_response_code(500);
            echo json_encode([                
                'error' => true,
                'message' => 'Password must be alphanumeric 8-40 chars!',
                'data' => null,
            ]);        
            die();
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT, ['cost'=>12]);

        $usersModel = new UsersModel();
        $emailExists = $usersModel->getWhere(["email" => $email]);
        $emailExistsResult = $emailExists->getResult();



        if ($emailExistsResult)
        {
            http_response_code(500);
            echo json_encode([
                'error' => true,
                'message' => 'Email already exists!',
                'data' => null,
            ]);        
            die();
        }

        $insertUserId = $usersModel->insert([
            'email' => $email,
            'password' => $passwordHash,
            'uuid' => $uuid,
        ]);

        if ($insertUserId > 0)
        {
            echo json_encode([
                'error' => false,
                'message' => 'User added.',
                'data' => $uuid,
            ]);        
            die();
        }

        http_response_code(500);
        echo json_encode([
            'error' => true,
            'message' => 'Fail, internal server error.',
            'data' => null,
        ]);        
        die();
    }
    

    public function dashboard()
    {
        return view("dashboard");
    }
    
    
    public function logout()
    {
        $session = session();
        $session->remove('loginId');
        return view('logout');    
    }
    
    
    
}
