<template>
  <Head title="Expenses" />
  <app-layout>
    <div class="container mx-auto px-4 py-6">
      <!-- Hero Section -->
      <div class="mb-6 text-center">
        <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Manage Expenses</h1>
        <p class="text-gray-500 dark:text-gray-300">View and manage all your expenses.</p>
      </div>

      <!-- Total Expenses & Total Cost Cards -->
      <div class="mb-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Total Expenses Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Total Expenses</h3>
          <p class="mt-2 text-lg font-medium text-green-600">{{ totalExpenses }}</p>
        </div>

        <!-- Total Cost Card -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Total Cost</h3>
          <p class="mt-2 text-lg font-medium text-red-600">{{ totalCost }}</p>
        </div>
      </div>

      <!-- Filter Section -->
      <div class="mb-6 flex space-x-4 items-center">
        <div>
          <label for="startDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
          <input
            id="startDate"
            type="date"
            v-model="startDate"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
          />
        </div>

        <div>
          <label for="endDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
          <input
            id="endDate"
            type="date"
            v-model="endDate"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:text-white dark:border-gray-500"
          />
        </div>

        <button
          @click="filterExpenses"
          class="flex items-center bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300 ease-in-out dark:bg-blue-700 dark:hover:bg-blue-800"
        >
          Filter
        </button>
      </div>

      <!-- Add Expense Button -->
      <div class="mt-6 flex justify-end">
        <button
          @click="addExpense"
          class="flex items-center bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 ease-in-out dark:bg-green-700 dark:hover:bg-green-800"
        >
          <PlusIcon class="w-5 h-5 mr-2" />
          Add Expense
        </button>
      </div>

      <!-- Table Section: Displaying Expenses -->
      <div class="overflow-x-auto shadow-lg rounded-lg mt-6">
        <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500">
          <thead>
            <tr>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Expense #</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Description</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Amount</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Date</th>
              <th class="px-4 py-2 text-left text-sm font-medium text-gray-900 dark:text-gray-100">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="expense in filteredExpenses" :key="expense.id">
              <td class="px-4 py-2">{{ expense.expenseNumber }}</td>
              <td class="px-4 py-2">{{ expense.description }}</td>
              <td class="px-4 py-2">{{ expense.amount }}</td>
              <td class="px-4 py-2">{{ expense.date }}</td>
              <td class="px-4 py-2">
                <button
                  @click="viewExpenseDetails(expense.id)"
                  class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-500"
                >
                  View
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/outline'

export default {
  data() {
    return {
      startDate: '',
      endDate: '',
      expenses: [], // List of all expenses
      filteredExpenses: [], // Filtered expenses based on date range
      totalExpenses: 0, // Total expenses in the filtered range
      totalCost: 0, // Total cost in the filtered range
    }
  },
  methods: {
    filterExpenses() {
      // Filter expenses based on selected date range
      this.filteredExpenses = this.expenses.filter(expense => {
        const expenseDate = new Date(expense.date);
        const startDate = this.startDate ? new Date(this.startDate) : new Date('1900-01-01');
        const endDate = this.endDate ? new Date(this.endDate) : new Date();

        return expenseDate >= startDate && expenseDate <= endDate;
      });

      // Calculate total expenses and total cost
      this.calculateTotals();
    },
    calculateTotals() {
      this.totalExpenses = this.filteredExpenses.reduce((acc, expense) => acc + expense.amount, 0);
      this.totalCost = this.filteredExpenses.reduce((acc, expense) => acc + (expense.amount * 0.8), 0); // Example: 80% is the cost
    },
    addExpense() {
      // Logic for adding a new expense
      console.log('Adding a new expense...');
    },
    viewExpenseDetails(expenseId) {
      // Logic to view details of an expense
      console.log(`Viewing details for expense ID: ${expenseId}`);
    },
  },
  mounted() {
    // Mock data for expenses
    this.expenses = [
      { id: 1, expenseNumber: 'EXP123', description: 'Office Supplies', amount: 150, date: '2024-03-10' },
      { id: 2, expenseNumber: 'EXP124', description: 'Travel', amount: 300, date: '2024-03-15' },
      { id: 3, expenseNumber: 'EXP125', description: 'Software Subscription', amount: 200, date: '2024-04-05' },
      { id: 4, expenseNumber: 'EXP126', description: 'Marketing', amount: 400, date: '2024-04-10' },
    ];

    this.filterExpenses(); // Initial filter
  },
  filters: {
    currency(value) {
      return `$${value.toFixed(2)}`;
    },
    formatDate(value) {
      return new Date(value).toLocaleDateString();
    },
  },
}
</script>

<style scoped>
/* Add your custom styles here */
</style>
