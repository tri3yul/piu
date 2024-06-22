<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputTextArea from '@/Components/InputTextArea.vue';

const postCreating = ref(false);

const newPostForm = useForm({
    body: '',
})

function submit() {
    newPostForm.post(route('post.create'), {
        onSuccess: () => {
            newPostForm.reset();
        }
    });
}
</script>

<template>
    <div class="p-4 bg-white rounded-lg border mb-3">
        <InputTextArea @click="postCreating = true" class="mb-3 w-full" placeholder="Click to create post" rows="1" v-model="newPostForm.body" />
        <div v-if="postCreating" class="flex gap-2 justify-between">
            <button type="button" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 relative">
                Attach file
                <input type="file" class="absolute left-0 top-0 right-0 bottom-0 opacity-0" />
            </button>
            <button @click="submit" type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Submit
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
