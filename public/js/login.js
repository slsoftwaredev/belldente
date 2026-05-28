const formLogin = document.getElementById("formLogin");

formLogin.addEventListener("submit", function(e){
    e.preventDefault();
    const formData = new FormData(formLogin);
    fetch("../ajax/login.php",{
        method:"POST",
        body:formData
    })
    .then(response => response.json())
    .then(data => {

        if(data.status){

            window.location.href = "../views/escritorio.php";
        }else{
            alert(data.message);
        }
    })
    .catch(error => {
        console.log(error);
    });
});