<script setup>
import { computed, onMounted, onUpdated, reactive, ref, watch } from 'vue'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
import { XMarkIcon, PaperClipIcon, BookmarkIcon } from '@heroicons/vue/24/solid';
import InputTextArea from '@/Components/InputTextArea.vue';
import PostUserHeader from '@/Components/app/PostUserHeader.vue';
import { useForm } from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { isImage } from '@/helpers';

</script>

<template v-for="(myFile, ind) of attachmentFiles.slice(0, 4)">
    <div
        class="group aspect-square bg-gray-100 flex flex-col items-center justify-center text-gray-500 relative">
        <div v-if = "ind === 3"
            class="absolute left-0 top-0 right-0 bottom-0 z-10 bg-black/60 text-white flex items-center justify-center text-2xl">
            +{{ attachmentFiles.length -4 }} more
        </div>
        <button @click="removeFile(myFile)"
            class="absolute z-20 right-3 top-3 size-7 flex items-center justify-center bg-black/30 text-white rounded-full hover:bg-black/40">
            <XMarkIcon class="size-5" />

        </button>

        <img v-if="isImage(myFile.file)" :src="myFile.url"
            class="object-cover aspect-square" />
        <template v-else>
            <PaperClipIcon class="size-10 mb-3" />

            <small
                class="text-center">
                {{ myFile.file.name }}
            </small>
        </template>
    </div>
</template>
