<script setup>

</script>

<template>

    <div  class="container w-full pt-4 flex gap-3 self-start flex-1 justify-between !items-stretch">

        <main class="w-full min-h-full">
                <slot name="main" />
                <slot />
            </main>
    </div>
</template>