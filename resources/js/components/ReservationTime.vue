<template>
    <table>
        <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="(value, key) in timeframes" :key="key">
            <td @click="selectTimeFrame(key, 0)" :class="{ 'selected': this.selectedTime[0] === key && this.selectedTime[1] === 0 }">{{ value[0] }}</td>
            <td @click="selectTimeFrame(key, 1)" :class="{ 'selected': this.selectedTime[0] === key && this.selectedTime[1] === 1 }">{{ value[1] }}</td>
        </tr>
        </tbody>
    </table>
</template>


<script>
    export default{
        name: 'ReservationTime',
        components: {},
        props: {
            isSelected: Boolean,
            row: Number,
            col: String
        },
        methods: {
            selectTimeFrame(row, col) {
                this.selectedTime[0] = row;
                this.selectedTime[1] = col;
            }
        },
        data() {
            return {
                selectedTime: [],
                isSelected: false,
                timeframes: [
                    ['10:30', '12:30'],
                    ['14:30', '16:30'],
                    ['18:30', '20:30'],
                    ['22:30', '00:30']
                ]
            }
        }
    }
</script>



<style scoped>

td{
    width: 50px;
    border: 1px solid black;
    text-align: center;

}
td:hover{
    cursor: pointer;
    background-color: red;
}

.selected {
    background-color: red;
    cursor: not-allowed;
}
</style>