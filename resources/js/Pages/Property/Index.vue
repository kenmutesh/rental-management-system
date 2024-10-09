<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


</script>

<template>
    <AuthenticatedLayout>
        <app-card title="Add Properties">
            <div class="flex gap-2">
                <div>
                    <input type="text" name="name" id="property_name" placeholder="Property name" class="">
                </div>
                <div>
                    <input type="number" step="1" name="units" id="units" placeholder="Total Units" class="">
                </div>
                <div>
                    <input type="text" name="location" id="location" placeholder="Property Location" class="">
                </div>
                <div>
                    <input type="text" name="name" id="property_name" placeholder="Property name" class="">
                </div>
            </div>
        </app-card>

        <app-card title="Manage Properties">
            test
        </app-card>
    </AuthenticatedLayout>
</template>
