

// variables
let inputPlayer, selectTeam, botonValidate, botonReiniciar, contador, restante,
$players, $objPlayers, $res, $puntos;


// iniciar app
function init () {

    inputPlayer = document.getElementById('game_currentPlayer');
    selectTeam = document.getElementById('game_team');
    botonValidate = document.getElementById('validate_game');
    botonReiniciar = document.getElementById('restart_game');
    contador = document.getElementById('punctuation_counter');
    restante = document.getElementById('rest_players_counter');
    $players = {};
    $objPlayers = {};
    $res = '';
    $puntos = 0;

    declararEventos();

    // Obtener players
    ajax(iniciarJuego, removePlayers);
}


// eventosiniciales
window.addEventListener('load', init);


// funciones
// (solo por motivos del test este bloque está dentro del mismo archivo principal js)

function ajax (callback, callbackError) {

    // let formPost = new FormData();
    let xhr = new XMLHttpRequest();
    // formPost.append('k', 'value');

    function success () {
        let res = this.responseText;
        if ( res.isJsonString() ) {
            let resJson = JSON.parse(res);
            if ( typeof(callback) === 'function' ) callback(resJson);
        } else {
            if ( typeof(callbackError) === 'function' ) callbackError(res);
        }
    }
    xhr.addEventListener('load', success);
    xhr.open('GET', '/game/ajax-random-players');
    xhr.send();
}



Object.defineProperty(String.prototype, 'isJsonString', {
    enumerable: false,
    value: function () {
        try {
            let json = JSON.parse(this);
        } catch (e) {
            return false;
        }

        return true;
    }
});


Object.defineProperty(Object.prototype, 'removeFirst', {
    enumerable: false,
    value: function () {
        let key = '';
        for ( let k in this ) {
            key = k;
            break;
        }

        delete this[key];
    }
});


Object.defineProperty(Object.prototype, 'length', {
    enumerable: false,
    value: function () {
        let n = 0;
        for ( let k in this ) {
            n++;
        }

        return n;
    }
});

function iniciarJuego (resJson) {
    $players = resJson;
    for ( let pl of $players ) $objPlayers[pl.name] = pl.team.id;

    chargeSelect();
}


function reloadSelect () {

    $objPlayers.removeFirst();
    chargeSelect();
}
function chargeSelect () {

    for ( let playerName in $objPlayers ) {
        inputPlayer.value = playerName;
        $res = $objPlayers[playerName];
        break;
    }
    contador.innerHTML = $puntos;
    restante.innerHTML = $objPlayers.length();

    if ( $objPlayers.length() === 0 ) {
        botonValidate.style.display = 'none';
        inputPlayer.value = '...';
        selectTeam.value = '';
        selectTeam.setAttribute('disabled', '');
        contador.setAttribute('style', 'font-size: 30px; padding: 15px; color:#fff; background:#000;');
        botonReiniciar.style.display = 'block';
    }
    else {
        botonValidate.style.display = 'block';
    }
}



function removePlayers (resJson) {
    $players = {};
}

function responder () {

    if ( selectTeam.value == $res ) $puntos++;
    else $puntos--;

    reloadSelect();
}


function declararEventos () {

    botonValidate.addEventListener('click', responder);
}