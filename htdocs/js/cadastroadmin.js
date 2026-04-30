window.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("cadastroadmin") === "ok") {
    alert("Admin cadastrado com sucesso! Pronto para efetuar login.");
    history.replaceState(null, "", window.location.pathname);
  }
});
