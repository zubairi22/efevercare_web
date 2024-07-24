<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import BarChart from "@/Components/BarChart.vue";
import {onMounted, ref} from "vue";

const {can,patient,chat} = defineProps(['can','patient', 'chat']);
const messages = ref(chat.messages)
const message = ref('');
const maxTemperature = (readings) => {
    if (readings.length === 0) return 0;
    return Math.max(...readings.map(reading => reading.temperature));
}

const avgTemperature = (readings) => {
    if (readings.length === 0) return 0;
    const temperatures = readings.map(reading => parseFloat(reading.temperature)).filter(temp => !isNaN(temp));
    const total = temperatures.reduce((sum, temp) => sum + temp, 0);
    return (total / temperatures.length).toFixed(2);
}

const sendMessage = () => {
    axios.post(route('monitor.messages.store', chat.id), {
        message: message.value,
    }).then(response => {
        message.value = '';
    });
};

onMounted(() => {
    Echo.channel(`chat.${chat.id}`)
        .listen('MessageSent', (e) => {
            messages.value.push(e.message)
        });
});
</script>

<template>
    <AppLayout title="Detail Monitor">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Monitor
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                        <h1 class="mt-8 text-2xl font-medium text-gray-900">
                            {{ patient.name }}
                        </h1>

                        <div class="grid grid-cols-2 gap-4 lg:p-8">
                            <div>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Membership Number: {{ patient.membership_number }}
                                </p>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Gender: {{ patient.gender }}
                                </p>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Date of Birth: {{ patient.date_of_birth }}
                                </p>
                            </div>

                            <div>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Phone Number: {{ patient.phone_number }}
                                </p>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Address: {{ patient.address }}
                                </p>
                                <p class="mt-2 text-gray-500 leading-relaxed">
                                    Email: {{ patient.email }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
                        <div class="flex justify-between items-center overflow-x-auto">
                            <div class="flex-grow">
                                <BarChart v-if="patient.recent_temperature_readings.length > 0" :readings="patient.recent_temperature_readings"/>
                            </div>
                            <div class="flex-shrink-0 ml-4">
                                <p class="text-sm">Max Temp: {{ maxTemperature(patient.recent_temperature_readings) }}</p>
                                <p class="text-sm">Avg Temp: {{ avgTemperature(patient.recent_temperature_readings) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
                        <!-- Chat interface -->
                        <div class="flex flex-col h-80 overflow-y-auto">
                            <div v-if="chat">
                                <!-- Loop through messages -->
                                <div v-for="message in messages" :key="message.id" class="mt-4">
                                    <div v-if="message.user_id === patient.id" class="flex justify-start items-start">
                                        <div class="bg-gray-100 text-gray-800 p-2 rounded-lg">
                                            <p class="text-sm">{{ message.message }}</p>
                                            <p class="text-xs text-gray-900">{{ message.user.name }}</p>
                                        </div>
                                    </div>
                                    <div v-else class="flex justify-end items-start">
                                        <div class="bg-blue-500 text-white p-2 rounded-lg">
                                            <p class="text-sm">{{ message.message }}</p>
                                            <p class="text-xs text-gray-900">{{ message.user.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <p>No messages yet.</p>
                            </div>
                        </div>

                        <!-- Chat input form -->
                        <form @submit.prevent="sendMessage" class="mt-4">
                            <input v-model="message" type="text" placeholder="Type your message..." class="p-2 border border-gray-300 rounded-lg w-full">
                            <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded-lg">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
