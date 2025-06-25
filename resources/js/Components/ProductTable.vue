<script setup>
defineProps({
  products: {
    type: Array,
    default: () => [],
  },
  fields: {
    type: Array,
    default: () => [],
  },
});
</script>

<template>
  <table v-if="products.length" class="table-auto w-full border">
    <thead>
      <tr>
        <th
          v-for="field in fields"
          :key="field"
          class="border px-4 py-2"
        >
          {{ field }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="product in products" :key="product.id">
        <td
          v-for="field in fields"
          :key="field"
          class="border px-4 py-2"
        >
          {{ product[field] }}
        </td>
      </tr>
    </tbody>
  </table>
  <div v-else>No products found.</div>
</template>