<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { OfficeBuildingIcon } from '@heroicons/vue/outline';

// Fetching units from the Inertia page props
const { units, totalOccupied, totalUnits } = usePage().props;
</script>

<template>
    <Head title="Units" />
    <app-layout>
        <!-- Buttons -->
        <div class="flex justify-between mb-6">
            <Link
                href="/units/create"
                class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-800"
            >
                Add Unit
            </Link>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <OfficeBuildingIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Units</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalUnits }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <OfficeBuildingIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Occupied</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalOccupied }}</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow rounded-lg flex items-center dark:bg-gray-800">
                <OfficeBuildingIcon class="w-10 h-10 text-blue-500 mr-4" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Total Vacancies</h3>
                    <p class="text-2xl font-bold text-blue-500">{{ totalUnits - totalOccupied }}</p>
                </div>
            </div>
        </div>

        <!-- Units Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg dark:bg-gray-800 dark:border-gray-700">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">#</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Unit Name</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Status</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Price</th>
                        <th class="py-3 px-6 text-left text-sm font-medium text-gray-600 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(unit, index) in units.data" :key="unit.id" class="border-t dark:border-gray-700">
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ index + 1 }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ unit.name }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ unit.status }}</td>
                        <td class="py-4 px-6 text-sm text-gray-700 dark:text-gray-300">{{ unit.rentAmount }}</td>
                        <td class="py-4 px-6">
                            <Link
                                :href="`/units/edit/${unit.id}`"
                                class="text-blue-500 hover:text-blue-700 font-semibold mr-4 dark:text-blue-400 dark:hover:text-blue-600"
                            >
                                Edit
                            </Link>
                            <button class="text-red-500 hover:text-red-700 font-semibold dark:text-red-400 dark:hover:text-red-600" @click="deleteUnit(unit.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <app-pagination :pagination="units.meta" />
        </div>
    </app-layout>
</template>
