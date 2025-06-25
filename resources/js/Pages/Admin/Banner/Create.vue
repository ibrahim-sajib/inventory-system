<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { reactive } from "vue";

const state = reactive({
  imageModal: false,
  images: [],
});


</script>
<template>
  <Head title="Banner"/>
  <AdminLayout>
    <template #main>
      <div class="text-red border">Hello man from create page.....!</div>

      <button class="btn-primary">Upload modal</button>

    </template>
  </AdminLayout>

</template>
