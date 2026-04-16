const dataInput = document.getElementById("data");
const horaI = document.getElementById("hora1");
const horaT = document.getElementById("hora2");
const info = document.getElementById("infoHorarios");
const botao = document.querySelector(".btn");

const selectPagamento = document.querySelector("select[name='pagamento']");
const pagamentoDiv = document.getElementById("pagamentoInfo");

const grade = document.getElementById("gradeHorarios");
const btnVer = document.getElementById("btnVerHorarios");
const blocoHorarios = document.getElementById("blocoHorarios");

let horarios = [];
let ocupados = [];
let selecionados = [];
let timerInterval;


flatpickr("#data", {
    dateFormat: "Y-m-d",
    minDate: "today",
});


for (let h = 8; h <= 22; h++) {
    horarios.push((h < 10 ? "0" : "") + h + ":00");
}

dataInput.addEventListener("change", () => {
    btnVer.style.display = "block";
    blocoHorarios.style.display = "none";
    limparSelecao();
});


btnVer.addEventListener("click", () => {

    blocoHorarios.style.display = "block";

    ocupados = ["10:00", "11:00"]; // TESTE
    renderizar();

});


function renderizar() {

    grade.innerHTML = "";

    horarios.forEach(h => {

        let div = document.createElement("div");
        div.innerText = h;
        div.classList.add("horario");

        if (ocupados.includes(h)) {
            div.classList.add("ocupado");
        } else {
            div.classList.add("disponivel");
            div.onclick = () => selecionar(div, h);
        }

        grade.appendChild(div);
    });
}

function selecionar(el, hora) {

    if (selecionados.length === 0) {
        selecionados.push(hora);
        el.classList.add("selecionado");

    } else if (selecionados.length === 1) {

        selecionados.push(hora);

        let inicio = selecionados[0];
        let fim = selecionados[1];

        if (inicio > fim) [inicio, fim] = [fim, inicio];

        horaI.value = inicio;
        horaT.value = fim;

        pintar(inicio, fim);
        verificarConflito();

    } else {
        limparSelecao();
        selecionar(el, hora);
    }
}

function pintar(inicio, fim) {
    document.querySelectorAll(".horario").forEach(div => {
        let h = div.innerText;
        if (h >= inicio && h <= fim) {
            div.classList.add("selecionado");
        }
    });
}

function limparSelecao() {
    selecionados = [];
    document.querySelectorAll(".horario").forEach(d => d.classList.remove("selecionado"));
}


function verificarConflito() {

    let data = dataInput.value;
    let inicio = horaI.value;
    let fim = horaT.value;

    fetch(`../php/buscar_horarios.php?data=${data}&horaI=${inicio}&horaT=${fim}`)
    .then(res => res.json())
    .then(d => {

        if (d.ocupado) {
            info.innerHTML = "❌ Ocupado";
            botao.disabled = true;
        } else {
            info.innerHTML = "✅ Disponível";
            botao.disabled = false;
        }

    });
}

selectPagamento.addEventListener("change", function () {
let tipo = this.value;

let valor = 100;
let valorFormatado = valor.toFixed(2).replace(".", ",");

clearInterval(timerInterval);

if (tipo === "pix") {

    pagamentoDiv.innerHTML = `
    <div style="margin-top:10px; color:white;">
        <p><strong>💳 Pagamento via PIX</strong></p>
        <p>Valor: R$ ${valorFormatado}</p>

        <img src="../imgs/qrcode_localhost.png" width="180">

        <p id="timerPix">Tempo restante: 05:00</p>
    </div>
    `;

    iniciarTimer(300);

} else if (tipo === "dinheiro") {

    pagamentoDiv.innerHTML = `
    <div style="margin-top:10px; color:white;">
        <p><strong>💵 Pagamento em Dinheiro</strong></p>
        <p>Valor: R$ ${valorFormatado}</p>
        <p style="color: orange;">
        ⚠️ Entregue ao administrador antes do horário.
        </p>
    </div>
    `;

} else if (tipo === "cartao") {

    pagamentoDiv.innerHTML = `
    <div style="margin-top:10px; color:white;">
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