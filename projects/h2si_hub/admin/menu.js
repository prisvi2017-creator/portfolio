let list = document.querySelectorAll(".navigation li");

function activeLink(){
    list.forEach(item=>{
        item.classList.remove("hovered");
    })
    this.classList.add("hovered");
}

list.forEach(item => item.addEventListener("mouseover", activeLink));


let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let menu = document.querySelector(".menu");

toggle.onclick = function () {
    navigation.classList.toggle("active");
    menu.classList.toggle("active");
}