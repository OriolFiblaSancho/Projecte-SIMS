
function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
  const expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
}

function getCookie(name) {
  const nameEQ = name + "=";
  const cookies = document.cookie.split(';');
  
  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].trim(); 
    if (cookie.indexOf(nameEQ) == 0) {
      return cookie.substring(nameEQ.length); 
    }
  }
  return null; 
}

function eraseCookie(name) {
  document.cookie = name + '=; Max-Age=-99999999; path=/;';
}


function hasConsent() {
  return getCookie('cookieConsent') !== null;
}

function showCookieModal() {
  if (hasConsent()) {
    return;
  }

  const overlay = document.createElement('div');
  overlay.id = 'cookieModalOverlay';
  overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 9998; display: flex; justify-content: center; align-items: center;';

  const modal = document.createElement('div');
  modal.id = 'cookieModal';
  modal.style.cssText = 'background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3); z-index: 9999;';

  modal.innerHTML = 
    '<h2 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #333;">🍪 Cookie Usage</h2>' +
    '<p style="color: #666; margin-bottom: 1.5rem; line-height: 1.6;">' +
    'We use cookies to improve your experience on our website. ' +
    'By clicking "Accept", you agree to the use of all cookies. ' +
    'You can check our ' +
    '<a href="/views/pages/cookies.php" style="color: #3b82f6; text-decoration: underline;">Cookie Policy</a> ' +
    'for more information.</p>' +
    '<div style="display: flex; gap: 1rem; flex-wrap: wrap;">' +
    '<button id="acceptCookies" style="flex: 1; min-width: 120px; background-color: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;">Accept</button>' +
    '<button id="rejectCookies" style="flex: 1; min-width: 120px; background-color: #e5e7eb; color: #374151; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;">Reject</button>' +
    '</div>';

  overlay.appendChild(modal);
  document.body.appendChild(overlay);
  document.body.style.overflow = 'hidden'; 

  function closeModal() {
    document.body.style.overflow = ''; 
    overlay.remove(); 
  }

  document.getElementById('acceptCookies').onclick = function() {
    setCookie('cookieConsent', 'yes', 365); 
    closeModal();
  };

  document.getElementById('rejectCookies').onclick = function() {
    setCookie('cookieConsent', 'no', 365); 
    closeModal();
  };
}

document.addEventListener('DOMContentLoaded', showCookieModal);
