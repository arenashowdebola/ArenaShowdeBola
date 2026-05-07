const selectPagamento = document.getElementById("pagamento");
const pagamentoDiv = document.getElementById("pagamentoInfo");
const comprovanteDiv = document.getElementById("comprovanteDiv");

let timerInterval;

selectPagamento.addEventListener("change", function () {

    let tipo = this.value;
    let valor = 100;
    let valorFormatado = valor.toFixed(2).replace(".", ",");

    clearInterval(timerInterval);
    comprovanteDiv.style.display = "none";

    if (tipo === "pix") {

        pagamentoDiv.innerHTML = `
        <div style="margin-top:10px;">
            <p><strong>💳 Pagamento via PIX</strong></p>
            <p>Valor: R$ ${valorFormatado}</p>
            <img src="../imgs/qrcode_localhost.png" width="180">
            <p id="timerPix">Tempo restante: 05:00</p>
        </div>
        `;

        comprovanteDiv.style.display = "block";

        iniciarTimer(300);

    } else if (tipo === "dinheiro") {

        pagamentoDiv.innerHTML = `
        <div style="margin-top:10px;">
            <p><strong>💵 Pagamento em Dinheiro</strong></p>
            <p>Valor: R$ ${valorFormatado}</p>
            <p style="color: orange;">
            ⚠️ Entregue ao administrador antes do horário.
            </p>
        </div>
        `;

    } else if (tipo === "cartao") {

        pagamentoDiv.innerHTML = `
        <div style="margin-top:10px;">
            <p><strong>💳 Cartão</strong></p>
            <p>Valor: R$ ${valorFormatado}</p>
            <p style="color: orange;">Pagamento presencial.</p>
        </div>
        `;

    } else {
        pagamentoDiv.innerHTML = "";
    }
});

function iniciarTimer(segundos) {
    let tempo = segundos;

    timerInterval = setInterval(() => {
        let min = Math.floor(tempo / 60);
        let sec = tempo % 60;

        sec = sec < 10 ? "0" + sec : sec;

        const timerElemento = document.getElementById("timerPix");

        if (!timerElemento) {
            clearInterval(timerInterval);
            return;
        }

        timerElemento.innerText = `Tempo restante: ${min}:${sec}`;

        tempo--;

        if (tempo < 0) {
            clearInterval(timerInterval);
            timerElemento.innerText = "⛔ Tempo expirado!";
        }

    }, 1000);
}