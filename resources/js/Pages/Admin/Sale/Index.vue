<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import Modal from '@/Components/Shared/Modal.vue';

const props = defineProps({
  sales: {
    type: Array,
    default: () => [],
  },
});

const showModal = ref(false);
const loading = ref(false);
const errors = reactive({});
const products = ref([]);
const productLoading = ref(false);

const saleForm = reactive({
  customer_name: '',
  paid: '',
  discount: '',
  vat: '',
  products: [],
});

const resetForm = () => {
  saleForm.customer_name = '';
  saleForm.paid = '';
  saleForm.discount = '';
  saleForm.vat = '';
  saleForm.products = [];
  Object.keys(errors).forEach(key => errors[key] = null);
};

const addProductRow = () => {
  saleForm.products.push({ product_id: '', quantity: 1 });
};

const removeProductRow = (idx) => {
  saleForm.products.splice(idx, 1);
};

const openModal = () => {
  resetForm();
  addProductRow();
  productLoading.value = true;
  router.get(
    route('admin:sales:index'),
    {},
    {
      only: ['products'],
      preserveState: true,
      onSuccess: (page) => {
        products.value = page.props.products;
        productLoading.value = false;
        showModal.value = true;
      },
      onError: () => {
        productLoading.value = false;
      },
    }
  );
};

const handleCreate = () => {
  loading.value = true;
  Object.keys(errors).forEach(key => errors[key] = null);
  router.post(route('admin:sales:store'), saleForm, {
    onSuccess: () => {
      showModal.value = false;
      resetForm();
    },
    onError: (err) => {
      Object.assign(errors, err);
    },
    onFinish: () => {
      loading.value = false;
    }
  });
};

const selectedProductIds = () => saleForm.products.map(item => item.product_id).filter(Boolean);
</script>

<template>
  <Head :title="'Sale List'" />
  <AdminLayout>
    <template #main>
      <button class="btn-primary mb-4" @click="openModal">Create Sale</button>
      <Modal
        :show="showModal"
        :handleClose="() => showModal = false"
        :handleProcess="handleCreate"
        :loading="loading"
        title="Create Sale"
        agreeButtonText="Create"
        cancelButtonText="Close"
        maxWidth="md"
      >
        <template #default>
          <div class="mb-4">
            <label class="block mb-1">Customer Name</label>
            <input v-model="saleForm.customer_name" type="text" class="border border-gray-400 rounded-md w-full p-2" required />
            <div class="text-xs text-red-500" v-if="errors.customer_name">{{ errors.customer_name }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Paid</label>
            <input v-model="saleForm.paid" type="number" class="border border-gray-400 rounded-md w-full p-2" required />
            <div class="text-xs text-red-500" v-if="errors.paid">{{ errors.paid }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Discount</label>
            <input v-model="saleForm.discount" type="number" class="border border-gray-400 rounded-md w-full p-2" />
            <div class="text-xs text-red-500" v-if="errors.discount">{{ errors.discount }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">VAT</label>
            <input v-model="saleForm.vat" type="number" class="border border-gray-400 rounded-md w-full p-2" />
            <div class="text-xs text-red-500" v-if="errors.vat">{{ errors.vat }}</div>
          </div>
          <div class="mb-4">
            <label class="block mb-1">Products</label>
            <div v-if="productLoading" class="text-gray-500">Loading products...</div>
            <div v-else>
              <div v-for="(item, idx) in saleForm.products" :key="idx" class="flex gap-2 mb-2">
                <select
                  v-model="item.product_id"
                  class="border border-gray-400 rounded-md p-2 w-1/2"
                  required
                >
                  <option value="">Select Product</option>
                  <option
                    v-for="product in products.filter(
                      p => !selectedProductIds().includes(p.id) || p.id === item.product_id
                    )"
                    :key="product.id"
                    :value="product.id"
                  >
                    {{ product.name }}
                  </option>
                </select>
                <input v-model="item.quantity" type="number" min="1" class="border border-gray-400 rounded-md p-2 w-1/4" placeholder="Qty" required />
                <button type="button" class="text-red-500" @click="removeProductRow(idx)" v-if="saleForm.products.length > 1">Remove</button>
              </div>
              <button type="button" class="btn-primary" @click="addProductRow">Add Product</button>
            </div>
            <div class="text-xs text-red-500" v-if="errors['products']">{{ errors['products'] }}</div>
          </div>
        </template>
      </Modal>
      <!-- Sales Table -->
      <table class="table-auto w-full border" v-if="sales.length">
        <thead>
          <tr>
            <th class="border px-4 py-2">Customer Name</th>
            <th class="border px-4 py-2">Subtotal</th>
            <th class="border px-4 py-2">Discount</th>
            <th class="border px-4 py-2">VAT</th>
            <th class="border px-4 py-2">Total</th>
            <th class="border px-4 py-2">Paid</th>
            <th class="border px-4 py-2">Due</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="sale in sales" :key="sale.id">
            <td class="border px-4 py-2">{{ sale.customer_name }}</td>
            <td class="border px-4 py-2">{{ sale.subtotal }}</td>
            <td class="border px-4 py-2">{{ sale.discount }}</td>
            <td class="border px-4 py-2">{{ sale.vat }}</td>
            <td class="border px-4 py-2">{{ sale.total }}</td>
            <td class="border px-4 py-2">{{ sale.paid }}</td>
            <td class="border px-4 py-2">{{ sale.due }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else>No sales found.</div>
    </template>
  </AdminLayout>
</template>