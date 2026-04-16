const modal = document.getElementById("modalContato");
const contatoBtn = document.getElementById("contatoBtn");

contatoBtn.addEventListener("click", function(e) {
  e.preventDefault();
  modal.style.display = "flex";
});

function fecharModal() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};