document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const FORM = document.getElementById('registerForm') || document.querySelector('FORM');
  const NAME = document.getElementById('name');
  const EMAIL = document.getElementById('email');
  const PASSWORD = document.getElementById('password');
  const SUBMIT_BTN = FORM.querySelector('button[type="submit"]');

  console.log('Register validations script loaded.');

  function ensureErrorEl(input) {
    const wrapper = input.closest('.relative') || input.parentElement;
    const id = `${input.id}-error`;
    let el = document.getElementById(id);
    if (!el) {
      el = document.createElement('p');
      el.id = id;
      el.className = 'text-red-600 text-sm mt-1';
      el.setAttribute('role', 'alert');
      el.setAttribute('aria-live', 'assertive');
      wrapper.insertAdjacentElement('afterend', el);
    }

    input.setAttribute('aria-describedby', id);
    return el;
  }


  // Error message containers
  ensureErrorEl(NAME);
  ensureErrorEl(EMAIL);
  ensureErrorEl(PASSWORD);


  // Functions
  function isValidName(value) {
    return /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/.test(value.trim());
  }

  function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
  }
  function isValidPassword(value) {
    return /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}/.test(value.trim());
  }


  function validateName() {
    const value = NAME.value.trim()
    const err = document.getElementById(`${NAME.id}-error`);
    if (!value) {
  NAME.setAttribute('aria-invalid', 'true');
  NAME.classList.add('border', 'border-red-600');
  NAME.style.borderColor = '#dc2626';
  NAME.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
  err.textContent = 'Name is required.';
      return false;
    }
    if (!isValidName(value)) {
      err.textContent = 'Invalid name format. Use letters and spaces only.';
  NAME.setAttribute('aria-invalid', 'true');
  NAME.classList.add('border', 'border-red-600');
  NAME.style.borderColor = '#dc2626';
  NAME.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
      return false;
    }
    err.textContent = '';
  NAME.removeAttribute('aria-invalid');
  NAME.classList.remove('border', 'border-red-600');
  NAME.style.borderColor = '';
  NAME.style.boxShadow = '';
    return true;
  }


  function validateEmail() {
    const value = EMAIL.value.trim();
    const err = document.getElementById(`${EMAIL.id}-error`);
    if (!value) {
  EMAIL.setAttribute('aria-invalid', 'true');
  EMAIL.classList.add('border', 'border-red-600');
  EMAIL.style.borderColor = '#dc2626';
  EMAIL.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
  err.textContent = 'Email is required.';
      return false;
    }
    if (!isValidEmail(value)) {
  err.textContent = 'Invalid email format.';
  EMAIL.setAttribute('aria-invalid', 'true');
  EMAIL.classList.add('border', 'border-red-600');
  EMAIL.style.borderColor = '#dc2626';
  EMAIL.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
      return false;
    }
    err.textContent = '';
  EMAIL.removeAttribute('aria-invalid');
  EMAIL.classList.remove('border', 'border-red-600');
  EMAIL.style.borderColor = '';
  EMAIL.style.boxShadow = '';
    return true;
  }


  function validatePassword() {
    const value = PASSWORD.value;
    const err = document.getElementById(`${PASSWORD.id}-error`);
    if (!value) {
  PASSWORD.setAttribute('aria-invalid', 'true');
  PASSWORD.classList.add('border', 'border-red-600');
  PASSWORD.style.borderColor = '#dc2626';
  PASSWORD.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
  err.textContent = 'Password is required.';
      return false;
    }
    if (value.length < 8) {
  err.textContent = 'Your password must contain a minimum of 8 characters.';
  PASSWORD.setAttribute('aria-invalid', 'true');
  PASSWORD.classList.add('border', 'border-red-600');
  PASSWORD.style.borderColor = '#dc2626';
  PASSWORD.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
      return false;
    }

    if (!isValidPassword(value)) {
  err.textContent = 'Please choose a strong password with uppercase, lowercase, digits, and special characters.';
  PASSWORD.setAttribute('aria-invalid', 'true');
  PASSWORD.classList.add('border', 'border-red-600');
  PASSWORD.style.borderColor = '#dc2626';
  PASSWORD.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
      return false;
    };
    err.textContent = '';
  PASSWORD.removeAttribute('aria-invalid');
  PASSWORD.classList.remove('border', 'border-red-600');
  PASSWORD.style.borderColor = '';
  PASSWORD.style.boxShadow = '';
    return true;
  }


  // Enable & disable submit button
  function updateSubmitState() {
    const ok = validateName() && validateEmail() && validatePassword();
    SUBMIT_BTN.disabled = !ok;
    SUBMIT_BTN.classList.toggle('opacity-50', !ok);
    SUBMIT_BTN.classList.toggle('cursor-not-allowed', !ok);
  }

  NAME.addEventListener('input', () => {
    validateName();
    updateSubmitState();
  });

  EMAIL.addEventListener('input', () => {
    validateEmail();
    updateSubmitState();
  });

  PASSWORD.addEventListener('input', () => {
    validatePassword();
    updateSubmitState();
  });


  // Show & hide password
  (function addPasswordToggle() {
    const wrapper = PASSWORD.closest('.relative') || PASSWORD.parentElement;
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.setAttribute('aria-label', 'Show password');
    btn.className = 'absolute inset-y-0 right-0 pr-3 flex items-center';
    btn.innerHTML = '<i class="fas fa-eye"></i>';
    wrapper.appendChild(btn);

    btn.addEventListener('click', () => {
      const isPassword = PASSWORD.type === 'password';
      PASSWORD.type = isPassword ? 'text' : 'password';
      btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
      btn.innerHTML = isPassword ? '<i class="fas fa-eye-slash"></i>' : '<i class="fas fa-eye"></i>';
    });
  })();


  // --- Submit handler ---
  FORM.addEventListener('submit', (e) => {
    e.preventDefault();

    const nameOK = validateName();
    const emailOk = validateEmail();
    const passOk = validatePassword();

    if (!nameOK || !emailOk || !passOk) {
      const firstInvalid = FORM.querySelector('[aria-invalid="true"]');
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    // Send data to processRegister.php
    const userData = {
      name: NAME.value.trim(),
      email: EMAIL.value.trim(),
      password: PASSWORD.value,
    };

  fetch('/controllers/processRegister.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(userData)
    })

      .then(res => res.json())
      .then(data => {
        if (data.success) {
          FORM.reset();
          window.location.href = '/views/login/pages/login.html';
          return;
        }

        // If server returned structured field errors, display them under inputs
        // expected format: { success: false, errors: { email: 'msg', name: 'msg', password: 'msg' }, message: '...'}
        if (data.errors && typeof data.errors === 'object') {
          // clear previous server-side errors first
          ['name', 'email', 'password'].forEach(field => {
            const input = document.getElementById(field);
            const errEl = document.getElementById(`${field}-error`);
            if (input && errEl) {
              errEl.textContent = '';
              input.classList.remove('border', 'border-red-600');
              input.removeAttribute('aria-invalid');
            }
          });

          let first = null;
          Object.keys(data.errors).forEach(field => {
            const input = document.getElementById(field);
            const errEl = document.getElementById(`${field}-error`);
            if (input && errEl) {
              errEl.textContent = data.errors[field];
              input.classList.add('border', 'border-red-600');
              input.setAttribute('aria-invalid', 'true');
              if (!first) first = input;
            }
          });
          if (first) first.focus();
          return;
        }

        // Fallback alert for non-structured errors
        alert(data.message || 'Error connecting with Database');
      })
      .catch(() => {
        alert('Network error. Try again.');
      });

    updateSubmitState();
  });
})