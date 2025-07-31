
document.addEventListener("DOMContentLoaded", () => {
  const wrapper = document.querySelector('.wrapper');
  const registerLink = document.querySelector('.register-link');
  const loginLink = document.querySelector('.login-link');

  document.querySelector(".register-link").addEventListener("click", () => {
  document.querySelector(".wrapper").classList.add("active");
});

document.querySelector(".login-link").addEventListener("click", () => {
  document.querySelector(".wrapper").classList.remove("active");
});


  if (registerLink && wrapper) {
    registerLink.onclick = () => wrapper.classList.add('active');
  }

  if (loginLink && wrapper) {
    loginLink.onclick = () => wrapper.classList.remove('active');
  }

  const savedLang = localStorage.getItem('lang') || 'th';
  const langSelect = document.getElementById('langSelect');
  if (langSelect) langSelect.value = savedLang;
  switchLang(savedLang);
});

function switchLang(lang) {
  if (!lang) lang = document.getElementById("langSelect")?.value || "en";
  localStorage.setItem('lang', lang);

  if (lang === "th") {
    document.getElementById("login-title").innerText = "เข้าสู่ระบบ";
    document.getElementById("label-email").innerText = "อีเมล";
    document.getElementById("label-password").innerText = "รหัสผ่าน";
    document.getElementById("btn-login").innerText = "เข้าสู่ระบบ";
    document.getElementById("no-account").innerHTML = `ยังไม่มีบัญชี? <a class="register-link">สมัครสมาชิก</a>`;
    document.getElementById("signup-title").innerText = "สมัครสมาชิก";
    document.getElementById("label-username").innerText = "ชื่อผู้ใช้";
    document.getElementById("btn-signup").innerText = "สมัครสมาชิก";
    document.getElementById("have-account").innerHTML = `มีบัญชีอยู่แล้ว? <a class="login-link">เข้าสู่ระบบ</a>`;
  } else {
    document.getElementById("login-title").innerText = "Login";
    document.getElementById("label-email").innerText = "Email";
    document.getElementById("label-password").innerText = "Password";
    document.getElementById("btn-login").innerText = "Login";
    document.getElementById("no-account").innerHTML = `Don't have an account? <a class="register-link">Sign Up</a>`;
    document.getElementById("signup-title").innerText = "Sign Up";
    document.getElementById("label-username").innerText = "Username";
    document.getElementById("btn-signup").innerText = "Sign Up";
    document.getElementById("have-account").innerHTML = `Already have an account? <a class="login-link">Login</a>`;
  }
}

