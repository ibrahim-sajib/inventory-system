<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import Modal from '@/Components/Shared/Modal.vue';

defineProps({
  products: {
    type: Array,
    default: () => [],
  },
});

const showModal = ref(false);
const loading = ref(false);
const errors = reactive({});

const form = reactive({
  name: '',
  purchase_price: '',
  sell_price: '',
  stock: '',
});

const resetForm = () => {
  form.name = '';
  form.purchase_price = '';
  form.sell_price = '';
  form.stock = '';
  Object.keys(errors).forEach(key => errors[key] = null);
};

const handleClose = () => {
  showModal.value = false;
  resetForm();
};

const handleCreate = () => {
  loading.value = true;
  Object.keys(errors).forEach(key => errors[key] = null);
  router.post(route('admin:products:store'), form, {
    onSuccess: (page) => {
      showModal.value = false;
      resetForm();
      if (page?.flash?.success) {
        window.alert(page.flash.success);
      }
    },
    onError: (err) => {
      Object.assign(errors, err);
    },
    onFinish: () => {
      loading.value = false;
    }
  });
};
</script>

<template>
  <Head :title="'Product List'" />
  <AdminLayout>
    <template #main>
      <!-- Modal Open Button -->
      <button class="btn-primary mb-4" @click="showModal = true">
        Create Product
      </button>

      <!-- Modal Integration -->
      <Modal
        :show="showModal"
        :handleClose="handleClose"
        :handleProcess="handleCreate"
        :loading="loading"
        title="Create Product"
        agreeButtonText="Create"
        cancelButtonText="Close"
        maxWidth="sm"
      >
        <template #default>
          <div class="mb-4">
            <label class="block mb-1">Name</label>
            <input
              v-model="form.name"
              type="text"
              class="border border-gray-400 rounded-md w-full p-2"
              placeholder="Product name"
              required
            />
            <div class="text-xs text-red-500" v-if="errors.name">{{ errors.name }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Purchase Price</label>
            <input
              v-model="form.purchase_price"
              type="number"
              class="border border-gray-400 rounded-md w-full p-2"
              placeholder="Purchase price"
              required
            />
            <div class="text-xs text-red-500" v-if="errors.purchase_price">{{ errors.purchase_price }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Sell Price</label>
            <input
              v-model="form.sell_price"
              type="number"
              class="border border-gray-400 rounded-md w-full p-2"
              placeholder="Sell price"
              required
            />
            <div class="text-xs text-red-500" v-if="errors.sell_price">{{ errors.sell_price }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Stock</label>
            <input
              v-model="form.stock"
              type="number"
              class="border border-gray-400 rounded-md w-full p-2"
              placeholder="Stock"
              required
            />
            <div class="text-xs text-red-500" v-if="errors.stock">{{ errors.stock }}</div>
          </div>
        </template>
      </Modal>

      <!-- Product Table -->
      <table class="table-auto w-full border" v-if="products.length">
        <thead>
          <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Purchase Price</th>
            <th class="border px-4 py-2">Sell Price</th>
            <th class="border px-4 py-2">Stock</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in products" :key="product.id">
            <td class="border px-4 py-2">{{ product.name }}</td>
            <td class="border px-4 py-2">{{ product.purchase_price }}</td>
            <td class="border px-4 py-2">{{ product.sell_price }}</td>
            <td class="border px-4 py-2">{{ product.stock }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else>No products found.</div>
    </template>
  </AdminLayout>
</template>