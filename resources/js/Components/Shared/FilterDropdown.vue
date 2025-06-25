<script setup>
import { ref, watch } from 'vue'
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'


const props = defineProps({
    dropDownData: Array,
    default: {
      type: Number,
      default: 0,
    }
})
const emits = defineEmits(['getFilterData']);
const allStatus = props.dropDownData;
const selectedStatus = ref(allStatus[props.default]);

watch(
  () => selectedStatus.value.name,
  () => {
    emits('getFilterData', selectedStatus.value.name);
  }, {immediate: true}
);



</script>

<template>
  <Listbox v-model="selectedStatus">
    <div class="relative mt-1">
      <ListboxButton
        class="border w-full focus:ring-0 border-gray-300 rounded-md py-2 px-4 leading-tight focus:outline-none focus:bg-white text-left">
        <span class="block truncate">{{ selectedStatus.name }}</span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
          <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
        </span>
      </ListboxButton>

      <transition leave-active-class="transition duration-100 ease-in" leave-from-class="opacity-100"
        leave-to-class="opacity-0">
        <ListboxOptions
          class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white z-10 py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
          <ListboxOption v-slot="{ active, selected }" v-for="status in allStatus" :key="status.name" :value="status"
            as="template" class="cursor-pointer">
            <li :class="[
              active ? 'bg-indigo-500 text-white' : 'text-gray-900',
              'relative cursor-default select-none py-2 pl-10 pr-4',
            ]">
              <span :class="[
                selected ? 'font-medium' : 'font-normal',
                'block truncate',
              ]">{{ status.name }}</span>
              <span v-if="selected" class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-500">
                <CheckIcon class="h-5 w-5" aria-hidden="true" />
              </span>
            </li>
          </ListboxOption>
        </ListboxOptions>
      </transition>
    </div>
  </Listbox>
</template>

  