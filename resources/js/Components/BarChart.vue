<template>
    <div class="w-full">
        <Bar :data="chartData" :options="chartOptions"/>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart, registerables } from 'chart.js';
import moment from "moment/min/moment-with-locales";

moment.locale("id");
Chart.register(...registerables);

const {readings} = defineProps({
    readings: {
        type: Array,
        required: true
    }
});

const chartData = computed(() => {
    return {
        labels: readings.map(reading => moment(reading.reading_time).format('LTS')),
        datasets: [
            {
                label: 'Temperature',
                backgroundColor: '#42A5F5',
                data: readings.map(reading => reading.temperature)
            }
        ]
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            title: {
                display: true,
                text: 'Temperature (°C)'
            },
            min:20,
            max:40
        }
    }
};
</script>
