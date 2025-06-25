<script setup>
import { computed } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    show: { type: Boolean, default: false },
    handleClose: { type: Function, required: true },
    handleProcess: { type: Function, default: () => {} },
    loading: { type: Boolean, default: false },
    title: { type: String, default: "" },
    maxWidth: { type: String, default: "sm" },
    closeable: { type: Boolean, default: true },
    showXMark: { type: Boolean, default: true },
    overlayOpacity: { type: String, default: "25" },
    agreeButtonText: { type: String, default: "わかった" },
    cancelButtonText: { type: String, default: "戻る" },
    titlePosition: { type: String, default: "left" },
});

const maxWidthClass = computed(() => {
    return {
        sm: "sm:max-w-screen-sm",
        md: "sm:max-w-screen-md",
        lg: "sm:max-w-screen-lg",
        xl: "sm:max-w-screen-xl",
        "2xl": "sm:max-w-screen-2xl",
    }[props.maxWidth];
});
</script>

<template>
    <TransitionRoot appear :show="show" as="template">
        <Dialog
            as="div"
            @close="() => closeable && handleClose()"
            class="relative z-10 custom h-full"
        >
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0"
                    :style="`background-color: #000000${overlayOpacity}`"
                />
            </TransitionChild>

            <div
                class="fixed inset-0 overflow-y-auto mx-auto"
                :class="maxWidthClass"
            >
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                        class="w-full"
                    >
                        <DialogPanel>
                            <slot name="main">
                                <div
                                    class="w-full transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                                >
                                    <slot name="header">
                                        <DialogTitle
                                            as="h3"
                                            class="text-lg font-medium leading-6 text-gray-900 relative mb-4 flex"
                                        >
                                            <slot name="title">
                                                <div
                                                    class="flex-1"
                                                    :class="`text-${titlePosition}`"
                                                >
                                                    {{ title }}
                                                </div>
                                            </slot>

                                            <XMarkIcon
                                                v-if="showXMark"
                                                @click="handleClose"
                                                class="w-6 h-6 text-red-500 absolute top-0 right-0 rounded-full cursor-pointer bg-white"
                                            />
                                        </DialogTitle>
                                    </slot>
                                    <slot>
                                        <div class="h-24"></div>
                                    </slot>
                                    <slot name="footer">
                                        <div
                                            class="flex justify-center items-center gap-4"
                                        >
                                            <button
                                                @click="handleClose"
                                                type="button"
                                                class="bg-red-500 text-white rounded-md px-4 py-2 w-fit min-w-[80px]"
                                            >
                                                {{ cancelButtonText }}
                                            </button>
                                            <button
                                                class="bg-indigo-500 text-white rounded-md px-4 py-2 w-fit flex justify-center min-w-[80px]"
                                                @click="handleProcess"
                                            >
                                                <span
                                                    v-if="loading"
                                                    class="w-6 h-6 rounded-full border-2 border-white border-t-transparent animate-spin block"
                                                ></span>
                                                <span v-else>{{
                                                    agreeButtonText
                                                }}</span>
                                            </button>
                                        </div>
                                    </slot>
                                </div>
                            </slot>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>
*::-webkit-scrollbar {
    display: none;
}
</style>
