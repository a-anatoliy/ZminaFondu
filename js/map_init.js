// Google Maps Scripts

function initMap() {
    var dluga = {lat:50.406957, lng:30.667034};
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 15,

        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng( dluga ),

        // Disables the default Google Maps UI components
        // disableDefaultUI: true,
        scrollwheel: false,
        draggable: false,
    };

    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var marker = new google.maps.Marker({
        position: dluga,
        animation: google.maps.Animation.DROP,
        title: "Київ, вул. Архітектора Вербицького, 32-А, оф. 316",
        map: map
    });
}
function toggleBounce() {
    if (marker.getAnimation() !== null) {
        marker.setAnimation(null);
    } else {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    }
}
