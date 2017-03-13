function showPopup(id,id2) {
    var popup = document.getElementById(id);
    var fade = document.getElementById(id2);
        popup.style.display = 'block';
        fade.style.display='block';
}

function hidePopup(id,id2) {
    var popup = document.getElementById(id);
    var fade = document.getElementById(id2);
    fade.style.display='none';
    popup.style.display = 'none';
}

function initMap() {
        var uluru = {lat: 19.4311446, lng: -99.1903203};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
}
