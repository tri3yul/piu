<script setup>
import FollowingItem from '@/Components/app/FollowingItem.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';

const searchKeyword = ref('');
</script>

<template>
    <TextInput :model-value="searchKeyword" placeholder="Search groups" class="w-full mt-4" />
    <div class="mt-3 h-[200px] lg:flex-1 overflow-auto">
        <div v-if="false" class="text-gray-400 text-center p-3">
            You don't have following yet.
        </div>
        <div v-else>
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim JIng In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
            <FollowingItem image="https://picsum.photos/100" title="Kim Ping In"
                description="Lorem ipsum dolor sit amet, consectetur adipisicing elit." />
        </div>
    </div>
</template>

<style scoped>

</style>
