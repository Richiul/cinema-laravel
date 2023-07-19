<template>
    <div class="container">
        <reservation></reservation>
    </div>
</template>

<script>
    import Seat from './components/Seat.vue'
    import Reservation from './components/Reservation.vue';
    export default {
        components: {
            Seat,
            Reservation
        }
    }
</script>