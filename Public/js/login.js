"use strict"

$(document).ready(function () {
    $('#github-button').on('click', function () {
        OAuth.initialize('3CRfPtsrNfBxq_CS-1QGlqkK69I');
        OAuth.popup('github').then(github => {
            github.me().then(data => {
                window.location.href = "inicio.php";
            });
            github.get('/user').then(data => {
                console.log('self data:', data);
            })
        });
    })
});