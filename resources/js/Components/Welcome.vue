<script setup>

import BarChart from "@/Components/BarChart.vue";
import {Link} from "@inertiajs/vue3";

const {patients} = defineProps(['patients']);

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
</script>

<template>
    <div>
        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
            <h1 class="mt-8 text-2xl font-medium text-gray-900">
                Monitor Pasien
            </h1>

            <p class="mt-6 text-gray-500 leading-relaxed">

            </p>
        </div>

        <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
            <ul role="list" class="divide-y divide-gray-100">
                <Link v-for="(patient, index) in patients" :key="index" :href="route('monitor.index', patient.id)">
                    <li class="flex flex-col gap-y-3 py-5">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-semibold">{{ patient.name }}</h3>
                                <p class="text-sm text-gray-600">{{ patient.membership_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm">Max Temp: {{ maxTemperature(patient.recent_temperature_readings) }}</p>
                                <p class="text-sm">Avg Temp: {{ avgTemperature(patient.recent_temperature_readings) }}</p>
                            </div>
                        </div>
                        <BarChart v-if="patient.recent_temperature_readings.length > 0" :readings="patient.recent_temperature_readings"/>
                    </li>
                </Link>
            </ul>
        </div>
    </div>
</template>
