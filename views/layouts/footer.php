<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>

const btnMenu = document.getElementById("btnMenu");
const sidebar = document.getElementById("sidebar");

btnMenu.addEventListener("click", () => {

    sidebar.classList.toggle("-translate-x-full");

});
const btnCatalogos = document.getElementById("btnCatalogos");
const menuCatalogos = document.getElementById("menuCatalogos");

if(btnCatalogos){

    btnCatalogos.addEventListener("click", () => {

        menuCatalogos.classList.toggle("hidden");

    });

}

</script>

</body>
</html>