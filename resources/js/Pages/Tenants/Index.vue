<script setup>
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import { AcademicCapIcon, CashIcon, DocumentTextIcon, PlusIcon } from '@heroicons/vue/outline';

// Tenants summary data
const tenantsSummary = ref({
  totalBalance: 5000,
  defaultLeases: 5,
});

// Get props from usePage
const { search, page, totalTenants, tenants: propsTenants } = usePage().props;

// Set initial values for searchQuery and pageNumber
const searchQuery = ref(search || '');
const pageNumber = ref(page || 1);

// Conditionally use ref or props for tenants
const tenants = ref(propsTenants);

// Watchers to update data when URL changes
const tenantUrl = computed(() => {
  let url = new URL(route('tenants.index'));
  url.searchParams.append('page', pageNumber.value);

  if (searchQuery.value) {
    url.searchParams.append('search', searchQuery.value);
  }

  return url;
});

// Fetch tenants on URL change
watch([tenantUrl, pageNumber], () => {
  router.get(tenantUrl.value.toString(), {
    preserveState: true,
    preserveScroll: true,
    onSuccess: (page) => {
      tenants.value = page.props.tenants;
    }
  });
});
</script>
<template>
  <Head title="Tenants" />
  <app-layout>
    <!-- Create Tenant Button -->
    <div class="flex mb-6">
      <Link href="/tenants/create" class="flex items-center bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 ml-auto">
        <PlusIcon class="w-5 h-5 mr-2" />
        Create Tenant
      </Link>
    </div>

    <div class="container mx-auto px-4">
      <!-- Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex items-center">
          <AcademicCapIcon class="h-16 w-16 text-blue-500 mr-2" />
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Tenants</h2>
            <p class="text-2xl text-gray-900 dark:text-gray-100">{{ totalTenants }}</p>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex items-center">
          <CashIcon class="h-16 w-16 text-green-500 mr-2" />
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Balance</h2>
            <p class="text-2xl text-gray-900 dark:text-gray-100">KES {{ tenantsSummary.totalBalance }}</p>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 flex items-center">
          <DocumentTextIcon class="h-16 w-16 text-yellow-500 mr-2" />
          <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Default Leases</h2>
            <p class="text-2xl text-gray-900 dark:text-gray-100">{{ tenantsSummary.defaultLeases }}</p>
          </div>
        </div>
      </div>

      <!-- Search Input -->
      <div class="mb-4">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search tenants..."
          class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-600"
        />
      </div>

      <!-- Tenants Table -->
      <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lease Expiration</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
            <tr v-for="(tenant, index) in tenants.data" :key="tenant.id">
              <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ index + 1 }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ tenant.name }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">KES {{ tenant.balance }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ tenant.lease_expiration }}</td>
              <td class="py-4 px-6">
                <Link :href="`/tenants/invoices/${tenant.id}`" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 mr-4">
                  View invoices
                </Link>
                <Link :href="`/tenants/edit/${tenant.id}`" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                  Edit
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-4">
        <app-pagination :pagination="tenants.meta" />
      </div>
    </div>
  </app-layout>
</template>
