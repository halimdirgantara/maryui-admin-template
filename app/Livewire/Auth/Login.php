<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Mary\Traits\Toast;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    use Toast;

    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $password = '';

    /**
     * @var bool
     */
    public $remember = false;

    /**
     * Maximum number of login attempts
     */
    private const MAX_ATTEMPTS = 5;

    /**
     * Lockout duration in minutes
     */
    private const LOCKOUT_MINUTES = 15;

    /**
     * Validation rules
     */
    protected function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', Password::defaults()],
            'remember' => ['boolean'],
        ];
    }

    /**
     * Custom error messages
     */
    protected function messages()
    {
        return [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ];
    }

    /**
     * Handle the login attempt
     */
    public function login()
    {
        try {
            // Validate input
            $validatedData = $this->validate();

            // Check rate limiting
            if ($this->checkTooManyAttempts()) {
                $this->error('Too many login attempts. Please try again later.');
                return;
            }

            // Sanitize inputs (although Laravel's validation already handles this)
            $email = filter_var($validatedData['email'], FILTER_SANITIZE_EMAIL);

            // Attempt authentication
            if ($this->attemptLogin($email, $validatedData['password'])) {
                // Clear rate limiting on successful login
                $this->clearLoginAttempts();

                // Regenerate session for security
                session()->regenerate();

                // Log successful login
                Log::info('Successful login', ['email' => $email, 'ip' => request()->ip()]);

                return redirect()->intended('dashboard');
            }

            // Handle failed login
            $this->handleFailedLogin($email);
        } catch (\Exception $e) {
            Log::error('Login error', [
                'message' => $e->getMessage(),
                'ip' => request()->ip()
            ]);
            $this->error('An unexpected error occurred. Please try again.');
        }
    }

    /**
     * Attempt to authenticate the user
     */
    private function attemptLogin(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ], $this->remember);
    }

    /**
     * Handle failed login attempt
     */
    private function handleFailedLogin(string $email): void
    {
        // Increment the failed login attempts
        RateLimiter::hit($this->throttleKey(), self::LOCKOUT_MINUTES * 60);

        // Get remaining attempts
        $attempts = self::MAX_ATTEMPTS - RateLimiter::attempts($this->throttleKey());

        // Log failed attempt
        Log::warning('Failed login attempt', [
            'email' => $email,
            'ip' => request()->ip(),
            'remaining_attempts' => $attempts
        ]);


        $this->error(
            'Error',
            $attempts > 0
                ? "Invalid credentials. {$attempts} attempts remaining."
                : 'Too many login attempts. Please try again later.'
        );
    }

    /**
     * Get the rate limiting throttle key
     */
    private function throttleKey(): string
    {
        return Str::transliterate(
            Str::lower($this->email) . '|' . request()->ip()
        );
    }

    /**
     * Check if too many attempts have been made
     */
    private function checkTooManyAttempts(): bool
    {
        return RateLimiter::tooManyAttempts(
            $this->throttleKey(),
            self::MAX_ATTEMPTS
        );
    }

    /**
     * Clear the login attempts
     */
    private function clearLoginAttempts(): void
    {
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Reset the form when navigating away
     */
    public function hydrate()
    {
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.auth');
    }
}
