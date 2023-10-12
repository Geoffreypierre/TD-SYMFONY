function supprimerFeedy(event) {
    let button = event.target;
    let feedy = button.closest(".feedy");
    let data_publication_id = button.dataset.publicationId;
    let xhr = new XMLHttpRequest();

//La méthode utilisée (GET, POST, PUT, PATCH ou DELETE), l'URL et si la requête est asynchrone ou non.
    xhr.open('DELETE', Routing.generate('deletePublication', {"id": data_publication_id}));
    xhr.onload = function () {
        if(xhr.status === 204) {
            //Fonction déclenchée quand on reçoit la réponse du serveur.
            feedy.remove();
            //xhr.status permet d'accèder au code de réponse HTTP (200, 404, etc...)
        }
    };
//On éxécute la requête. on précise null s'il n'y a pas de données supplémentaires (payload) à envoyer.
    xhr.send();
}

let buttons = document.getElementsByClassName("delete-feedy");
Array.from(buttons).forEach(function (button) {
    button.addEventListener("click", supprimerFeedy);
});