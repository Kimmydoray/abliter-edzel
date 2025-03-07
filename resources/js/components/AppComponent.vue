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
                <p v-if="!isOpen" class="text-muted">Next opening in: <strong>{{ timeUntilOpen }}</strong></p>

                <!-- Date Picker for Checking Availability -->
                <h4 class="mt-4">Check Opening Hours</h4>
                <input type="date" v-model="selectedDate" class="form-control w-50 mx-auto" @change="checkStoreStatus">
                <p class="mt-2">{{ checkMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AppComponent",

    data() {
        return {
            message: "Welcome to the Bakery!",
            isOpen: false,
            nextOpeningTime: "Monday, 08:00 AM",
            timeUntilOpen: "1 Hour",
            checkMessage: "None"
        };
    },

    created() {
        console.log("ExampleComponent is loaded!");
    }
};
</script>