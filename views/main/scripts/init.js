import { createMap } from './map.js';
import { createVehicleMarkers, bottomBarToggle } from './markers.js';
import { attachUserLocationControl } from './userLocation.js';
import enableMapPicker from './mapPicker.js';

const CENTER = { lat: 40.70922331914339, lng: 0.5771204885805513 };
const ZOOM = 15;

export function initMap() {
  const map = createMap('map', CENTER, ZOOM);

  // Create markers from real vehicles in the database
  createVehicleMarkers(map);
  
  bottomBarToggle(map);
  attachUserLocationControl(map)
    .locate({ desiredAccuracy: 30, maxWaitMs: 10000 })
    .catch((e) => {
      console.warn('Initial locate failed or timed out:', e);
    });

  // Enable isolated map picker module (handles pick-on-map button and filling inputs)
  enableMapPicker(map);
}

window.initMap = initMap;
