<script setup>
import { Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    user: Object,
    forApprove: {
        type: Boolean,
        default: false
    }
});

defineEmits(['approve'])

</script>

<template>
    <div
        class="cursor-pointer bg-white transition-all border-2 border-transparent hover:border-blue-500"
    >
        <Link
            :href="route('profile', user.username)"
            class="flex items-center gap-2 py-2 px-2"
        >
            <img :src="user.avatar_url || '/img/avatar-1.webp'"
                class="w-[32px] rounded-full" />

            <div class="flex justify-between flex-1">
                <h3
                    class="font-black"
                >
                    {{ user.name }}
                </h3>

                <div
                    class="flex gap-1"
                >
                    <button
                        v-if="forApprove"
                        @click.prevent.stop="$emit('approve', user)"
                        class="text-xs py-1 px-2 rounded bg-blue-500 hover:bg-blue-600 text-white"
                    >
                        approve
                    </button>

                    <button
                        v-if="forApprove"
                        @click.prevent.stop="$emit('reject', user)"
                        class="text-xs py-1 px-2 rounded bg-red-500 hover:bg-red-600 text-white"
                    >
                        reject
                    </button>
                </div>
            </div>
        </Link>
    </div>
</template>

<style scoped>

</style>
