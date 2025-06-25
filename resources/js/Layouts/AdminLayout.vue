<script setup>
import Footer from '@/Components/Admin/Footer.vue';
import Navbar from '@/Components/Admin/Navbar.vue';
import Sidebar from '@/Components/Admin/Sidebar.vue';
import { ref } from 'vue';

const sidebarOpen = ref(false);

const handleSidebarOpen = () => {
    sidebarOpen.value = true;
}

</script>

<template>
    <div class="leading-normal tracking-normal" id="main-body">
      <div class="flex flex-wrap">
  
        <Sidebar />
  
        <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen flex flex-col justify-between" :class="sideBarOpen ? 'overlay' : ''" id="main-content">
  
          <Navbar :handle-sidebar-open="handleSidebarOpen" />
  
          <div class="p-6 bg-gray-100 flex-1">
            <slot name="main">

            </slot>
          </div>
  
          <Footer />
  
        </div>
      </div>
    </div>
  </template>