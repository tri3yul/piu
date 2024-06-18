<script setup>
import PostItem from '@/Components/app/PostItem.vue';
const post1 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/79.jpg',
        name: 'John Doe'
    },
    group: null,
    attachments: [
        {
            id: 1,
            name: 'test.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/png'
        },
        {
            id: 1,
            name: 'test.png',
            url: 'https://picsum.photos/1000',
            mime: 'image/png'
        },
        {
            id: 3,
            name: 'MyDocument.docx',
            url: '#',
            mime: 'application/msword'
        }
    ],
    body: `
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet. </p>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet. </p>
    `,
    created_at: '2024-06-18 08:39'
}
const post2 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/78.jpg',
        name: 'James Doe'
    },
    group: {
        id: 1,
        name: 'Para pencari takjil'
    },
    body: `
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet. </p>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet. </p>
    `,
    created_at: '2024-06-18 08:39'
}
</script>

<template>
    <div class="overflow-auto">
        <PostItem :post="post1" />
        <PostItem :post="post2" />
    </div>
</template>

<style scoped>

</style>
