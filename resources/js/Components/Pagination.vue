<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});
</script>

<template>
  <div v-if="pagination && pagination.links" class="pagination-container">
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
      <ul class="pagination-list">
        <template v-for="link in pagination.links" :key="link.label">
          <li v-if="link.label === '...'" :key="link.label">
            <span class="pagination-ellipsis">&hellip;</span>
          </li>
          <li v-else :key="link.label">
            <Link
              preserve-scroll
              preserve-state
              class="pagination-link"
              :aria-label="'Goto page ' + link.label"
              :class="{
                'is-current': link.active,
                'is-disabled': !link.url,
              }"
              :aria-current="link.active ? 'page' : null"
              :href="link.url || null"
              v-html="link.label"
            />
          </li>
        </template>
      </ul>
    </nav>
  </div>
</template>

<style scoped>
.pagination-container {
  display: flex;
  justify-content: center;
  margin: 20px 0;
}

.pagination {
  display: flex;
  align-items: center;
}

.pagination-list {
  list-style-type: none;
  display: flex;
  gap: 10px;
  padding: 0;
}

.pagination-link {
  padding: 10px 15px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
  color: #333;
  text-decoration: none;
  transition: background-color 0.3s, color 0.3s;
}

.pagination-link:hover {
  background-color: #007bff;
  color: white;
}

.is-current {
  background-color: #007bff;
  color: white;
  font-weight: bold;
}

.is-disabled {
  cursor: not-allowed;
  opacity: 0.5;
}

.pagination-ellipsis {
  padding: 10px 15px;
  color: #999;
}
</style>
