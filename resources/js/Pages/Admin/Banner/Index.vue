<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';

</script>
<template>

  <Head :title="'Banner'"/>
  <AdminLayout>
    <template #main>
      <div class="text-red border">Hello man from banner page.....!</div>
      <button class="btn-primary" @click="router.get(route('admin:banners:create'))">go to create page</button>
    </template>
  </AdminLayout>
</template>
