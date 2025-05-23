/* globals jQuery, google, sowb */

window.sowb = window.sowb || {};
sowb.SiteOriginGoogleMapInstances = [];

sowb.SiteOriginGoogleMap = function($) {
	return {
		// So that we can always display something, even if no location or address was entered.
		DEFAULT_LOCATIONS: [
			'Addo Elephant National Park, R335, Addo',
			'Cape Town, Western Cape, South Africa',
			'San Francisco Bay Area, CA, United States',
			'New York, NY, United States',
		],

		hasMapStyles: false,

		/**
		 * Create an image element for the marker icon.
		 *
		 * This function creates an image element for the marker icon.
		 * Google Maps requires marker icons to be valid elements
		 * rather than just URLs. The image element is created with
		 * the provided icon URL and optimized for lazy loading.
		 *
		 * @param {string|bool|undefined} icon - The URL of the marker icon.
		 *
		 * @returns {HTMLImageElement|null} The image element for the marker icon, or null if the icon is undefined.
		 */
		drawMarkerEl: ( icon ) => {
			if ( icon === undefined || icon === false ) {
				return null;
			}

			const imgElement = document.createElement( 'img' );
			imgElement.src = icon;
			imgElement.loading = 'lazy';
			return imgElement;
		},
		showMap: function( element, location, options ) {

			var zoom = Number(options.zoom);

			if ( !zoom ) zoom = 14;

			var breakpointCheck = window.matchMedia( '(max-width: ' + options.breakpoint + 'px)' )
			// Check if the user is viewing the map on mobile
			if ( breakpointCheck.matches ) {
				zoom = options.mobileZoom;
			}

			var userMapTypeId = 'user_map_style';

			var mapOptions = {
				zoom: zoom,
				gestureHandling: options.gestureHandling,
				disableDefaultUI: options.disableUi,
				zoomControl: options.zoomControl,
				panControl: options.panControl,
				center: location,
				mapTypeControlOptions: {
					mapTypeIds: [
						window.google.maps.MapTypeId.ROADMAP,
						window.google.maps.MapTypeId.SATELLITE,
						userMapTypeId
					]
				}
			};

			this.hasMapStyles = options.mapStyles && Object.keys( options.mapStyles ).length > 0;
			if ( ! this.hasMapStyles ) {
				mapOptions.mapId = options.id;
			}

			var map = new window.google.maps.Map( element, mapOptions );

			var userMapOptions = {
				name: options.mapName
			};

			if ( this.hasMapStyles ) {
				var userMapType = new window.google.maps.StyledMapType(
					options.mapStyles,
					userMapOptions
				);

				map.mapTypes.set(
					userMapTypeId,
					userMapType
				);

				map.setMapTypeId( userMapTypeId );
			}

			if ( options.markerAtCenter ) {
				this.centerMarker = this.addMarker(
					location,
					map,
					options.markerIcon,
					options.markersDraggable
				);

				map.centerMarker = this.centerMarker;
			}

			this.linkAutocompleteField(options.autocomplete, options.autocompleteElement, map, options);
			this.showMarkers(options.markerPositions, map, options);
			this.showDirections(options.directions, map, options);

			// Expose maps instance.
			sowb.SiteOriginGoogleMapInstances.push( map );
		},

		linkAutocompleteField: function (autocomplete, autocompleteElement, map, options) {
			if( autocomplete && autocompleteElement ) {

				var updateMapLocation = function ( address ) {
					if ( this.inputAddress !== address ) {
						this.inputAddress = address;
						this.getLocation( this.inputAddress ).done(
							function ( location ) {
								map.setZoom( 15 );
								map.setCenter( location );
								if( this.centerMarker ) {
									this.centerMarker.setPosition( location );
									this.centerMarker.setTitle( this.inputAddress );
								}
							}.bind( this )
						);
					}
				}.bind( this );

				var $autocompleteElement = $( autocompleteElement );
				autocomplete.addListener( 'place_changed', function () {
					var place = autocomplete.getPlace();
					map.setZoom( 15 );
					if ( place.geometry ) {
						map.setCenter( place.geometry.location );
						if( this.centerMarker ) {
							this.centerMarker.setPosition(place.geometry.location);
						}
					}
				}.bind( this ) );

				window.google.maps.event.addListener( autocompleteElement, 'keypress', function( event ) {
					var key = event.keyCode || event.which;
					if ( key === '13' ) {
						event.preventDefault();
					}
				} );

				$autocompleteElement.on( 'focusin', function () {
					if ( !this.resultsObserver ) {
						var autocompleteResultsContainer = document.querySelector( '.pac-container' );
						this.resultsObserver = new MutationObserver( function () {
							var $topResult = $( $( '.pac-item' ).get( 0 ) );
							var queryPartA = $topResult.find( '.pac-item-query' ).text();
							var queryPartB = $topResult.find( 'span' ).not( '[class]' ).text();
							var topQuery = queryPartA + ( queryPartB ? (', ' + queryPartB) : '' );
							if ( topQuery ) {
								updateMapLocation( topQuery );
							}
						} );

						var config = { attributes: true, childList: true, characterData: true };

						this.resultsObserver.observe( autocompleteResultsContainer, config );
					}
				}.bind( this ) );

				var revGeocode = function ( latLng ) {
					this.getGeocoder().geocode( { location: latLng }, function ( results, status ) {
						if ( status === window.google.maps.GeocoderStatus.OK ) {
							if ( results.length > 0 ) {
								var addr = results[ 0 ].formatted_address;
								$autocompleteElement.val( addr );
								if( this.centerMarker ) {
									this.centerMarker.setPosition(latLng);
									this.centerMarker.setTitle(addr);
								}
							}
						}
					}.bind( this ) );
				}.bind( this );

				map.addListener( 'click', function ( event ) {
					revGeocode( event.latLng );
				} );

				this.centerMarker.addListener( 'dragend', function ( event ) {
					revGeocode( event.latLng );
				} );
			}
		},

		/**
		 * Add a marker to the map.
		 *
		 * Creates either an AdvancedMarkerElement, or legacy
		 * Marker based on map styles.
		 *
		 * Advanced markers support Cloud Styles while legacy
		 * markers maintain backwards compatibility with JSON.
		 *
		 * @param {google.maps.LatLng} location - The position for the marker.
		 * @param {google.maps.Map} map - The map instance to add marker to.
		 * @param {Object} icon - Custom icon configuration for the marker.
		 * @param {boolean} draggable - Whether the marker should be draggable.
		 *
		 * @return {google.maps.marker.AdvancedMarkerElement|google.maps.Marker} The created marker
		 */
		addMarker: function( location, map, icon, draggable ) {
			const markerOptions = {
				position: location,
				map: map,
				gmpDraggable: draggable,
				draggable: draggable,
				title: ''
			};

			// Are we adding a legacy marker?
			if ( this.hasMapStyles ) {
				if ( typeof icon === 'string' ) {
					markerOptions.icon = icon;
				}

				return new window.google.maps.Marker( markerOptions );
			}

			markerOptions.content = this.drawMarkerEl( icon );
			return new window.google.maps.marker.AdvancedMarkerElement( markerOptions )
		},

		showMarkers: function(markerPositions, map, options) {
			if ( markerPositions && markerPositions.length ) {
				this.infoWindows = [];
				var markerBatches = [];
				var BATCH_SIZE = 10;
				// Group markers into batches of 10 in attempt to avoid query limits
				for ( var i = 0; i < markerPositions.length; i++ ) {
					var batchIndex = parseInt( i / BATCH_SIZE ); // truncate decimals
					if ( markerBatches.length === batchIndex ) {
						markerBatches[ batchIndex ] = [];
					}
					markerBatches[ batchIndex ][ i % BATCH_SIZE ] = markerPositions[ i ];
				}
				var geocodeMarker = function ( mrkr ) {

					var customIcon = mrkr.customMarkerIcon;
					var markerInfo = mrkr.hasOwnProperty( 'info' ) ? mrkr.info : null;
					var infoMaxWidth = mrkr.hasOwnProperty( 'infoMaxWidth' ) ? mrkr.infoMaxWidth : null;
					return this.getLocation( mrkr.place ).done( function ( location ) {
						const markerIcon = customIcon ? customIcon : options.markerIcon;

						const marker = this.addMarker(
							location,
							map,
							markerIcon,
							options.markersDraggable
						);

						if ( markerInfo ) {
							var infoWindowOptions = { content: markerInfo };

							if ( infoMaxWidth ) {
								infoWindowOptions.maxWidth = infoMaxWidth;
							}

							var infoDisplay = options.markerInfoDisplay;
							infoWindowOptions.disableAutoPan = infoDisplay === 'always';
							var infoWindow = new window.google.maps.InfoWindow( infoWindowOptions );
							this.infoWindows.push( infoWindow );
							var openEvent = infoDisplay;
							if ( infoDisplay === 'always' ) {
								openEvent = 'click';
								infoWindow.open( {
									map: map,
									anchor: marker,
									shouldFocus: false // Avoid jump on load
								} );
							}
							marker.addListener( openEvent, function () {
								infoWindow.open( map, marker );
								if ( infoDisplay !== 'always' && !options.markerInfoMultiple ) {
									this.infoWindows.forEach( function ( iw ) {
										if ( iw !== infoWindow ) {
											iw.close();
										}
									} );
								}
							}.bind( this ) );
							if ( infoDisplay === 'mouseover' ) {
								marker.addListener( 'mouseout', function () {
									setTimeout( function () {
										infoWindow.close();
									}, 100 );
								} );
							}
						}
					}.bind( this ) )
					.fail( function ( errorStatus ) {
						overQuota = errorStatus === window.google.maps.GeocoderStatus.OVER_QUERY_LIMIT;
						console.log( errorStatus );
					} );
				}.bind( this );

				var overQuota = false;
				var geocodeMarkerBatch = function ( markerBatchHead, markerBatchTail ) {
					var doneCount = 0;
					for ( var i = 0; i < markerBatchHead.length; i++ ) {
						// If we're over the quota we want to stop making any more requests.
						if ( overQuota ) {
							break;
						}
						geocodeMarker( markerBatchHead[ i ] ).then(
							function () {
								if ( ++doneCount === markerBatchHead.length && markerBatchTail.length ) {
									geocodeMarkerBatch( markerBatchTail.shift(), markerBatchTail );
								}
							}
						);

					}
				}.bind( this );
				geocodeMarkerBatch( markerBatches.shift(), markerBatches );

			}
		},
		showDirections: function(directions, map) {
			if ( directions ) {
				if ( directions.waypoints && directions.waypoints.length ) {
					directions.waypoints.map(
						function (wypt) {
							wypt.stopover = Boolean(wypt.stopover);
						}
					);
				}

				var directionsRenderer = new window.google.maps.DirectionsRenderer();
				directionsRenderer.setMap(map);

				var directionsService = new window.google.maps.DirectionsService();
				directionsService.route({
						origin: directions.origin,
						destination: directions.destination,
						travelMode: directions.travelMode.toUpperCase(),
						avoidHighways: directions.avoidHighways,
						avoidTolls: directions.avoidTolls,
						waypoints: directions.waypoints,
						optimizeWaypoints: directions.optimizeWaypoints,
					},
					function(result, status) {
						if ( status === window.google.maps.DirectionsStatus.OK ) {
							directionsRenderer.setOptions( { preserveViewport: directions.preserveViewport } );
							directionsRenderer.setDirections(result);
						}
					});
			}
		},
		initMaps: function() {
			// Init any autocomplete fields first.
			var $autoCompleteFields = $( '.sow-google-map-autocomplete' );
			var autoCompleteInit = new $.Deferred();
			if( $autoCompleteFields.length === 0 ) {
				autoCompleteInit.resolve();
			} else {
				$autoCompleteFields.each(function (index, element) {

					if ( typeof window.google.maps.places === 'undefined' ) {
						autoCompleteInit.reject('Sorry, we couldn\'t load the "places" library due to another plugin, so the autocomplete feature is not available.');
						return;
					}

					var autocomplete = new window.google.maps.places.Autocomplete( element );

					var $mapField = $(element).siblings('.sow-google-map-canvas');

					if ($mapField.length > 0) {
						var options = $mapField.data('options');
						options.autocomplete = autocomplete;
						options.autocompleteElement = element;
						this.getLocation(options.address).done(
							function (location) {
								this.showMap($mapField.get(0), location, options);
								$mapField.data('initialized', true);
								autoCompleteInit.resolve();
							}.bind(this)
						).fail(function () {
							$mapField.append('<div><p><strong>' + soWidgetsGoogleMap.geocode.noResults + '</strong></p></div>');
							autoCompleteInit.reject();
						});
					}
				}.bind(this));
			}

			autoCompleteInit.always(function(){
				$('.sow-google-map-canvas').each(function (index, element) {
					var $$ = $(element);

					if( $$.data( 'initialized' ) ) {
						// Already initialized so continue to next element.
						return true;
					}

					var options = $$.data( 'options' );
					var address = options.address;
					// If no address was specified, but we have markers, use the first marker as the map center.
					if(!address) {
						var markers = options.markerPositions;
						if(markers && markers.length) {
							address = markers[0].place;
						}
					}

					this.getLocation( address ).done(
						function ( location ) {
							this.showMap( $$.get( 0 ), location, options );
							$$.data( 'initialized', true );
						}.bind( this )
					).fail( function () {
						$$.append( '<div><p><strong>' + soWidgetsGoogleMap.geocode.noResults + '</strong></p></div>' );
					} );

				}.bind(this));
			}.bind(this))
			.fail(function(error){
				console.log(error);
			} )
			.done( function() {
				$( sowb ).trigger( 'maps_loaded' );
			} );
		},
		getGeocoder: function () {
			if ( !this._geocoder ) {
				this._geocoder = new window.google.maps.Geocoder();
			}
			return this._geocoder;
		},
		getLocation: function ( inputLocation ) {
			var locationPromise = new $.Deferred();
			var location = { address: inputLocation };
			//check if address is actually a valid latlng
			var latLng;

			if ( inputLocation && inputLocation.indexOf( ',' ) > -1 ) {
				// A latlng value should be of the format 'lat,lng' or '(lat,lng)'
				var vals = inputLocation.replace(/[\(\)]/g, '').split( ',' );
				if ( vals && vals.length === 2 ) {
					latLng = new window.google.maps.LatLng( vals[0], vals[1] );
					// Let the API decide if we have a valid latlng
					// This should fail if the input is an address containing a comma
					// e.g. 123 Sesame Street, Middleburg, FL, United States
					if ( !(isNaN( latLng.lat() ) || isNaN( latLng.lng() )) ) {
						location = { location: { lat: latLng.lat(), lng: latLng.lng() } };
					}
				}
			}

			if ( location.hasOwnProperty( 'location' ) ) {
				// We're using entered latlng coordinates directly
				locationPromise.resolve( location.location );
			} else if ( location.hasOwnProperty( 'address' ) ) {

				// Either user entered an address, or fall back to defaults and use the geocoder.
				if ( !location.address ) {
					var rndIndx = parseInt( Math.random() * this.DEFAULT_LOCATIONS.length );
					location.address = this.DEFAULT_LOCATIONS[ rndIndx ];
				}
				var gecodeIteration = 0;
				var onGeocodeResults = function ( results, status ) {
					if ( status === window.google.maps.GeocoderStatus.OK ) {
						locationPromise.resolve( results[ 0 ].geometry.location );
					} else if ( status === window.google.maps.GeocoderStatus.OVER_QUERY_LIMIT ) {
						//We make 3 attempts, otherwise we assume we've reached the quota limit and stop trying.
						if ( ++gecodeIteration < 3 ) {
							setTimeout( function () {
								this.getGeocoder().geocode.call( this, location, onGeocodeResults );
							}.bind( this ), 1000 );
						} else {
							locationPromise.reject( status );
						}
					} else if (
						status === window.google.maps.GeocoderStatus.ZERO_RESULTS ||
						status === window.google.maps.GeocoderStatus.OVER_DAILY_LIMIT
					) {
						locationPromise.reject( status );
					}
				}.bind( this );
				this.getGeocoder().geocode( location, onGeocodeResults );
			}
			return locationPromise;
		},
	};
};

