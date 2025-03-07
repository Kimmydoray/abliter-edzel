<template>
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h2>Bakery App - Abliter, Edzel</h2>
            </div>
            <div class="card-body">
                <!-- Store Status Widget -->
                <h3 class="text-primary">Current Store Status</h3>
                <h4 :class="{'text-success': isOpen, 'text-danger': !isOpen}">
                    {{ isOpen ? 'Open' : 'Closed' }}
                </h4>
                <p v-if="!isOpen" class="text-muted">Next opening in: <strong>{{ timeUntilOpen }} from now</strong></p>

                <!-- Date Picker for Checking Availability -->
                <h4 class="mt-4">Check Opening Hours</h4>
                <input type="date" v-model="selectedDate" class="form-control w-50 mx-auto" @change="checkStoreStatus">
                <p class="mt-2">{{ checkMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "AppComponent",

    data() {
        return {
            message: "Welcome to the Bakery!",
            isOpen: false,
            nextOpeningTime: "Monday, 08:00 AM",
            timeUntilOpen: "1 Hour",
            checkMessage: "",
            selectedDate: ""
        };
    },

    created() {
        console.log("ExampleComponent is loaded!");
        this.fetchStoreStatus();
    },

    methods: {
        async fetchStoreStatus() {
            try {
                const response = await axios.get("http://localhost:8000/api/store-status");
                this.isOpen = response.data.is_open;
                this.nextOpeningTime = response.data.next_opening_time;
                this.timeUntilOpen = response.data.time_remaining;
            } catch (error) {
                console.error("Error fetching store status:", error);
            }
        },

        async checkStoreStatus() {
            try {
                const response = await axios.post("http://localhost:8000/api/check-store-status", {
                    date: this.selectedDate
                });
                this.checkMessage = response.data.message + ' ' + this.selectedDate;
                
            } catch (error) {
                console.error("Error fetching store status:", error);
            }
        }
    }
};
</script>