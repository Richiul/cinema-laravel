<template>
    <div class="flex" style="justifyContent: space-around;">
        <div class="rounded overflow-hidden shadow-lg p-4" style="width:600px;">
            <img :src="'https://image.tmdb.org/t/p/w342' + movieData.poster_path" alt="movie_poster" style="height:400px;margin: auto;">
            <div class="px-6 py-4 overflow-hidden">
                <div class="font-bold text-xl mb-2 text-center">{{ movieData.title }}</div>
                <p class="text-gray-700 text-base">
                {{ movieData.overview }}
                </p>
            </div>
            <div class="px-6 pt-4 pb-2 text-center">
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ movieData.release_date }}</span>
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ movieData.vote_count }}</span>
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ movieData.vote_average }}/10</span>
            </div>
            <p :v-if="auditoriums.length > 0 " class="text-center">Auditorium: {{ auditoriums[this.movieId] }}</p>
        </div>
        <div class="p-4">
            <table class="table-auto">
            <tbody>
                <tr v-for="i in this.seats.nr_rows" :key="i">
                    <td v-for="j in this.seats.columns" :key="j">
                        <Seat 
                        :row="i" 
                        :col="j.column" 
                        :isReserved="checkIfSeatIsTaken(i, j.column)" 
                        @click="startReservation(i, j.column)" />  
                    </td>
                </tr>
            </tbody>
        </table> 
        <div v-if="currentSeats.length > 0" style="display: flex; gap: 50px">
            <ReservationTime ref="timeframeRef"></ReservationTime>
            <button  class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" @click.prevent="submitReservation">Reserve Seat</button>
        </div>

     
        <p v-if="errorMsg">Something went wrong!</p>
        <p v-if="responseMessage">{{ this.responseMessage }}</p>

        </div>
        <div  class="screen"></div>
    </div>
</template>

<script>
    import Seat from "./Seat.vue"
    import ReservationTime from "./ReservationTime.vue"

    export default{
        name: 'Reservation',
        components: {Seat, ReservationTime},

        mounted() {
            this.getMovieId()
            this.getReservedSeats()
            this.getMovieData()
            this.getAuditoriums()
            this.getSeats()
            
        },
        data() {
            return {
                movieId: null,
                errorMsg: null,
                responseMessage: null,
                loading: false,
                seats: [],
                reservedSeats: [],
                currentSeats: [],
                movieData: {},
                auditoriums: [],
                timeframeSelected: "",
            };
        },
        methods: {
            getMovieData() {
                axios.get("/api/movieData/" + this.movieId)
                .then(response => {
                    this.movieData = response.data
                    
                })
            },
            getMovieId () {
                this.movieId = window.location.href.split("/").slice(-1)[0];
            },
            getSeats() {
              
              this.seats = []
              axios.get("/api/seats")
              .then(response => {
                  this.seats = response.data.data
              })
          },
            getReservedSeats() {
                axios.get("/api/reservedSeats/" + this.movieId)
                .then(response => {
                    this.reservedSeats = response.data.reservedSeats
                })

            },

            getAuditoriums() {
                axios.get("/api/auditoriums")
                .then(response => {
                    this.auditoriums = response.data
                })
            },
          
            startReservation(i, j) {
                if (this.checkIfSeatIsTaken(i, j)) {
                    return
                }

                var obj = {
                    'row': i,
                    'col': j
                }

                const idx = this.currentSeats.findIndex(seat => seat.row == i && seat.col == j)
                if(idx == -1) {
                    this.currentSeats.push(obj)
                } else {
                    this.currentSeats.splice(idx)
                }

            },
            submitReservation() {
                this.timeframeSelected = this.$refs.timeframeRef.timeframes[this.$refs.timeframeRef.selectedTime[0]][this.$refs.timeframeRef.selectedTime[1]];
                axios.post("/api/reserve", 
                {   seats: this.currentSeats, 
                    movieId: this.movieId, 
                    auditorium: this.auditoriums[this.movieId],
                    timeframe: this.timeframeSelected
                })
                .then(response => {
                    this.responseMessage = response.data.message

                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                }).catch(error => {
                    this.errorMsg = 'something went wrong'
                })
            },
            checkIfSeatIsTaken(i, j) {

                const idx = this.reservedSeats.findIndex(seat => seat.row == i && seat.column == j)
                return (idx == -1) ? false : true
            }
        }
    }

</script>

<style scoped>

.screen {
  width: 10px;
  height: 500px;
  background-color: black;
  margin-top: 70px;
}
</style>