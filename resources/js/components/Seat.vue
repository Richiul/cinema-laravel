<template>
    <div @click="SelectSeat()" class="seat" :class="{selected: (this.isReserved) ? this.isReserved : this.isSelected}" :d-row="row" :d-col="col" :is-reserved="isReserved">

    </div>
</template>


<script>
    export default{
        name: 'Seat',
        components: {},
        props: {
            isReserved: Boolean,
            row: Number,
            col: String
        },
        methods: {
            SelectSeat() {
                this.isSelected = !this.isSelected
            }
        },
        data() {
            return {
                isSelected: false
            }
        }
    }
</script>



<style scoped>
    .seat {
        display: inline-block;
        width: 50px;
        height:50px;    
        margin: 2px;
        background-color: green;
    }

    .selected {
        background-color: red;
        cursor: not-allowed;
    }


</style>