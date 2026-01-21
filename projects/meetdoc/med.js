const signup = document.getElementById("signup");
const login = document.getElementById("login");

const contactForm = document.querySelector(".contact");
const inscriptionForm = document.querySelector(".inscription");

signup.addEventListener("click", (e) => {
    e.preventDefault();
    contactForm.style.display = "none";
    inscriptionForm.style.display = "block";
});

login.addEventListener("click", (e) => {
    e.preventDefault();
    contactForm.style.display = "block";
    inscriptionForm.style.display = "none";
});


