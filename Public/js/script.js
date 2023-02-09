"use strict"

const urlParams = new URLSearchParams(window.location.search);
const token = urlParams.get("token");

$(document).ready(function () {
    fetch('https://api.github.com/user', {
        headers: {
            'Authorization': 'Token ' + token
        }
    })
        .then(response => {
            if (!response.ok) {
                window.location.href = 'index.php?erro=1';
            } else {
                readAll();
            }
        });
});

$('#bt-new').click(function () {
    $('#modalNovoPaciente').find('.modal-title').text('Criar Paciente');
    openModalCreate(true);
});

$('#frmCreate').submit(function (e) {
    sendForm();
    e.preventDefault();
});

function openModalCreate(reset = true) {
    $('#modalNovoPaciente').modal('show');

    if (reset) resetForm();
}

function closeModalCreate(reset = true) {
    $('#modalNovoPaciente').modal('hide');

    if (reset) resetForm();
}

function deletePaciente(id) {
    if (confirm("Deseja realmente remover?")) {
        deleteId(id);
    } else {
        return;
    }
}

function editaPaciente(id) {
    $('#modalNovoPaciente').find('.modal-title').text('Editar Paciente');

    if (id <= 0)
        return;

    readById(id, false);
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
        paciente.Id = data[i].id;
        paciente.Nome = data[i].nome;
        paciente.Cpf = data[i].cpf;

        var linha = {};
        linha.template = document.createElement("template");;
        linha.template.innerHTML = tmplHandle(paciente)
        linha.content = document.importNode(linha.template.content, true);

        tabela.appendChild(linha.content);
    }
}

function sendForm() {
    var obj = {
        id: $('#txtId').val(),
        nome: $('#txtNome').val(),
        cpf: $('#txtCpf').val()
    };

    if (obj.id == 0) {
        create(obj);
    } else {
        update(obj);
    }
}

function resetForm() {
    $('#txtId').val("0");
    $('#txtNome').val("");
    $('#txtCpf').val("");
}

function editModal(data) {
    if (data == null)
        return;

    $('#txtId').val(data.id);
    $('#txtNome').val(data.nome);
    $('#txtCpf').val(data.cpf);

    openModalCreate(false);
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

function create(obj) {
    $.ajax({
        url: "api/paciente/",
        type: "POST",
        data: obj,
        dataType: "json",
        beforeSend: function () {
            $('#btnSubmit').attr("disabled", true);
        },
        success: function (data) {
            if (data.result == "ok") {
                closeModalCreate();
                readAll();
            } else {
                alert("Houve um erro no cadastro");
            }
        },
        error: function (error) {
            alert("Houve um erro no cadastro");
        },
        complete: function () {
            $('#btnSubmit').attr("disabled", false);
        }
    });
}

function readById(id, view) {
    $.ajax({
        url: "api/paciente/" + id,
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (view) {
                createViewModal(data);
            } else {
                editModal(data);
            }
        }
    });
}

function update(obj) {
    $.ajax({
        url: "api/paciente/" + obj.id,
        type: "PUT",
        data: obj,
        dataType: "json",
        beforeSend: function () {
            $('#btnSubmit').attr("disabled", true);
        },
        success: function (data) {
            if (data.result == "ok") {
                closeModalCreate();
                readAll();
            } else {
                alert("Houve um erro ao atualizar");
            }
        },
        error: function (error) {
            alert("Houve um erro ao atualizar");
        },
        complete: function () {
            $('#btnSubmit').attr("disabled", false);
        }
    });
}

function deleteId(id) {
    $.ajax({
        url: "api/paciente/" + id,
        type: "DELETE",
        dataType: "json",
        success: function (data) {
            if (data.result == "ok")
                readAll();
        },
        error: function (error) {
            alert("Houve um erro na deleção");
        }
    });
}