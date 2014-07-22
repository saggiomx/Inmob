var Map = function () {

    return {
        
        //Map
        initMap: function () {
			var map;
			$(document).ready(function(){
			  map = new GMaps({
				div: '#map',
				lat: 21.844182,
					lng: -102.280666,
				height: '590.9375 px',
				zoom: 13
			  });
			   var marker = map.addMarker({
		            lat: 21.844182,
					lng: -102.280666,
		            title: 'AquaMascotas, Plaza San Marcos.'
		        });
			});
        }

    };
}();