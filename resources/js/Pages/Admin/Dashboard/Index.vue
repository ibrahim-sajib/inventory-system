<script setup>
import { Head } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

</script>
<template>
   <Head :title="'Dashboard'" />
  <AdminLayout>
    <template #main>
      <div class="text-red border">Hello man from dashboard.....!</div>
    </template>
  </AdminLayout>
</template>
