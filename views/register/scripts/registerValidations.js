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

  // No touch-checkbox logic needed: inputs use native :invalid styling to show red border.


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


  function validateName(show = false) {
    const value = NAME.value.trim();
    const err = document.getElementById(`${NAME.id}-error`);
    if (!value) {
      if (show) NAME.setAttribute('aria-invalid', 'true');
      return false;
    }
    if (!isValidName(value)) {
      if (show) {
        err.textContent = 'Invalid name format. Use letters and spaces only.';
        NAME.setAttribute('aria-invalid', 'true');
      }
      return false;
    }
    if (show) {
      err.textContent = '';
      NAME.removeAttribute('aria-invalid');
    }
    return true;
  }


  function validateEmail(show = false) {
    const value = EMAIL.value.trim();
    const err = document.getElementById(`${EMAIL.id}-error`);
    if (!value) {
      if (show) EMAIL.setAttribute('aria-invalid', 'true');
      return false;
    }
    if (!isValidEmail(value)) {
      if (show) {
        err.textContent = 'Invalid email format.';
        EMAIL.setAttribute('aria-invalid', 'true');
      }
      return false;
    }
    if (show) {
      err.textContent = '';
      EMAIL.removeAttribute('aria-invalid');
    }
    return true;
  }


  function validatePassword(show = false) {
    const value = PASSWORD.value;
    const err = document.getElementById(`${PASSWORD.id}-error`);
    if (!value) {
      if (show) PASSWORD.setAttribute('aria-invalid', 'true');
      return false;
    }
    if (value.length < 8) {
      if (show) {
        err.textContent = 'Your password must contain a minimum of 8 characters.';
        PASSWORD.setAttribute('aria-invalid', 'true');
      }
      return false;
    }

    if (!isValidPassword(value)) {
      if (show) {
        err.textContent = 'Please choose a strong password with uppercase, lowercase, digits, and special characters.';
        PASSWORD.setAttribute('aria-invalid', 'true');
      }
      return false;
    }
    if (show) {
      err.textContent = '';
      PASSWORD.removeAttribute('aria-invalid');
    }
    return true;
  }


  // Enable & disable submit button
  function updateSubmitState() {
    const ok = validateName(false) && validateEmail(false) && validatePassword(false);
    SUBMIT_BTN.disabled = !ok;
    SUBMIT_BTN.classList.toggle('opacity-50', !ok);
    SUBMIT_BTN.classList.toggle('cursor-not-allowed', !ok);
  }

  NAME.addEventListener('input', () => {
    // Live border feedback without showing text yet
    const ok = validateName(false);
    if (!ok && NAME.value.trim() !== '') {
      NAME.setAttribute('aria-invalid', 'true');
    } else if (ok) {
      NAME.removeAttribute('aria-invalid');
    }
    updateSubmitState();
  });

  EMAIL.addEventListener('input', () => {
    const ok = validateEmail(false);
    if (!ok && EMAIL.value.trim() !== '') {
      EMAIL.setAttribute('aria-invalid', 'true');
    } else if (ok) {
      EMAIL.removeAttribute('aria-invalid');
    }
    updateSubmitState();
  });

  PASSWORD.addEventListener('input', () => {
    const ok = validatePassword(false);
    if (!ok && PASSWORD.value !== '') {
      PASSWORD.setAttribute('aria-invalid', 'true');
    } else if (ok) {
      PASSWORD.removeAttribute('aria-invalid');
    }
    updateSubmitState();
  });

  // On blur, if field invalid (and not empty) show red border (handled by aria-invalid attribute)
  [NAME, EMAIL, PASSWORD].forEach(inp => {
    inp.addEventListener('blur', () => {
      let ok = true;
      switch (inp) {
        case NAME: ok = validateName(false); break;
        case EMAIL: ok = validateEmail(false); break;
        case PASSWORD: ok = validatePassword(false); break;
      }
      if (!ok && inp.value.trim() !== '') {
        inp.setAttribute('aria-invalid', 'true');
      } else if (ok) {
        inp.removeAttribute('aria-invalid');
      }
    });
  });

  // Añadir soporte para enviar el formulario con la tecla Enter
  [NAME, EMAIL, PASSWORD].forEach(inp => {
    inp.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        // update submit state
        updateSubmitState();
        if (!SUBMIT_BTN.disabled) {
          SUBMIT_BTN.click();
        } else {
          // mostrar validaciones y enfocar primer inválido
          FORM.classList.add('submitted');
          validateName(true);
          validateEmail(true);
          validatePassword(true);
          if (!isValidName(NAME.value)) NAME.setAttribute('aria-invalid', 'true'); else NAME.removeAttribute('aria-invalid');
          if (!isValidEmail(EMAIL.value)) EMAIL.setAttribute('aria-invalid', 'true'); else EMAIL.removeAttribute('aria-invalid');
          if (!isValidPassword(PASSWORD.value)) PASSWORD.setAttribute('aria-invalid', 'true'); else PASSWORD.removeAttribute('aria-invalid');
          const firstInvalid = FORM.querySelector('[aria-invalid="true"]');
          if (firstInvalid) firstInvalid.focus();
        }
      }
    });
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

  // mark form as submitted so CSS shows validation borders even for empty fields
  FORM.classList.add('submitted');

  // run visible validations (show error text and aria-invalid)
  const nameOK = validateName(true);
  const emailOk = validateEmail(true);
  const passOk = validatePassword(true);

    // After submit attempt reflect current validity for borders
    if (!nameOK) NAME.setAttribute('aria-invalid', 'true'); else NAME.removeAttribute('aria-invalid');
    if (!emailOk) EMAIL.setAttribute('aria-invalid', 'true'); else EMAIL.removeAttribute('aria-invalid');
    if (!passOk) PASSWORD.setAttribute('aria-invalid', 'true'); else PASSWORD.removeAttribute('aria-invalid');

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
    .then(async (res) => {
      // Read raw text first so we can show non-JSON output (PHP warnings, HTML, etc.)
      const text = await res.text();
      let data = null;
      if (text) {
        try {
          data = JSON.parse(text);
        } catch (err) {
          // Server did not return valid JSON: show raw text to help debugging
          console.error('Invalid JSON from register endpoint:', text);
          alert('Server returned unexpected response:\n' + text);
          return;
        }
      }

      if (!res.ok) {
        // HTTP error status
        alert((data && data.message) ? data.message : ('Server error: ' + res.status));
        return;
      }

      if (data && data.success) {
        FORM.reset();
        window.location.href = '/views/login/pages/login.html';
      } else {
        alert((data && data.message) ? data.message : 'Error connecting to the server');
      }
    })
    .catch((err) => {
      console.error('Fetch failed:', err);
      alert('Network error. Try again.');
    });

    updateSubmitState();
  });
})