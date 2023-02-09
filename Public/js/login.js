"use strict"

const urlParams = new URLSearchParams(window.location.search);
const erro = urlParams.get("erro");

$(document).ready(function () {
    if (erro == 1) {
        alert("Erro na autenticação, por favor logue novamente!");
    }

    $('#github-button').on('click', function () {
        OAuth.initialize('3CRfPtsrNfBxq_CS-1QGlqkK69I');
        OAuth.popup('github').then(github => {
            var token = github.access_token
            github.me().then(data => {
                window.location.href = "inicio.php?token=" + token;
            });
            github.get('/user').then(data => {
                console.log('self data:', data);
            })
        });
    })
});