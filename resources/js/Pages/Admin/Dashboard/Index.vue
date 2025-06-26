<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

const props = defineProps({
  report: {
    type: Object,
    default: () => ({
      from: '',
      to: '',
      total_sales: 0,
      total_expenses: 0,
      journals: [],
    }),
  },
});

import { ref, computed } from 'vue';

const from = ref(props.report.from);
const to = ref(props.report.to);

const sortedDates = computed(() => {
  if (!from.value && !to.value) return { from: props.report.from || '', to: props.report.to || '' };
  if (!from.value) return { from: props.report.from || '', to: to.value || '' };
  if (!to.value) return { from: from.value || '', to: props.report.to || '' };
  return from.value <= to.value
    ? { from: from.value, to: to.value }
    : { from: to.value, to: from.value };
});

const filterReport = () => {
  router.get(
    route('admin:dashboard:index'),
    { from: sortedDates.value.from, to: sortedDates.value.to },
    { preserveState: true, preserveScroll: true }
  );
};
</script>

<template>
  <Head :title="'Dashboard'" />
  <AdminLayout>
    <template #main>
      <div class="mb-6">
        <h2 class="text-2xl font-bold mb-2">Financial Report</h2>
        <div class="flex flex-col sm:flex-row items-center gap-2 mb-4">
          <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">From:</label>
            <input type="date" v-model="from" class="border rounded px-2 py-1" />
          </div>
          <div class="flex items-center gap-2">
            <label class="text-sm text-gray-600">To:</label>
            <input type="date" v-model="to" class="border rounded px-2 py-1" />
          </div>
          <button class="btn-primary px-4 py-1 rounded" @click="filterReport">Filter</button>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
          <div class="bg-white rounded shadow p-5 flex flex-col items-center">
            <div class="text-gray-500 text-sm mb-1">Total Sales</div>
            <div class="text-2xl font-bold text-green-600">৳ {{ Number(props.report.total_sales).toLocaleString() }}</div>
          </div>
          <div class="bg-white rounded shadow p-5 flex flex-col items-center">
            <div class="text-gray-500 text-sm mb-1">Total Expenses</div>
            <div class="text-2xl font-bold text-red-600">৳ {{ Number(props.report.total_expenses).toLocaleString() }}</div>
          </div>
        </div>
        <div class="bg-white rounded shadow p-4 overflow-x-auto">
          <h3 class="text-lg font-semibold mb-3">Journal Entries</h3>
          <table class="min-w-full text-sm">
            <thead>
              <tr class="bg-gray-100">
                <th class="py-2 px-3 text-left">Date</th>
                <th class="py-2 px-3 text-left">Type</th>
                <th class="py-2 px-3 text-left">Account</th>
                <th class="py-2 px-3 text-right">Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="journal in props.report.journals" :key="journal.id" class="border-b">
                <td class="py-2 px-3">{{ new Date(journal.created_at).toLocaleDateString() }}</td>
                <td class="py-2 px-3 capitalize">{{ journal.type }}</td>
                <td class="py-2 px-3 capitalize">{{ journal.account }}</td>
                <td class="py-2 px-3 text-right">৳ {{ Number(journal.amount).toLocaleString() }}</td>
              </tr>
              <tr v-if="!props.report.journals.length">
                <td colspan="4" class="py-4 text-center text-gray-400">No journal entries found.</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </template>
  </AdminLayout>
</template>
