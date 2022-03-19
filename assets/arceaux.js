document.querySelectorAll(".map-velo3m-arceaux").forEach((element, index, array) => {
    let id = element.id;
    let map = L.map(id).setView([43.608921, 3.877788], 10);
    let mapType = element.getAttribute('data-maptype');
    if(mapType === 'cyclosm'){
        L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    }else if(mapType === 'osm'){
        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            maxZoom: 20,
            attribution: '&copy; OpenStreetMap France | &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
    } else {
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            subdomains: 'abcd',
            maxZoom: 19
        }).addTo(map);
    }
    var goldIcon = new L.Icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
      shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
      iconSize: [25, 41],
      iconAnchor: [12, 41],
      popupAnchor: [1, -34],
      shadowSize: [41, 41]
    });

    let markers = L.markerClusterGroup();
    let data = JSON.parse(element.getAttribute('data-markers'));
    for (let i = 0; i < data.length; i++) {
        let params = {}
        if(data[i]['capacity'] > 0){
            params.title = 'Capacité : '+data[i]['capacity'];
        }
        params.icon = goldIcon;
        markers.addLayer(L.marker(new L.LatLng(data[i]['lat'], data[i]['lng']), params));
    }
    map.addLayer(markers);
});
