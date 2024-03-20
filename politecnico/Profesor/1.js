var btnMostrarFormulario = document.getElementById("btnMostrarFormulario");
var modalContainer = document.getElementById("modalContainer");
var closeModal = document.getElementById("closeModal");

btnMostrarFormulario.addEventListener("click", function() {
  modalContainer.style.display = "block";
});

closeModal.addEventListener("click", function() {
  modalContainer.style.display = "none";
});