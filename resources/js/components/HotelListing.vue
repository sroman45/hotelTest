<template>
    <div>
        <div v-if="hotels.length < 1" class="text-center"><h1>Your search returned no matches</h1></div>
        <div v-for="hotel in hotels" class="card mt-3">
            <div class="card-body">

                <!-- Hotel Section -->

                <div class="d-flex align-items-lg-start justify-content-start mb-3">
                    <div><img class="house-img" src="https://pmcvariety.files.wordpress.com/2018/07/bradybunchhouse_sc11.jpg?w=1000&h=563&crop=1" alt=""></div>
                    <div class="ml-4 address_section">
                        <div>
                            <h3>{{ hotel.name }}</h3>
                        </div>
                        <div>
                            {{ hotel.street_address }}, {{ hotel.city }}, {{ hotel.state }}
                        </div>
                        <div class="mt-lg-5">
                            <button @click="toggleRooms(hotel)" class="btn btn-primary point">Rooms / Availability</button>
                        </div>
                    </div>
                    <div class="ml-4 starting-price" v-text="'Starting at $' + getStartingPrice(hotel)">
                    </div>
                </div>

                <!-- End Hotel Section -->

                <!-- Room Section -->

                <div :id="'rooms_' + hotel.id" class="room-section">
                    <div v-for="room in hotel.rooms" class="room-row">
                        <div class="d-flex align-items-lg-start justify-content-start pt-2 pb-2">
                            <div class="w-25">{{ room.name }}</div>
                            <div class="w-25 ml-3 availability"><strong>{{ room.availability }}</strong></div>
                            <div class="ml-3"><button @click="toggleDetails(room)" class="btn btn-primary">DETAILS</button></div>
                            <div class="w-25 ml-3 text-center"><strong>${{ room.price }}</strong> Per Night</div>
                            <div class="ml-3">
                                <button
                                        @click="setRequestingRoom(room)"
                                        data-toggle="modal"
                                        data-target="#modal"
                                        class="btn btn-primary" :disabled="room.availability === 'SOLD OUT'">REQUEST</button>
                            </div>
                        </div>

                        <!-- Details Section -->

                        <div :id="'details_' + room.id" class="details mt-3">
                            <div class="d-flex align-items-lg-start justify-content-start pb-2">
                                <div class="w-75 mr-4">
                                    <strong>Conditions and Offers:</strong> <br>
                                    <ul>
                                        <li>Meal Plan: Breakfast Included</li>
                                    </ul>
                                    <strong>Cancellation Policy</strong> <br>
                                    <ul style="color: red">
                                        <li>Penalty of 1 booked night(s) when cancelling after November 25, 2016 04:00 PM</li>
                                    </ul>

                                </div>
                                <div class="text-right float-right ml-lg-5">
                                    Price: <br> Taxes 14%: <br> Fees: <br> <strong>Total:</strong>
                                </div>
                                <div class="text-right float-right ml-3">
                                    ${{ room.price }} <br>
                                    <span v-text="'$' + getTaxes(room.price)"></span> <br>
                                    $0.00 <br>
                                    <strong v-text="getTotal(room.price)"></strong>
                                </div>
                            </div>
                        </div>

                        <!-- End Detail Section -->

                    </div>
                </div>

                <!-- End Room Section -->

                <!-- Modal Section -->

                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ requestingRoom.name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div v-if="error !== ''" class="alert alert-danger text-center" role="alert">
                                    {{ error }}
                                </div>
                                <div class="form-group">
                                    <input v-model="name" type="text" class="form-control" id="name" placeholder="Full name">
                                </div>
                                <div class="form-group">
                                    <input v-model="email" type="text" class="form-control" id="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Card Number</label>
                                    <input v-model="creditCard" type="text" class="form-control" id="creditCard" placeholder="0000 0000 0000 0000">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-start">
                                <strong class="w-75 total-modal" v-text="'Total: $' + getTotal(requestingRoom.price)"></strong>
                                <button @click="submitRequest" type="button" class="btn btn-primary ml-5">Request</button>
                                <button id="dismiss" class="hidden" data-dismiss="modal"></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Modal Section -->

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "HotelListing",
        props: ['hotels'],
        data () {
            return {
                requestingRoom: {},
                name: '',
                email: '',
                creditCard: '',
                error: ''
            }
        },
        methods: {
            getStartingPrice(hotel) {
                let minPrice = 1000;
                hotel.rooms.forEach(room => {
                   if (room.price < minPrice)
                       minPrice = room.price;
                });
                return minPrice;
            },
            toggleRooms(hotel) {
                $('#rooms_' + hotel.id).toggle();
            },
            toggleDetails(room) {
                $('#details_' + room.id).toggle();
            },
            getTaxes(price) {
                let taxes = price * 0.14;
                return taxes.toFixed(2);
            },
            getTotal(price) {
                let taxes = price * 0.14;
                let total = taxes + price;
                return total.toFixed(2);
            },
            setRequestingRoom(room) {
                this.requestingRoom = room
            },
            submitRequest() {
                let self = this;

                if (this.valid())
                {
                    axios.post('/book', {
                        roomId: self.requestingRoom.id,
                        email: self.email,
                        name: self.name,
                        price: self.getTotal(self.requestingRoom.price),
                        creditCard: self.creditCard,
                    })
                        .then(response => {
                            console.log(response.data);
                            self.error = '';
                            $('#dismiss').click();
                        })
                        .catch(error => {
                            console.log(error);
                            console.log(error.data);
                            self.error = "Please confirm all fields are valid!";
                        })
                }
                else
                {
                    self.error = "All fields are required!"
                }

            },
            valid() {
                if (this.name === '' || this.creditCard === '' || this.email === '')
                    return false;
                return true;
            }
        },
        created() {
            // //handle get request
            // let url = new URLSearchParams(window.location.search);
            // let search = url.get('search');
            //
            // //check hotel name / address for match with search request
            // if (search !== null)
            // {
            //     for (let i = 0; i < this.hotels.length; i++)
            //     {
            //         if (!this.hotels[i].name.includes(search) && !this.hotels[i].street_address.includes(search) &&
            //             !this.hotels[i].city.includes(search) && !this.hotels[i].state.includes(search))
            //         {
            //             this.hotels.splice(i, 1);
            //             i--;
            //         }
            //     }
            // }
        },
        mounted() {

        }
    }
</script>

<style scoped lang="sass">
.point:hover
    cursor: pointer
.house-img
    max-width: 300px

.bottom-20
    bottom: 20px

.address_section
    width: 400px

.starting-price
    font-size: 20px
    font-weight: 500

.room-section
    display: none

.room-row
    border-top: 1px solid black
    border-bottom: 1px solid black

.availability
    font-weight: bold
    color: royalblue

.details
    display: none

.total-modal
    font-size: 22px

.hidden
    display: none !important
</style>