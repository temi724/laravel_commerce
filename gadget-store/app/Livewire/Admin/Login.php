<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportRedirects\Redirector;
use App\Models\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.app')]
class Login extends Component
{
    #[Validate('required|email')]
    public $email = '';

    #[Validate('required|min:6')]
    public $password = '';

    public $remember = false;
    public $loginError = '';
    public $debugMessage = '';

    public function testConnection()
    {
        $this->debugMessage = 'Livewire is working! Time: ' . now()->format('H:i:s');
    }

    public function login()
    {
        // Debug message to confirm method is being called
        $this->debugMessage = 'Login method called at ' . now()->format('H:i:s');

        // Clear any previous errors
        $this->loginError = '';

        // Skip validation temporarily for debugging
        if (empty($this->email) || empty($this->password)) {
            $this->loginError = 'Please fill in both email and password.';
            return;
        }

        $admin = Admin::where('email', $this->email)->first();

        if (!$admin) {
            $this->loginError = 'No admin found with this email address.';
            return;
        }

        if (!$admin->checkPassword($this->password)) {
            $this->loginError = 'Invalid password.';
            return;
        }

        // Set admin session
        Session::put('admin_logged_in', true);
        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);
        Session::put('admin_email', $admin->email);

        // Success message
        $this->debugMessage = 'Login successful! Redirecting...';

        // Force a hard redirect using session flash and JavaScript
        session()->flash('login_success', true);

        // Use JavaScript redirect for immediate effect
        $this->dispatch('redirect-to-dashboard');

        // Also use Livewire redirectTo method which is more reliable
        $this->redirectRoute('admin.dashboard');
    }

    public function mount()
    {
        // If already logged in, redirect to dashboard
        if (Session::get('admin_logged_in')) {
            return $this->redirect('/admin/dashboard');
        }
    }

    public function render()
    {
        return view('livewire.admin.login');
    }
}
