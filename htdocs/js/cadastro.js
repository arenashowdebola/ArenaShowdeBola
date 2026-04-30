const params = new URLSearchParams(window.location.search);

if (params.get("cadastrocliente") === "ok") {
    mostrarNotificacao("Cliente cadastrado com sucesso!", "green");
}

if (params.get("cadastroadmin") === "ok") {
    mostrarNotificacao("Administrador cadastrado com sucesso!", "blue");
}

function mostrarNotificacao(texto, cor) {

    const msg = document.createElement("div");
    msg.innerText = texto;

    msg.style.position = "fixed";
    msg.style.top = "20px";
    msg.style.right = "20px";
    msg.style.background = cor;
    msg.style.color = "white";
    msg.style.padding = "15px 25px";
    msg.style.borderRadius = "8px";
    msg.style.boxShadow = "0px 4px 10px rgba(0,0,0,0.2)";
    msg.style.fontFamily = "Arial";

    document.body.appendChild(msg);

    setTimeout(() => {
        msg.remove();
    }, 3000);
}