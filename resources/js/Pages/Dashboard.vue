<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faArrowUp, faArrowDown } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

library.add(faArrowUp, faArrowDown);

onMounted(() => {
  const revenueExpensesCtx = document.getElementById('revenueExpensesChart').getContext('2d');
  const categoryRevenueCtx = document.getElementById('categoryRevenueChart').getContext('2d');
  const segmentRevenueCtx = document.getElementById('segmentRevenueChart').getContext('2d');

  // Create the revenue and expenses line chart
  new Chart(revenueExpensesCtx, {
    type: 'line',
    data: {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label: 'Revenue',
          data: [120, 190, 300, 210, 200, 300, 128],
          fill: false,
          borderColor: 'rgba(75, 192, 192, 1)',
          tension: 0.1,
        },
        {
          label: 'Expenses',
          data: [8000, 14000, 4000, 2500, 1800, 20000, 15000],
          fill: false,
          borderColor: 'rgba(255, 99, 132, 1)',
          tension: 0.1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });

  // Create the revenue by category chart
  new Chart(categoryRevenueCtx, {
    type: 'bar',
    data: {
      labels: ['Category A', 'Category B', 'Category C'],
      datasets: [
        {
          label: 'Revenue',
          data: [10000, 15000, 20000],
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });

  // Create the revenue by segment chart
  new Chart(segmentRevenueCtx, {
    type: 'pie',
    data: {
      labels: ['Segment A', 'Segment B', 'Segment C'],
      datasets: [
        {
          label: 'Revenue',
          data: [30000, 20000, 10000],
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
          ],
          borderColor: 'rgba(255, 255, 255, 1)',
          borderWidth: 2,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <div class="flex flex-col lg:flex-row">
      <!-- Left Section: Cards and Chart -->
      <div class="flex flex-col w-full lg:w-4/5 mb-4 lg:mb-0">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Card 1 -->
          <div class="card bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
              <i class="fas fa-dollar-sign text-green-500 text-3xl"></i>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Revenue</h2>
                <p class="text-gray-600">Total revenue: KES: 50,000</p>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="card bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
              <i class="fas fa-users text-blue-500 text-3xl"></i>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Users</h2>
                <p class="text-gray-600">New users: 1,200</p>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="card bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
              <i class="fas fa-chart-line text-purple-500 text-3xl"></i>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Growth</h2>
                <p class="text-gray-600">Monthly growth: 10%</p>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="card bg-white shadow-md rounded-lg p-6">
            <div class="flex items-center">
              <i class="fas fa-shopping-cart text-orange-500 text-3xl"></i>
              <div class="ml-4">
                <h2 class="text-lg font-semibold">Sales</h2>
                <p class="text-gray-600">Total sales: 5,000</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Chart below the cards -->
        <div class="mt-4 bg-white shadow-md rounded-lg p-6" style="height: 300px;">
          <h2 class="text-lg font-semibold">Revenue and Expenses Chart</h2>
          <canvas id="revenueExpensesChart" class="mt-4"></canvas>
        </div>
      </div>

      <!-- Right Section: Top Region Revenue -->
      <div class="w-full lg:w-1/5 lg:ml-4">
        <div class="bg-white shadow-md rounded-lg p-6 h-full">
          <h2 class="text-lg font-semibold">Top Region Revenue</h2>
          <ul class="mt-4">
            <li class="flex justify-between items-center text-gray-600">
              January: KES: 1,200
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              February: KES: 1,100
              <span class="text-gray-500">
                <FontAwesomeIcon icon="arrow-down" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              March: KES: 1,300
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              April: KES: 1,400
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              May: KES: 1,250
              <span class="text-gray-500">
                <FontAwesomeIcon icon="arrow-down" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              June: KES: 1,350
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              July: KES: 1,500
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              August: KES: 1,700
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              September: KES: 1,600
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              October: KES: 1,550
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              November: KES: 1,450
              <span class="text-gray-500">
                <FontAwesomeIcon icon="arrow-down" />
              </span>
            </li>
            <li class="flex justify-between items-center text-gray-600">
              December: KES: 1,300
              <span class="text-green-500">
                <FontAwesomeIcon icon="arrow-up" />
              </span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="flex flex-col lg:flex-row w-full mt-5 gap-3">
        <div class="w-full lg:w-3/7 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Top 3 Customers</h2>
            <ul class="mt-4">
            <li class="py-2">Customer A - KES: 10,000</li>
            <li class="py-2">Customer B - KES: 7,500</li>
            <li class="py-2">Customer C - KES: 5,000</li>
            </ul>
        </div>

        <div class="w-full lg:w-2/7 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Revenue by Category</h2>
            <div style="height: 250px;">
            <canvas id="categoryRevenueChart" class="mt-4"></canvas>
            </div>
        </div>

        <div class="w-full lg:w-2/7 bg-white shadow-md rounded-lg p-6">
            <h2 class="text-lg font-semibold">Revenue by Segment</h2>
            <div style="height: 250px;">
            <canvas id="segmentRevenueChart" class="mt-4"></canvas>
            </div>
        </div>
    </div>

  </AuthenticatedLayout>
</template>
