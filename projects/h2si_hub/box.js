let search = document.querySelector('.search-box');

document.querySelector('#search-icon').onclick = () =>{
    search.classList.toggle('active');
    person.classList.remove('active');
    navLinks.classList.remove('active');
}

let person = document.querySelector('.user-box');

document.querySelector('#person-icon').onclick = () =>{
    person.classList.toggle('active');
    search.classList.remove('active');
}