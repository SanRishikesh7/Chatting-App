let passF = document.getElementById("pass"),
icon = document.getElementById("eye");
icon.onclick = () => {
    if (passF.type === "password") {
        passF.type = "text";
        icon.classList.add("active");
    } else {
        passF.type = "password";
        icon.classList.remove("active");
    }
}