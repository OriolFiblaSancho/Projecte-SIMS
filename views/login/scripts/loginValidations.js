document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const FORM = document.getElementById('loginForm') || document.querySelector('FORM');
  const EMAIL = document.getElementById('email');
  const PASSWORD = document.getElementById('password');
  const SUBMIT_BTN = FORM && FORM.querySelector('button[type="submit"]');

  console.log('loginValidations: DOMContentLoaded —', { FORMExists: !!FORM, EMAILExists: !!EMAIL, PASSWORDExists: !!PASSWORD, SUBMITBtnExists: !!SUBMIT_BTN });

  // No touch-checkbox logic needed: we use native :invalid styles to show red border.

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
  if (!EMAIL || !PASSWORD) {
    console.error('loginValidations: required inputs not found — aborting validations', { EMAIL, PASSWORD });
    return;
  }

  ensureErrorEl(EMAIL);
  ensureErrorEl(PASSWORD);


  // Email regex
  function isValidEmail(value) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim());
  }
  function isValidPassword(value) {
    return /(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}/.test(value.trim());
  }

  // Validations
  let emailTouched = false;
  let passwordTouched = false;

  function validateEmail(showErrors = false) {
    const value = EMAIL.value.trim();
    const err = document.getElementById(`${EMAIL.id}-error`);
    if (!value) {
      EMAIL.setAttribute('aria-invalid', 'true');
      return false;
    }
    if (!isValidEmail(value)) {
      err.textContent = 'Invalid email format.';
      EMAIL.setAttribute('aria-invalid', 'true');
      return false;
    }
    err.textContent = '';
    EMAIL.removeAttribute('aria-invalid');
    return true;
  }

  function validatePassword(show = false) {
    const value = PASSWORD.value;
    const err = document.getElementById(`${PASSWORD.id}-error`);
    if (!value) {
      PASSWORD.setAttribute('aria-invalid', 'true');
      return false;
    }
    err.textContent = '';
    PASSWORD.removeAttribute('aria-invalid');
    return true;
  }

  // Enable & disable submit button
  function updateSubmitState() {
    // silent validation (don't show messages) while typing
    const ok = validateEmail(false) && validatePassword(false);
    SUBMIT_BTN.disabled = !ok;
    SUBMIT_BTN.classList.toggle('opacity-50', !ok);
    SUBMIT_BTN.classList.toggle('cursor-not-allowed', !ok);
  }

  function reflectAriaInvalid(inputEl) {
    const hasValue = (inputEl.type === 'password') ? inputEl.value !== '' : inputEl.value.trim() !== '';
    if (!hasValue) {
      inputEl.removeAttribute('aria-invalid');
      return;
    }
    if (!inputEl.checkValidity()) {
      inputEl.setAttribute('aria-invalid', 'true');
    } else {
      inputEl.removeAttribute('aria-invalid');
    }
  }

  EMAIL.addEventListener('input', () => {
    validateEmail();
    updateSubmitState();
  });

  PASSWORD.addEventListener('input', () => {
    validatePassword();
    updateSubmitState();
  });

  // Añadir feedback en blur como en register
  [EMAIL, PASSWORD].forEach(inp => {
    inp.addEventListener('blur', () => {
      reflectAriaInvalid(inp);
    });
  });

  // Añadir soporte para enviar el formulario con la tecla Enter
  [EMAIL, PASSWORD].forEach(inp => {
    inp.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        // actualizar estado del submit por si el usuario ha modificado algo
        updateSubmitState();
        if (!SUBMIT_BTN.disabled) {
          SUBMIT_BTN.click();
        } else {
          // show visible validations and focus the first invalid field
          FORM.classList.add('submitted');
          validateEmail(true);
          validatePassword(true);
          reflectAriaInvalid(EMAIL);
          reflectAriaInvalid(PASSWORD);
          const firstInvalid = FORM.querySelector('[aria-invalid="true"]');
          if (firstInvalid) firstInvalid.focus();
        }
      }
    });
  });

  // Removed unused 'touched' class logic per CodeQL recommendation.

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
  FORM.addEventListener('submit', async (e) => {
    e.preventDefault();

    const emailOk = validateEmail();
    const passOk = validatePassword();

    if (!emailOk || !passOk) {
      const firstInvalid = FORM.querySelector('[aria-invalid="true"]');
      if (firstInvalid) firstInvalid.focus();
      return;
    }

    const originalHTML = SUBMIT_BTN.innerHTML;
    SUBMIT_BTN.disabled = true;
    SUBMIT_BTN.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Entering...';

    try {
      const res = await fetch('/controllers/processLogin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email: EMAIL.value.trim(), password: PASSWORD.value })
      });

      const data = await res.json();
      if (data.success) {
        window.location.href = '/main';
        return;
      }

      // If server returned field errors, show them under each input
      // expected format: { success:false, errors: { email: 'msg', password: 'msg' }, message: '...' }
      if (data.errors && typeof data.errors === 'object') {
        // clear previous server errors
        ['email', 'password'].forEach(field => {
          const input = document.getElementById(field);
          const errEl = document.getElementById(`${field}-error`);
          if (input && errEl) {
            errEl.textContent = '';
            input.classList.remove('border', 'border-red-600');
            input.removeAttribute('aria-invalid');
            input.style.borderColor = '';
            input.style.boxShadow = '';
          }
        });

        let first = null;
        Object.keys(data.errors).forEach(field => {
          const input = document.getElementById(field);
          const errEl = document.getElementById(`${field}-error`);
          if (input && errEl) {
            errEl.textContent = data.errors[field];
            input.classList.add('border', 'border-red-600');
            input.style.borderColor = '#dc2626';
            input.style.boxShadow = '0 0 0 1px rgba(220,38,38,0.25)';
            input.setAttribute('aria-invalid', 'true');
            if (!first) first = input;
          }
        });
        if (first) first.focus();
        SUBMIT_BTN.disabled = false;
        SUBMIT_BTN.innerHTML = originalHTML;
        return;
      }

      // fallback: general error
      let general = document.getElementById('login-general-error');
      if (!general) {
        general = document.createElement('p');
        general.id = 'login-general-error';
        general.className = 'text-red-600 text-sm mt-4';
        general.setAttribute('role', 'alert');
        FORM.appendChild(general);
      }
      general.textContent = data.message || 'Incorrect credentials.';
      SUBMIT_BTN.disabled = false;
      SUBMIT_BTN.innerHTML = originalHTML;
    } catch (err) {
      console.error(err);
      alert('Network error. Please try again later.');
      SUBMIT_BTN.disabled = false;
      SUBMIT_BTN.innerHTML = originalHTML;
    }
  });

  updateSubmitState();
});
