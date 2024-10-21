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
          @click="createBackup"
          class="text-white bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"
        >
          Create Backup
        </button>
      </div>

      <!-- Backup List Section -->
      <div class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="backup in backups" :key="backup.id" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
          <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ backup.name }}</h4>
          <p class="mt-2 text-sm text-gray-500 dark:text-gray-300">{{ backup.date }}</p>
          <div class="mt-4">
            <button
              @click="restoreBackup(backup.id)"
              class="text-white bg-green-500 hover:bg-green-600 px-4 py-2 rounded-md transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"
            >
              Restore
            </button>
            <button
              @click="deleteBackup(backup.id)"
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

<script>
export default {
  data() {
    return {
      backups: [], // List of backups
      totalBackups: 0, // Total number of backups
    };
  },
  methods: {
    loadBackups() {
      // Mocked backup data
      this.backups = [
        { id: 1, name: 'Backup 1', date: '2024-10-20' },
        { id: 2, name: 'Backup 2', date: '2024-10-18' },
        { id: 3, name: 'Backup 3', date: '2024-10-15' },
      ];
      this.totalBackups = this.backups.length;
    },
    createBackup() {
      // Simulate API request to create a backup
      console.log('Creating a new backup...');

      // Simulate a new backup
      const newBackup = {
        id: this.backups.length + 1,
        name: `Backup ${this.backups.length + 1}`,
        date: new Date().toLocaleDateString(),
      };

      // Add the new backup to the list
      this.backups.push(newBackup);
      this.totalBackups = this.backups.length; // Update the total count

      // Optional: You can call an API here to create the backup on the server
      // axios.post('/api/backups', newBackup).then(response => {
      //   console.log('Backup created:', response.data);
      //   this.loadBackups(); // Reload backups after successful creation
      // }).catch(error => {
      //   console.error('Error creating backup:', error);
      // });
    },
    restoreBackup(backupId) {
      // Logic for restoring the selected backup
      console.log(`Restoring backup with ID: ${backupId}`);
    },
    deleteBackup(backupId) {
      // Logic for deleting the selected backup
      console.log(`Deleting backup with ID: ${backupId}`);
      // Remove the backup from the list
      this.backups = this.backups.filter((backup) => backup.id !== backupId);
      this.totalBackups = this.backups.length;
    },
  },
  mounted() {
    this.loadBackups(); // Load backups on page load
  },
}
</script>

<style scoped>
/* Additional custom styles */
</style>
