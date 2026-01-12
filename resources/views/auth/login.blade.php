@extends('layouts.app')

@section('title','Login')

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        font-family: 'SolaimanLipi', 'Roboto', sans-serif;
    }
    
    .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        animation: slideUp 0.8s ease-out;
        transition: all 0.3s ease;
    }
    
    .login-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .logo-container {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .logo-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }
    
    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }
    
    .logo-container img {
        max-width: 220px;
        height: auto;
        filter: brightness(1.1);
        transition: transform 0.3s ease;
        position: relative;
        z-index: 2;
    }
    
    .logo-container img:hover {
        transform: scale(1.05) rotate(5deg);
    }
    
    .form-container {
        padding: 40px;
    }
    
    .form-title {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
        font-size: 28px;
        font-weight: 600;
        position: relative;
    }
    
    .form-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }
    
    .input-group {
        position: relative;
        margin-bottom: 25px;
    }
    
    .input-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        transition: color 0.3s ease;
        z-index: 2;
    }
    
    .form-control-modern {
        background: rgba(0, 0, 0, 0.05);
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 15px 15px 15px 45px;
        font-size: 16px;
        transition: all 0.3s ease;
        position: relative;
        width: 100%;
    }
    
    .form-control-modern:focus {
        background: rgba(255, 255, 255, 0.9);
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
        outline: none;
    }
    
    .input-group.focused i {
        color: #667eea;
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
        transition: color 0.3s ease;
        z-index: 2;
        left: auto !important;
    }
    
    .password-toggle:hover {
        color: #667eea;
    }
    
    .btn-login {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 15px 30px;
        font-size: 16px;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .btn-login:hover::before {
        left: 100%;
    }
    
    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }
    
    .btn-login:active {
        transform: translateY(-1px);
    }
    
    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    .loading-spinner {
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 10px;
        display: inline-block;
        vertical-align: middle;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .error-message {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.3);
        color: #dc3545;
        padding: 10px 15px;
        border-radius: 8px;
        margin-top: 8px;
        font-size: 14px;
        animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .floating-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: -1;
    }
    
    .floating-element {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .floating-element:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .floating-element:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 10%;
        animation-delay: 2s;
    }
    
    .floating-element:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .pulse-effect {
        animation: pulse 2s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
        100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        pointer-events: none;
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @media (max-width: 768px) {
        .login-card {
            margin: 10px;
            border-radius: 15px;
        }
        
        .form-container {
            padding: 30px 20px;
        }
        
        .form-title {
            font-size: 24px;
        }
        
        .logo-container {
            padding: 20px;
        }
        
        .logo-container img {
            max-width: 100px;
        }
    }
</style>
@endpush

@section('main-content')
<div class="floating-elements">
    <div class="floating-element"></div>
    <div class="floating-element"></div>
    <div class="floating-element"></div>
</div>

<div class="login-container">
    <div class="col-md-8 col-lg-6 col-xl-4">
        <div class="login-card">
            <div class="logo-container">
                <img src="{{ asset('/assets/images/logo.png') }}" alt="Logo" class="logo-img">
            </div>
            
            <div class="form-container">
                <h2 class="form-title">স্বাগতম</h2>
                
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <div class="input-group">
                        <input id="username" 
                               type="text" 
                               class="form-control-modern @error('username') is-invalid @enderror"
                               name="username" 
                               value="{{ old('username') }}" 
                               required 
                               autocomplete="username"
                               autofocus 
                               placeholder="ইউজারনেম">
                        <i class="fas fa-user"></i>
                        @error('username')
                            <div class="error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input id="password" 
                               type="password" 
                               class="form-control-modern @error('password') is-invalid @enderror" 
                               name="password" 
                               required 
                               autocomplete="current-password" 
                               placeholder="পাসওয়ার্ড">
                        <i class="fas fa-lock"></i>
                        <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                        @error('password')
                            <div class="error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-login pulse-effect" type="submit" id="loginBtn">
                            <span class="loading-spinner" id="loadingSpinner" style="display: none;"></span>
                            <span id="loginText">লগইন</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Password toggle functionality
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-toggle');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
    
    // Form submission with loading state
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const loginBtn = document.getElementById('loginBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const loginText = document.getElementById('loginText');
        
        // Show loading state
        loginBtn.disabled = true;
        loadingSpinner.style.display = 'inline-block';
        loginText.textContent = 'লগইন হচ্ছে...';
        loginBtn.classList.remove('pulse-effect');
        
        // Re-enable button after 5 seconds (in case of slow response)
        setTimeout(function() {
            if (loginBtn.disabled) {
                loginBtn.disabled = false;
                loadingSpinner.style.display = 'none';
                loginText.textContent = 'লগইন';
                loginBtn.classList.add('pulse-effect');
            }
        }, 5000);
    });
    
    // Input focus animations
    document.querySelectorAll('.form-control-modern').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Check if input has value on page load
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
    
    // Add shake animation to error messages
    document.querySelectorAll('.error-message').forEach(error => {
        error.style.animation = 'shake 0.5s ease-in-out';
    });
    
    // Keyboard navigation enhancement
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const focusedElement = document.activeElement;
            if (focusedElement.id === 'username') {
                document.getElementById('password').focus();
                e.preventDefault();
            }
        }
    });
    
    // Add typing effect to placeholder
    function typeEffect(element, text, speed = 100) {
        let i = 0;
        const placeholder = element.getAttribute('placeholder');
        element.setAttribute('placeholder', '');
        
        function type() {
            if (i < text.length) {
                element.setAttribute('placeholder', text.substring(0, i + 1));
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }
    
    // Initialize typing effect on load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            
            if (usernameInput && !usernameInput.value) {
                typeEffect(usernameInput, 'ইউজারনেম', 150);
            }
            if (passwordInput && !passwordInput.value) {
                setTimeout(() => {
                    typeEffect(passwordInput, 'পাসওয়ার্ড', 150);
                }, 800);
            }
        }, 1000);
    });
    
    // Add ripple effect to button
    document.querySelector('.btn-login').addEventListener('click', function(e) {
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
</script>
@endpush
@endsection
