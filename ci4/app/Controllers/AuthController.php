<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login()
    {
        $userModel = new UserModel();

        // Ambil inputan dari form
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cek apakah inputan merupakan admin
        if ($email === 'admin@gmail.com' && $password === 'admin123') {
            // Jika admin, redirect ke halaman utama admin
            return redirect()->to(base_url('admin/home'));
        } else {
            // Jika bukan admin, cek apakah user terdaftar
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                // Jika user terdaftar, redirect ke halaman kirim surat
                return redirect()->to(base_url('user/home'));
            } else {
                // Jika user tidak terdaftar atau password salah, tampilkan pesan error
                return redirect()->back()->withInput()->with('error', 'Email atau password salah');
            }
        }
    }
}
