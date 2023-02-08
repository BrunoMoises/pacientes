"use strict"

$(document).ready(function () {
    readAll();
});

function deletePaciente(id) {
    
}

function editaPaciente(id) {

}

function createTable(data) {
    if (data.length < 1)
        return;

    var tabela = document.querySelector(".table tbody");
    tabela.innerHTML = "";

    var tmplSource = document.getElementById("tmplLinha").innerHTML;
    var tmplHandle = Handlebars.compile(tmplSource);

    for (var i = 0; i < data.length; i++) {
        var paciente = {};
        paciente.Id= data[i].id;
        paciente.Nome = data[i].nome;
        paciente.Cpf = data[i].cpf;

        var linha = {};
        linha.template = document.createElement("template");;
        linha.template.innerHTML = tmplHandle(paciente)
        linha.content = document.importNode(linha.template.content, true);

        tabela.appendChild(linha.content);
    }
}

function readAll() {
    $.ajax({
        url: "api/paciente",
        type: "GET",
        data: {},
        dataType: "json",
        success: function (data) {
            createTable(data);
        },
        error: function (error) {
            alert("Houve um erro na busca");
        }
    });
}