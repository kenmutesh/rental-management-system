<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';

const backups = ref([]);
const totalBackups = ref(0);

const form = useForm();

const loadBackups = () => {
  backups.value = usePage().props.backups || [];
  totalBackups.value = backups.value.length;  // Update with the actual number of backups
};

const submitBackup = () => {
  form.post('/backups/create', {
    onSuccess: () => {
      loadBackups(); // Reload the backups list
    },
    onError: (errors) => {
      console.log('Error creating backup:', errors);
    },
  });
};

// Function to restore a backup
const restoreBackup = (backupName) => {
  console.log(`Restoring backup: ${backupName}`);
  // Add actual restore logic (e.g., an API call to restore the backup)
};

// Function to delete a backup
const deleteBackup = (backupName) => {
  console.log(`Deleting backup: ${backupName}`);
  // Add actual delete logic (e.g., an API call to delete the backup)

  // Remove the backup from the list
  backups.value = backups.value.filter((backup) => backup.name !== backupName);
  totalBackups.value = backups.value.length;  // Update the total backup count
};

// Load backups when the component is mounted
onMounted(() => {
  loadBackups();
});
</script>

<template>
  <Head title="Backups" />
  <app-layout>
    <div class="container mx-auto px-4 py-6">
      <!-- Hero Section -->
      <div class="mb-6 text-center">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Manage Backups</h1>
        <p class="text-gray-500 dark:text-gray-300">View and manage your system backups.</p>
      </div>

      <!-- Total Backups Card -->
      <div class="mb-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Total Backups</h3>
        <p class="mt-2 text-lg font-medium text-blue-600">{{ totalBackups }}</p>
      </div>

      <!-- Create Backup Button -->
      <div class="mb-6 text-right">
        <button
          @click="submitBackup"
          :disabled="form.processing"
          class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"
        >
          <span v-if="form.processing">Creating...</span>
          <span v-else>Create Backup</span>
        </button>
      </div>

      <!-- Backup List Section -->
      <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="backup in backups" :key="backup.name" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
          <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ backup.name }}</h4>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">{{ backup.date }}</p>
          <div class="mt-4">
            <button
              @click="restoreBackup(backup.name)"
              class="text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"
            >
              Restore
            </button>
            <button
              @click="deleteBackup(backup.name)"
              class="ml-2 text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-red-700 dark:hover:bg-red-800"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <!-- No Backups Message -->
      <div v-if="backups.length === 0" class="text-center text-gray-500 dark:text-gray-300">
        <p>No backups available.</p>
      </div>
    </div>
  </app-layout>
</template>
