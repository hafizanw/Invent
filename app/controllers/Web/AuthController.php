<?php

namespace App\Controllers\Web;

use Phalcon\Mvc\Controller;

class AuthController extends Controller
{
    public function loginAction()
    {
        // Kalau sudah login, tidak perlu lihat form login lagi
        if ($this->authService->check()) {
            return $this->response->redirect('/');
        }

        // Ambil pesan error (kalau ada) dari percobaan login sebelumnya, lalu hapus
        $this->view->error = $this->session->get('login_error');
        $this->session->remove('login_error');

        return $this->view;
    }

    public function doLoginAction()
    {
        $this->view->disable(); // action ini tidak render view, cuma proses lalu redirect

        // getPost() dengan filter 'string' -> sanitization dasar bawaan Phalcon,
        // membersihkan tag HTML/karakter berbahaya dari input.
        $email    = $this->request->getPost('email', 'string');
        $password = $this->request->getPost('password', 'string');

        if (empty($email) || empty($password)) {
            $this->session->set('login_error', 'Email dan password wajib diisi');
            return $this->response->redirect('/login');
        }

        $result = $this->authService->attempt($email, $password);

        if (!$result) {
            $this->session->set('login_error', 'Email atau password salah');
            return $this->response->redirect('/login');
        }

        return $this->response->redirect('/');
    }

    public function logoutAction()
    {
        $this->view->disable();
        $this->authService->logout();

        return $this->response->redirect('/login');
    }
}