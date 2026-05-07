const dataInput = document.getElementById("data");
const horaI = document.getElementById("hora1");
const horaT = document.getElementById("hora2");
const info = document.getElementById("infoHorarios");
const botao = document.querySelector(".btn");

const grade = document.getElementById("gradeHorarios");
const btnVer = document.getElementById("btnVerHorarios");
const blocoHorarios = document.getElementById("blocoHorarios");

let horarios = [];
let ocupados = [];
let selecionados = [];

flatpickr("#data", {
    dateFormat: "Y-m-d",
    minDate: "today",
});

for (let h = 8; h <= 22; h++) {
    horarios.push((h < 10 ? "0" : "") + h + ":00");
}

dataInput.addEventListener("change", () => {
    btnVer.style.display = "block";

    blocoHorarios.classList.remove("ativo");

    limparSelecao();
});

btnVer.addEventListener("click", () => {
    let data = dataInput.value;

    if (!data) {
        info.innerHTML = "Selecione uma data primeiro";
        return;
    }

    fetch(`../php/buscar_horarios.php?data=${data}`)
    .then(res => res.json())
    .then(dados => {
        ocupados = dados;

        blocoHorarios.classList.add("ativo");

        renderizar();
    })
    .catch(() => {
        info.innerHTML = "Erro ao carregar horários";
    });
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

        let inicio = selecionados[0];
        let fim = hora;

        if (inicio > fim) [inicio, fim] = [fim, inicio];

        let conflito = horarios.some(h => {
            return h >= inicio && h <= fim && ocupados.includes(h);
        });

        if (conflito) {
            info.innerHTML = `<div class="status erro">❌ Intervalo contém horário ocupado</div>`;
            limparSelecao();
            return;
        }

        selecionados.push(hora);

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
            info.innerHTML = `<div class="status erro">❌ Horário indisponível</div>`;
            botao.disabled = true;
        } else {
            info.innerHTML = `<div class="status sucesso">✅ Horário disponível</div>`;
            botao.disabled = false;
}
    });
}


const form = document.querySelector("form");

form.addEventListener("submit", () => {
  sessionStorage.setItem("reservaFeita", "true");
});