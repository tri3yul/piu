<script setup>
import GroupItem from '@/Components/app/GroupItem.vue';
import TextInput from '@/Components/TextInput.vue';
import GroupModal from '@/Components/app/GroupModal.vue'
import { ref } from 'vue';

const searchKeyword = ref('');
const showNewGroupModal = ref(false)

</script>

<template>
    <div class="flex gap-2 mt-4">
        <TextInput :model-value="searchKeyword" placeholder="Search groups" class="w-full" />
        <button
            @click="showNewGroupModal = true"
            class="text-sm bg-blue-500 hover:bg-blue-600 text-white rounded py-1 px-2 w-[120px]">
            new group
        </button>
    </div>
    <div class="mt-3 h-[200px] lg:flex-1 overflow-auto">
        <div v-if="false" class="text-gray-400 text-center p-3">
            You are not join any groups
        </div>
        <div v-else>
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <GroupItem image="https://picsum.photos/100" title="Para pencari kos"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit. " />
            <GroupItem image="https://picsum.photos/100" title="Para pencari magang"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
        </div>
    </div>

    <GroupModal v-model="showNewGroupModal" />
</template>

<style scoped>

</style>
