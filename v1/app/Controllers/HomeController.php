<?php
namespace App\Controllers;

use Core\Controller;
use Core\App;

class HomeController extends Controller {
    public function index() {
        $this->render('home', [
            'message' => 'Welcome to your robust PHP framework!',
            'appName' => App::$config['app']['name'] ?? 'App',
        ]);
    }

    public function myinfo(){
        echo "test url";
    }

    public function about() {
        $this->render('about', [
            'title' => 'About Us',
            'content' => 'This is the about page.'
        ]); 
    }

    // Example: List all users
    public function users() {
        $userModel = new \App\Models\User();
        $users = $userModel->all();
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    // Example: Show user by ID
    public function user($id) {
        $userModel = new \App\Models\User();
        $user = $userModel->find($id);
        header('Content-Type: application/json');
        echo json_encode($user);
    }
} 