// Called by Google Maps API when it has loaded.
function soGoogleMapInitialize() {
	jQuery( window.sowb ).trigger( 'sow-google-map-loaded' );
}

jQuery( window.sowb ).on( 'sow-google-map-loaded', function() {
	new sowb.SiteOriginGoogleMap(jQuery).initMaps();
} );


jQuery(function ($) {
	sowb.googleMapsData = [];
	sowb.googleMapsData.libraries = [
		'marker',
	];

	/**
	 * Wait for the block editor to be fully loaded and initialize Google Maps.
	 *
	 * This function checks if the block editor and Google Maps are
	 * fully loaded. If they aren't, it checks again after a delay. Once
	 * the block editor is ready and blocks are loaded, it initializes
	 * Google Maps and unsubscribes from further updates.
	 */
	const waitForBlockEditor = () => {
		if (
			typeof window.wp !== 'object' ||
			typeof window.wp.data !== 'object' ||
			typeof window.google.maps === 'undefined'
		) {
			setTimeout( waitForBlockEditor, 250 );
			return;
		}

		const checkForBlocks = wp.data.subscribe(() => {
			const blocks = wp.data.select( 'core/block-editor' ).getBlocks();
			if ( blocks.length === 0 ) {
				return;
			}

			soGoogleMapInitialize();
			checkForBlocks();

			sowb.loadGoogleMapsAPI( true );
		} );
	}

	sowb.setupGoogleMaps = function( e, forceLoad = false ) {
		var $mapCanvas = $( '.sow-google-map-canvas' );
		if ( ! $mapCanvas.length ) {
			return;
		}

		// Account for situation where widget preview is loaded before the location field.
		if ( $( 'body.wp-admin' ).length ) {
			sowb.googleMapsData.libraries.push( 'places' );
		}

		$mapCanvas.each(function(index, element) {
			var $this = $(element);
			if ( $this.data( 'apiInitialized' ) ) {
				return $this;
			}
			var mapOptions = $this.data( 'options' );
			if ( mapOptions) {
				if ( typeof mapOptions.libraries !== 'undefined' && mapOptions.libraries !== null ) {
					sowb.googleMapsData.libraries = sowb.googleMapsData.libraries.concat( mapOptions.libraries );
				}
				if ( ! sowb.googleMapsData.apiKey && mapOptions.apiKey ) {
					sowb.googleMapsData.apiKey = mapOptions.apiKey;
				}
			}
			$this.data( 'apiInitialized', true );
		});

		if ( typeof window.google === 'undefined' ) {
			window.google = {};
		}

		if (
			forceLoad ||
			typeof window.google.maps === 'undefined'
		) {
			// If this is an admin preview, and the API has already been setup,
			// skip any further API checks to confirm it's working and set it up.
			if ( $( 'body.wp-admin' ).length ) {
				if ( ! $( '#sow-google-maps-js' ).length ) {
					sowb.loadGoogleMapsAPI( forceLoad );
				}

				// Is this the Block Editor?
				if ( $( '.editor-styles-wrapper' ).length ) {
					waitForBlockEditor();
					return;
				}

				setTimeout( function() {
					soGoogleMapInitialize();
				}, 250 );
			} else {
				sowb.loadGoogleMapsAPI( forceLoad );
				// Ensure Google Maps is loaded before using it.
				sowb.googleMapsData.timer = setInterval( function () {
					var clearTimer = false;
					// Check if there been an error.
					sowb.googleMapsData.ApiError = true;
					if (
						typeof sowb.googleMapsData.ApiError !== 'undefined' &&
						sowb.googleMapsData.ApiError
					) {
						clearTimer = true;
					}
					if (
						! clearTimer &&
						typeof window.google.maps !== 'undefined'
					) {
						clearTimer = true;
						soGoogleMapInitialize();
					}

					if ( clearTimer ) {
						clearInterval( sowb.googleMapsData.timer );
					}
				}, 250 );
			}
		}
	};

	// Generate Google Maps API URL and add load it.
	sowb.loadGoogleMapsAPI = function( forceLoad = false ) {
		// If there was an error (or this is being forced), remove any previous
		// attempts to load the API.
		if (
			$( '#sow-google-maps-js' ).length &&
			(
				forceLoad ||
				(
					typeof sowb.googleMapsData.ApiError !== 'undefined' &&
					sowb.googleMapsData.ApiError
				)
			)
		) {
			$( '#sow-google-maps-js' ).remove();
		}

		if ( ! sowb.googleMapsData.apiKey ) {
			console.warn( 'SiteOrigin Google Maps: Could not find API key. Google Maps API key is required.' );
		}

		// Try to load even if API key is missing to allow Google Maps API to provide it's own warnings/errors about missing API key.
		let apiUrl = 'https://maps.googleapis.com/maps/api/js?key=' + sowb.googleMapsData.apiKey + '&callback=soGoogleMapInitialize&loading=async';

		if ( sowb.googleMapsData.libraries && sowb.googleMapsData.libraries.length ) {
			apiUrl += '&libraries=' + sowb.googleMapsData.libraries.join( ',' );
		}

		// This allows us to "catch" Google Maps JavaScript API errors and do a bit of custom handling. In this case,
		// we display a user-specified fallback image if there is one.
		if ( window.console && window.console.error ) {
			var errLog = window.console.error;
			sowb.googleMapsData.ApiError = false;

			sowb.onLoadMapsApiError = function( error ) {
				var matchError;
				if ( typeof error === 'string' ) {
					matchError = error.match( /^Google Maps API (error|warning): ([^\s]*)\s([^\s]*)(?:\s(.*))?/ );
				}
				if ( matchError && matchError.length && matchError[0] ) {
					$( '.sow-google-map-canvas' ).each( function( index, element ) {
						var $this = $( element );
						if ( $this.data( 'fallbackImage' ) ) {
							var imgData = $this.data( 'fallbackImage' );
							if ( imgData.hasOwnProperty( 'img' ) ) {
								$this.append( imgData.img );
							}
						}
					} );
					sowb.googleMapsData.ApiError = true;
				}
				errLog.apply( window.console, arguments );
			};

			window.console.error = sowb.onLoadMapsApiError;
		}
		if ( soWidgetsGoogleMap.map_consent ) {
			// Remove previous map consent setup.
			if ( forceLoad ) {
				$( '.sow-google-map-consent button' ).off( 'click' );
			}
			$( '.sow-google-map-consent button' ).on( 'click', function() {
				$( '.sow-google-map-consent' ).remove();
				$( '.sow-google-map-canvas' ).show();
				if ( ! sowb.mapsApiInitialized ) {
					$( 'body' ).append( '<script async type="text/javascript" id="sow-google-maps-js" src="' + apiUrl + '">' );
					sowb.mapsApiInitialized = true;
				}
			} );
		} else {
			$( 'body' ).append( '<script async type="text/javascript" id="sow-google-maps-js" src="' + apiUrl + '">' );
			sowb.mapsApiInitialized = true;
		}
	}
	sowb.setupGoogleMaps();

	$( sowb ).on( 'setup_widgets', sowb.setupGoogleMaps );

});
