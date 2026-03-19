const wrapper = document.querySelector(" .wrapper");
const login = document.querySelector(" .form-box-login");
const register = document.querySelector(" .form-box-register");
const login_link = document.querySelector(" .login_link");
const register_link = document.querySelector(" .register_link");
if (wrapper && login && register && login_link && register_link) {
  console.log("yes");
}
login_link.addEventListener("click", () => {
  register.style.display = "none";
  login.style.display = "block";
});
register_link.addEventListener("click", () => {
  login.style.display = "none";
  register.style.display = "block";
});
