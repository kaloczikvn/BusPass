(function( $ ) {
    'use strict';

$(document).ready(function() {
    var mrk, mapzoom, circle, realtime;

    var userIcon = L.icon({
      iconUrl: './img/person@2x.png',
      iconSize: [60,66],
      iconAnchor: [30, 66],
    });
    
    var def_1 = 47.690544;
    var def_2 = 17.638385;

    var mymap = L.map('map', {
      'center': [def_1, def_2],
      'zoom': 15,
      'zoomControl': false,
      'layers': [
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        	attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
        	subdomains: 'abcd',
        	maxZoom: 19
        })
      ]
    });

    var markerLayer = L.layerGroup();

    var busline = null;
    if( Cookies.get('busline') ) {
      busline = Cookies.get('busline');
      $('.bus-select[data-id="' + busline + '"]').addClass('selected');
      setRealtime(busline);
    }

    window.setMap = function(lat, lon, zoom = null) {
        mapzoom = 14;
        if(zoom != null) {
          mapzoom = zoom;
        }
        mymap.setView([lat, lon], mapzoom);
    };

    navigator.geolocation.getCurrentPosition(function(location) {
      var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
      var marker = L.marker(latlng, {icon: userIcon}).addTo(mymap);
      window.setMap(location.coords.latitude, location.coords.longitude);
    });

    $('.bus-select').on('click', function(e) {
      e.preventDefault();
      $('.bus-select').removeClass('selected');
      $(this).addClass('selected');
      setRealtime($(this).data('id'));
      $('.bus-selector').toggleClass('active');
      $('#bus_menu_div').toggleClass('hidden');
    });

    $('.bus-selector').on('click', function(e) {
      e.preventDefault();
      $(this).toggleClass('active');
      $('#bus_menu_div').toggleClass('hidden');
    });


    function setRealtime(bus) {
      if(realtime !== undefined) {
        realtime.stop();
        markerLayer.clearLayers();
      }

      Cookies.set('busline', bus, { expires: 365 });

      realtime = L.realtime(
      {
          url: '/map_get_page.php?bus=' + bus,
          crossOrigin: false,
          type: 'json',
      },
      {
          interval: 1 * 1000,
          getFeatureId: function(featureData){
            return featureData.properties.mmsi;
          },
          pointToLayer: function (feature, latlng) {
            var icon = L.divIcon({
              className: 'map-marker bus-icon-class',
              iconSize: [60,66],
              iconAnchor: [30, 66],
              html: '<div class="bus-icon">' + feature.properties.icon + '</div>'
            });

            return L.marker(latlng, {
                'icon': icon,
            });
          },
      }).addTo(markerLayer);

      realtime.on('update', function(result) {
          if(isEmpty(result.features)) {
            if($('#notification').hasClass('hidden')) {
              $('#notification').removeClass('hidden')
            }
          } else {
            if(!$('#notification').hasClass('hidden')) {
              $('#notification').addClass('hidden');
            }
          }
      });

      mymap.addLayer(markerLayer);
    }

    function isEmpty(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
});

})( jQuery );
