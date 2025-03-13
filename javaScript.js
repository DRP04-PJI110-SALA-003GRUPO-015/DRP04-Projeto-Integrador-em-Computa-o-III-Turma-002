$(document).ready(function () {
  $('#validationDefault07').select2({
    placeholder: "Escolha...",
    maximumSelectionLength: 1, // Limita a quantidade visível ao abrir
    dropdownAutoWidth: true
  });
});

// Menu Mobile
document.addEventListener('DOMContentLoaded', function () {
  const menuButton = document.createElement('button');
  menuButton.className = 'menu-mobile';
  menuButton.innerHTML = '<span></span><span></span><span></span>';
  document.querySelector('#cabecalho').appendChild(menuButton);

  menuButton.addEventListener('click', function () {
    document.querySelector('#main').classList.toggle('active');
  });
});

// Animações de Scroll
const observerOptions = {
  threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('animate');
    }
  });
}, observerOptions);

document.querySelectorAll('.folder, .servicos a').forEach(el => {
  observer.observe(el);
});

// Validação de Formulários
function validateForm(formId) {
  const form = document.getElementById(formId);
  if (!form) return false;

  const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
  let isValid = true;

  inputs.forEach(input => {
    if (!input.value.trim()) {
      isValid = false;
      input.classList.add('error');
    } else {
      input.classList.remove('error');
    }
  });

  return isValid;
}

// Feedback de Mensagens
function showMessage(message, type = 'success') {
  const messageDiv = document.createElement('div');
  messageDiv.className = `mensagem-${type}`;
  messageDiv.textContent = message;

  document.body.appendChild(messageDiv);

  setTimeout(() => {
    messageDiv.remove();
  }, 3000);
}

// Lazy Loading de Imagens
document.addEventListener('DOMContentLoaded', function () {
  const images = document.querySelectorAll('img[data-src]');

  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        observer.unobserve(img);
      }
    });
  });

  images.forEach(img => imageObserver.observe(img));
});

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Prevenção de Envio Duplo de Formulários
document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', function (e) {
    if (this.submitting) {
      e.preventDefault();
      return;
    }
    this.submitting = true;
    setTimeout(() => {
      this.submitting = false;
    }, 2000);
  });
});
