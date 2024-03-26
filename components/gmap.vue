<template>
    <div v-if="markerPosition">
        <GoogleMap api-key="AIzaSyAms-_Xd7G-79itu4w1DX9FusgvJOJiArc" style="width: 100%; height: 500px"
            :center="mapCenter" :zoom="15" @click="onMapClick">

            <InfoWindow :options="{ position: markerPosition, visible: infoWindowOpened }" >
                <template #default>
                    <div>
                        <p id="show-address">{{ showAddress }}</p>
                    </div>
                </template>
            </InfoWindow>
            <Marker ref="markerRef" :options="{ position: markerPosition, draggable: true }"
                @position_changed="onMarkerDragged" @click="onMarkerClick" />
        </GoogleMap>
    </div>
    <div v-else class="text-center text-muted">
        <i>กำลังค้นหาพื้นที่....</i>
    </div>
</template>

<script>
import axios from 'axios';
import { defineComponent, ref, onMounted } from "vue";
import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
import eventBus from '../components/event-bus.js';

export default defineComponent({
    components: { GoogleMap, Marker, InfoWindow },
    setup() {
        const mapCenter = ref(null);
        const markerPosition = ref(null);
        const markerRef = ref(null);
        const infoWindowOpened = ref(true);
        const showAddress = ref(null);
        const onMounted = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    mapCenter.value = { lat: position.coords.latitude, lng: position.coords.longitude };
                    markerPosition.value = { lat: position.coords.latitude, lng: position.coords.longitude };
                    showLL(mapCenter.value);
                }, (error) => {
                    console.error("An error occurred while retrieving location:", error);
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        };

        const onMapClick = (event) => {
            if (event && event.latLng) {
                markerPosition.value = {
                    lat: event.latLng.lat(),
                    lng: event.latLng.lng()
                };
                infoWindowOpened.value = true;
                showLL(markerPosition.value);
            }

        };

        const onMarkerDragged = (event) => {
            if (event && event.latLng) {
                markerPosition.value.lat = event.latLng.lat();
                markerPosition.value.lng = event.latLng.lng();
            }
            infoWindowOpened.value = true;
            showLL(markerPosition.value);
        };


        const onMarkerClick = () => {
            if (event && event.latLng) {
                markerPosition.value.lat = event.latLng.lat();
                markerPosition.value.lng = event.latLng.lng();
                showLL(markerPosition.value);
            }

        };

        const showLL = async (markerPosition) => {
            try {
                const response = await axios.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${markerPosition.lat},${markerPosition.lng}&language=th&key=${import.meta.env.VITE_YOUR_GOOGLE_MAPS_API_KEY}`);

                if (response.data.status === 'OK') {
                    const addressComponents = response.data.results[0].address_components;
                    const address = {
                        street: '',
                        district: '',
                        subdistrict: '',
                        province: '',
                        country: ''
                    };

                    // Loop through address components to get desired information
                    addressComponents.forEach(component => {
                        if (component.types.includes('route')) {
                            address.street = component.long_name;
                        } else if (component.types.includes('sublocality')) {
                            address.subdistrict = component.long_name;
                        } else if (component.types.includes('sublocality_level_1')) {
                            address.subdistrict = component.long_name;
                        } else if (component.types.includes('administrative_area_level_2')) {
                            address.district = component.long_name;
                        } else if (component.types.includes('administrative_area_level_1')) {
                            address.province = component.long_name;
                        } else if (component.types.includes('country')) {
                            address.country = component.long_name;
                        }
                    });

                    showAddress.value = response.data.results[0].formatted_address;
                    document.getElementById('show-address').innerHTML = showAddress.value;

                    console.log('showAddress',showAddress.value);
                } else {
                    console.error('Error occurred while fetching address:', response.data.error_message);
                }
            } catch (error) {
                console.error('An error occurred while fetching address:', error);
            }
        };

        onMounted();
        eventBus.markerPosition = markerPosition;
        return { mapCenter, markerPosition, markerRef, onMapClick, onMarkerDragged, onMarkerClick, infoWindowOpened };
    },
});
</script>
