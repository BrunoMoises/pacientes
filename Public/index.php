<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Pacientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js"></script>
</head>

<body>
    <div class="container">
        <header>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h3>PACIENTES</h3>
                </div>
                <div class="col-md-6 text-end">
                    <button type="button" class="btn btn-outline-info" id="bt-new">Novo paciente</button>
                </div>
        </header>
        <hr class="border-info">
        <div class="row mt-3">
            <table class="table table-striped-columns table-bordered">
                <thead>
                    <tr>
                        <th colspan="3">Codigo</th>
                        <th>Nome</th>
                        <th>CPF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="10"><i class="bi-x-circle-fill icon icon-x pointer" title="Excluir paciente"
                                aria-multiline="Excluir paciente" onclick="deletePaciente()"></i></td>
                        <td width="10"><i class="bi-pencil-fill icon icon-edit pointer" title="Editar paciente"
                                aria-multiline="Editar paciente" onclick="editaPaciente()"></i></td>
                        <td align="center" width="40">1</td>
                        <td>Bruno</td>
                        <td>12345678912</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>